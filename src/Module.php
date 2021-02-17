<?php

namespace Acadelib\Modularity;

class Module
{
    /**
     * The manifest.
     *
     * @var \Acadelib\Modularity\Manifest
     */
    protected $manifest;

    /**
     * Create a new module instance.
     *
     * @param  \Acadelib\Modularity\Manifest  $manifest
     * @return void
     */
    public function __construct($manifest)
    {
        $this->manifest = $manifest;
    }

    /**
     * Get the module name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->manifest->name;
    }

    /**
     * Determine if the module is enabled or not.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->manifest->enable;
    }

    /**
     * Enable the module.
     *
     * @return void
     */
    public function enable()
    {
        $this->manifest->enable = true;
    }

    /**
     * Disable the module.
     *
     * @return void
     */
    public function disable()
    {
        $this->manifest->enable = false;
    }
}
