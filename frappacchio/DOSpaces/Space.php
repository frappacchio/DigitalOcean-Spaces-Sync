<?php

namespace frappacchio\DOSpaces;

/**
 * Class Space
 *
 * @package frappacchio\DOSpaces
 *
 * @property \League\Flysystem\Filesystem $fileSystem
 * @property string                       $key
 * @property string                       $secret
 * @property string                       $endpoint
 * @property string                       $container
 * @property string                       $storagePath
 * @property string                       $storageFileOnly
 * @property string                       $storageFileDelete
 * @property string                       $filter
 * @property string                       $uploadUrlPath
 * @property string                       $uploadPath
 * @property boolean                      $fileVisibility
 */
class Space
{
    public $fileSystem;
    public $key;
    public $secret;
    public $endpoint;
    public $container;
    public $storagePath;
//    public $storageFileOnly;
//    public $storageFileDelete;
    public $filter;
//    public $uploadUrlPath;
//    public $uploadPath;
    public $fileVisibility = 'public';


    public function __construct(
        $key,
        $secret,
        $container,
        $endpoint,
        $storagePath,
//        $storageFileOnly,
//        $storageFileDelete,
        $filter
//        $uploadUrlPath,
//        $uploadPath
    ) {
        $this->key               = $key;
        $this->secret            = $secret;
        $this->endpoint          = $endpoint;
        $this->container         = $container;
        $this->storagePath       = $storagePath;
//        $this->storageFileOnly   = $storageFileOnly;
//        $this->storageFileDelete = $storageFileDelete;
        $this->filter            = $filter;
//        $this->uploadUrlPath     = $uploadUrlPath;
//        $this->uploadPath        = $uploadPath;
    }

    public function upload($file)
    {
        if ( ! empty($this->filter) && $this->filter !== '*' && ! preg_match($this->filter, $file)) {
            return $this->fileSystem->put($file, file_get_contents($file), [
                'visibility' => $this->fileVisibility
            ]);
        } else {
            return false;
        }
    }

    public function exists($file)
    {

    }

    public function delete($file)
    {
        try {
            return $this->fileSystem->delete($file);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function __get($name)
    {
        if ($name === 'fileSystem' && empty($this->fileSystem) && ! empty($this->key) && ! empty($this->container) && ! empty($this->endpoint)) {
            return $this->fileSystem = FileSystem::getInstance($this->key, $this->secret, $this->container,
                $this->endpoint);
        } elseif ($name === 'fileSystem') {
            return false;
        }

        return ! empty($this->$name) ? $this->$name : null;
    }
}