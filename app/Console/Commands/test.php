<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $worker= new \GearmanWorker();
        $worker->addServer();
        $worker->addFunction("reverse", function ($job) {
            $result = strrev($job->workload());
            Log::info("接受的参数：\t".$result."\n");
            return ($result);
        });
        while ($worker->work());
    }
}
