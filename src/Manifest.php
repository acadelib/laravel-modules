<?php

namespace Acadelib\Modularity;

use Illuminate\Filesystem\Filesystem;

class Manifest
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The manifest path.
     *
     * @var string
     */
    protected $path;

    /**
     * The manifest's attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new manifest instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $path
     * @return void
     */
    public function __construct(Filesystem $files, $path)
    {
        $this->files = $files;
        $this->path = $path;
        $this->attributes = $this->getAttributes();
    }

    /**
     * Save the current state of the manifest.
     *
     * @return void
     */
    protected function save()
    {
        $this->files->put($this->getPath(), json_encode($this->attributes, JSON_PRETTY_PRINT));
    }

    /**
     * Get the path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path.'/module.json';
    }

    /**
     * Get the manifest.
     *
     * @return string
     */
    protected function getManifest()
    {
        return $this->files->get($this->getPath());
    }

    /**
     * Convert the manifest's attributes to an array
     *
     * @return array
     */
    protected function getAttributes()
    {
        return json_decode($this->getManifest(), true);
    }

    /**
     * Dynamically access the manifest's attributes.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attributes[$key];
    }

    /**
     * Dynamically set an attribute on the manifest.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
        $this->save();
    }
}
