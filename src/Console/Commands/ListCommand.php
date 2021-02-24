<?php

namespace Acadelib\Modularity\Console\Commands;

use Acadelib\Modularity\Module;
use Acadelib\Modularity\ModuleManager;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered modules';

    /**
     * The module manager instance.
     *
     * @var \Acadelib\Modularity\ModuleManager
     */
    protected $manager;

    /**
     * The table headers for the command.
     *
     * @var string[]
     */
    protected $headers = ['Name', 'Status'];

    /**
     * Create a new command instance.
     *
     * @param  \Acadelib\Modularity\ModuleManager  $manager
     * @return void
     */
    public function __construct(ModuleManager $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->table($this->headers, $this->getModules());
    }

    /**
     * Compile the modules into a displayable format.
     *
     * @return array
     */
    protected function getModules()
    {
        return collect($this->manager->all())->map(function (Module $module) {
            return [
                'name' => Str::studly($module->getName()),
                'status' => $module->isEnabled() ? 'Enabled' : 'Disabled',
            ];
        })->toArray();
    }
}
