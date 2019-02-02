<?php

namespace frappacchio\DOSWordpress;

use frappacchio\DOSpaces\Space;

/**
 * Class PluginFiltersAndActions
 * @package frappacchio\DOSWordpress
 * @property Space $fileSystem
 */
class PluginFiltersAndActions
{
    /**
     * @var Space;
     */
    private $fileSystem;

    /**
     * PluginFiltersAndActions constructor.
     */
    public function __construct()
    {
        $this->addActions();
        $this->addFilters();
    }

    /**
     * Binds Wordpress actions for add attachment and delete attachment
     */
    public function addActions()
    {
        add_action('add_attachment', [$this, 'action_add_attachment'], 20, 1);
        add_action('delete_attachment', [$this, 'action_delete_attachment'], 20, 1);
    }

    /**
     * Add filter in order to save all image formats in metadata
     */
    public function addFilters()
    {
        add_filter('wp_update_attachment_metadata', [$this, 'filter_wp_update_attachment_metadata'], 20, 1);
    }

    /**
     * Check for image formats in metadata and save all of them
     * @param $metadata
     * @return array
     */
    public function filter_wp_update_attachment_metadata($metadata)
    {
        foreach ($this->getPaths($metadata) as $filePath) {
            $this->fileUpload($filePath);
        }
        return $metadata;
    }

    /**
     * Checks for other images formats in the metadata array and returns them as array
     * with a list of file path to local folder
     * @param array $metadata
     * @return array
     */
    private function getPaths($metadata)
    {
        $paths = [];
        $upload_dir = wp_upload_dir();
        if (isset($metadata['file'])) {
            $path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $metadata['file'];
            array_push($paths, $path);
            $file_info = pathinfo($path);
            $basepath = isset($file_info['extension']) ? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $path) : $path;
        }
        if (isset($metadata['sizes'])) {
            foreach ($metadata['sizes'] as $size) {
                if (isset($size['file'])) {
                    $path = $basepath . $size['file'];
                    array_push($paths, $path);
                }
            }
        }
        return $paths;
    }

    private function uploadFilePath($filePath)
    {
        return str_replace(PluginSettings::get('upload_path'),'',$filePath);
    }

    /**
     * Upload a file to the space and delete it from local folder if this is setted from
     * the settings page
     * @param string $filePath
     */
    private function fileUpload($filePath)
    {
        if (empty($this->fileSystem)) {
            $this->fileSystem = $this->getFileSystem();
        }
        $this->fileSystem->upload($filePath,$this->uploadFilePath($filePath));
        if (PluginSettings::get('dos_storage_file_only')) {
            unlink($filePath);
        }
    }

    /**
     * Returns a space instance (ex. Digitalocean space instance), as file system instance
     * to use it for others actions
     * @return Space
     */
    private function getFileSystem()
    {
        return new Space(
            PluginSettings::get('dos_key'),
            PluginSettings::get('dos_secret'),
            PluginSettings::get('dos_container'),
            PluginSettings::get('dos_endpoint'),
            PluginSettings::get('dos_storage_path'),
            PluginSettings::get('dos_filter')
        );
    }

    /**
     * Save the file by it's Wordpress ID identifier
     * @param int $postID
     * @return bool
     */
    public function action_add_attachment($postID)
    {
        if (wp_attachment_is_image($postID) == false) {
            $this->fileUpload(get_attached_file($postID));
        }
        return true;
    }

    /**
     * Delete the file and all its related formats by it's Wordpress ID identifier
     * @param int $postID
     * @return bool
     */
    public function action_delete_attachment($postID)
    {
        if (empty($this->fileSystem)) {
            $this->fileSystem = $this->getFileSystem();
        }
        if (wp_attachment_is_image($postID) == false) {
            $file = get_attached_file($postID);
            return $this->fileSystem->delete($file);
        } else {
            $metadata = wp_get_attachment_metadata($postID);
            foreach ($this->getPaths($metadata) as $filepath) {
                if (!$this->fileSystem->delete($filepath)) {
                    return false;
                }
            }
            return true;
        }
    }
}