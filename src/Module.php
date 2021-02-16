<?php

namespace Acadelib\Modularity;

class Module
{
    /**
     * The module name.
     *
     * @var string
     */
    protected $name;

    /**
     * The module path.
     *
     * @var string
     */
    protected $path;

    /**
     * Create a new module instance.
     *
     * @param  string  $name
     * @param  string  $path
     * @return void
     */
    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * Get the module name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
