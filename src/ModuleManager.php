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
     * Scan module path to detect modules.
     *
     * @return array
     */
    protected function scan()
    {
        $modules = [];

        foreach ($this->getDirectories() as $directory) {
            $manifest = $this->getManifest($directory);
            $modules[$manifest->name] = new Module($manifest);
        }

        return $modules;
    }

    /**
     * Get all modules.
     *
     * @return array
     */
    public function all()
    {
        return $this->scan();
    }

    /**
     * Enable the given module.
     *
     * @param  string  $name
     * @return void
     */
    public function enable($name)
    {
        foreach ($this->scan() as $module) {
            if ($module->getName() == $name) {
                $module->enable();
            }
        }
    }

    /**
     * Disable the given module.
     *
     * @param  string  $name
     * @return void
     */
    public function disable($name)
    {
        foreach ($this->scan() as $module) {
            if ($module->getName() == $name) {
                $module->disable();
            }
        }
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
     * @return \Acadelib\Modularity\Manifest
     */
    protected function getManifest($directory)
    {
        return new Manifest($this->files, $directory);
    }
}
