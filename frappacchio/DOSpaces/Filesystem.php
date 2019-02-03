<?php

namespace frappacchio\DOSpaces;

/**
 * Class Filesystem
 *
 * @package frappacchio\DOSpaces
 *
 * @property Space $fileSystem
 * @property string $key
 * @property string $secret
 * @property string $endpoint
 * @property string $container
 * @property string $storagePath
 * @property string $storageFileOnly
 * @property string $storageFileDelete
 * @property string $filter
 * @property string $uploadUrlPath
 * @property string $uploadPath
 * @property boolean $fileVisibility
 */
class Filesystem
{
    /**
     * @var Space
     */
    public $fileSystem;
    /**
     * @var string
     */
    public $key;
    /**
     * @var string
     */
    public $secret;
    /**
     * @var string
     */
    public $endpoint;
    /**
     * @var string
     */
    public $container;
    /**
     * @var string
     */
    public $storagePath;
    /**
     * @var string
     */
    public $filter;
    /**
     * @var string
     */
    public $fileVisibility = 'public';

    /**
     * Space constructor.
     * @param string $key
     * @param string $secret
     * @param string $container
     * @param string $endpoint
     * @param string $storagePath
     * @param string $filter
     */
    public function __construct(
        $key,
        $secret,
        $container,
        $endpoint,
        $storagePath,
        $filter
    )
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->endpoint = $endpoint;
        $this->container = $container;
        $this->storagePath = $storagePath;
        $this->filter = $filter;
        $this->fileSystem = Space::getInstance($this->key, $this->secret, $this->container, $this->endpoint);
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function upload($fileUpload, $fileName = '')
    {
        if(empty($fileName)){
            $fileName = $fileUpload;
        }
        if (!empty($fileName)) {
            if(!empty($this->filter) && ($this->filter !== '*' && !preg_match($this->filter, $fileName))){
                return false;
            }
            return $this->fileSystem->put($fileName, file_get_contents($fileUpload), [
                'visibility' => $this->fileVisibility
            ]);
        } else {
            return false;
        }
    }

    /**
     * @param $file
     */
    public function exists($file)
    {

    }

    /**
     * Write a brand new file on space file system
     * @param string $path
     * @param string $contents
     * @param array $config
     * @return bool
     */
    public function write($path, $contents, array $config = [])
    {
        try{
            return $this->fileSystem->write($path,$contents,$config);
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * @param $file
     * @return bool
     */
    public function delete($file)
    {
        try {
            return $this->fileSystem->delete($file);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $name
     * @return bool|\League\Flysystem\Filesystem|null
     */
    public function __get($name)
    {
        if ($name === 'fileSystem' && empty($this->fileSystem) && !empty($this->key) && !empty($this->container) && !empty($this->endpoint)) {
            return $this->fileSystem = FileSystem::getInstance($this->key, $this->secret, $this->container,
                $this->endpoint);
        } elseif ($name === 'fileSystem') {
            return false;
        }

        return !empty($this->$name) ? $this->$name : null;
    }
}