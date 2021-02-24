<?php

namespace Acadelib\Modularity;

use Acadelib\Modularity\Exceptions\ModuleNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

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
     * Find a module by its name.
     *
     * @param  string  $name
     * @return \Acadelib\Modularity\Module
     *
     * @throws \Acadelib\Modularity\Exceptions\ModuleNotFoundException
     */
    protected function findOrFail($name)
    {
        foreach ($this->scan() as $module) {
            if ($module->getName() == Str::kebab($name)) {
                return $module;
            }
        }

        throw new ModuleNotFoundException("The module [{$name}] does not exist.");
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
     *
     * @throws \Acadelib\Modularity\Exceptions\ModuleNotFoundException
     */
    public function enable($name)
    {
        $this->findOrFail($name)->enable();
    }

    /**
     * Disable the given module.
     *
     * @param  string  $name
     * @return void
     *
     * @throws \Acadelib\Modularity\Exceptions\ModuleNotFoundException
     */
    public function disable($name)
    {
        $this->findOrFail($name)->disable();
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
     * @param  string  $path
     * @return \Acadelib\Modularity\Manifest
     */
    protected function getManifest($path)
    {
        return new Manifest($this->files, $path.'/module.json');
    }
}
