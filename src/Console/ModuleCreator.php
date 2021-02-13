<?php

namespace Acadelib\Modularity\Console;

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
        $name = $this->getModuleName($name);
        $path = $this->getPath($name);

        $this->ensureModuleDoesntAlreadyExist($name, $path);

        $this->files->makeDirectory($path, 0755, true);

        $this->files->put(
            $path.'/module.json', $this->populateStub($name, $this->getStub())
        );
    }

    /**
     * Ensure that a module with the given name doesn't already exist.
     *
     * @param  string  $name
     * @param  string  $path
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function ensureModuleDoesntAlreadyExist($name, $path)
    {
        if ($this->files->exists($path)) {
            throw new InvalidArgumentException("The module [{$name}] already exists.");
        }
    }

    /**
     * Get the module stub file.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->files->get($this->stubPath().'/module.stub');
    }

    /**
     * Populate the place-holders in the module stub.
     *
     * @param  string  $name
     * @param  string  $stub
     * @return string
     */
    protected function populateStub($name, $stub)
    {
        return str_replace('{{ name }}', $name, $stub);
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
        return config('modularity.module_path').'/'.$name;
    }

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    protected function stubPath()
    {
        return __DIR__.'/Commands/stubs';
    }
}
