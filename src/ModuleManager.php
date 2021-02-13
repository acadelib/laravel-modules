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
            $manifest = json_decode($this->files->get($directory.'/module.json'));
            $modules[] = $manifest->name;
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
}
