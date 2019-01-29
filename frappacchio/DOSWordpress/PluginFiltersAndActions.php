<?php

namespace frappacchio\DOSWordpress;

use frappacchio\DOSpaces\Space;

class PluginFiltersAndActions
{
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
        add_action('add_attachment', [$this, 'action_add_attachment'], 10, 1);
        add_action('delete_attachment', [$this, 'action_delete_attachment'], 10, 1);
    }

    /**
     * Add filter in order to save all image formats in metadata
     */
    public function addFilters()
    {
        add_filter('wp_update_attachment_metadata', [$this, 'filter_wp_update_attachment_metadata'], 20, 1);
    }

    /**
     * Returns a space instance (ex. Digitalocean space instance), as file system instance
     * to use it for others actions
     * @return Space
     */
    private function getFileSystem(){
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
     * Checks for other images formats in the metadata array and returns them as array
     * with a list of file path to local folder
     * @param array $metadata
     * @return array
     */
    private function getPaths($metadata)
    {
        $paths      = [];
        $upload_dir = wp_upload_dir();
        if (isset($metadata['file'])) {
            $path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $metadata['file'];
            array_push($paths, $path);
            $file_info = pathinfo($path);
            $basepath = isset($file_info['extension'])? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $path):$path;
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

    /**
     * Check for image formats in metadata and save all of them
     * @param $metadata
     * @return array
     */
    public function filter_wp_update_attachment_metadata($metadata)
    {
        $fileSystem = $this->getFileSystem();
        foreach ($this->getPaths($metadata) as $filepath) {
            $fileSystem->upload($filepath);
        }
        return $metadata;
    }

    /**
     * Save the file by it's Wordpress ID identifier
     * @param int $postID
     * @return bool
     */
    public function action_add_attachment($postID)
    {
        if (wp_attachment_is_image($postID) == false) {
            $fileSystem = $this->getFileSystem();
            $file = get_attached_file($postID);
            return $fileSystem->upload($file);
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
        $fileSystem = $this->getFileSystem();
        if (wp_attachment_is_image($postID) == false) {
            $file = get_attached_file($postID);
            return $fileSystem->delete($file);
        } else {
            $metadata = wp_get_attachment_metadata($postID);
            foreach ($this->getPaths($metadata) as $filepath) {
                if(!$fileSystem->delete($filepath)){
                    return false;
                }
            }
            return true;
        }
    }
}