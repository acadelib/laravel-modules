<?php

namespace Acadelib\Modularity;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ModuleCreator
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new module creator instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Create a new module.
     *
     * @param  string  $name
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function create($name)
    {
        $this->ensureModuleDoesntAlreadyExist($name);

        $this->files->makeDirectory($this->getPath($name), 0755, true);
    }

    /**
     * Ensure that a module with the given name doesn't already exist.
     *
     * @param  string  $name
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function ensureModuleDoesntAlreadyExist($name)
    {
        if ($this->files->exists($this->getPath($name))) {
            throw new InvalidArgumentException("The module [{$this->getModuleName($name)}] already exists.");
        }
    }

    /**
     * Get the name of the module.
     *
     * @param  string  $name
     * @return string
     */
    protected function getModuleName($name)
    {
        return Str::studly($name);
    }

    /**
     * Get the full path to the module.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path('modules').'/'.$this->getModuleName($name);
    }
}
