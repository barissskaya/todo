<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TaskProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskprovider:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'İş API verileri çekilerek kayıt edilir.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $providerFacade = new \App\Classes\Provider\ProviderFacade(); 
        $providerFacade->fetchTasks();
        if($providerFacade->saveTasks()){
            $this->info($providerFacade->getTasksCount() . ' adet kayıt işlendi.');
        }else{            
            $this->info('Kayıt edilecek veri bulunamadı.');
        } 
    }
}
