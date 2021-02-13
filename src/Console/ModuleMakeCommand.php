<?php

namespace Acadelib\Modularity\Console;

use Acadelib\Modularity\ModuleCreator;
use Illuminate\Console\Command;

class ModuleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name : The name of the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * The module creator instance.
     *
     * @var \Acadelib\Modularity\ModuleCreator
     */
    protected $creator;

    /**
     * Create a new command instance.
     *
     * @param  \Acadelib\Modularity\ModuleCreator  $creator
     * @return void
     */
    public function __construct(ModuleCreator $creator)
    {
        parent::__construct();

        $this->creator = $creator;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->creator->create($this->argument('name'));
    }
}
