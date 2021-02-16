<?php

namespace Acadelib\Modularity;

use Illuminate\Filesystem\Filesystem;

class ModuleManager
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new module manager instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Get all modules.
     *
     * @return array
     */
    public function scan()
    {
        $modules = [];

        foreach ($this->getDirectories() as $directory) {
            $manifest = $this->getManifest($directory);
            $modules[$manifest->name] = new Module($manifest->name, $directory);
        }

        return $modules;
    }

    /**
     * Get all directories.
     *
     * @return array
     */
    protected function getDirectories()
    {
        return $this->files->directories(config('modularity.module_path'));
    }

    /**
     * Get the manifest for the given module path.
     *
     * @param  string  $directory
     * @return mixed
     */
    protected function getManifest($directory)
    {
        return json_decode($this->files->get($directory.'/module.json'));
    }
}
