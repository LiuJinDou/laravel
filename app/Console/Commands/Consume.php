<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Log;

class Consume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume';

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
        Log::useFiles(storage_path('logs/crontab/'.date('Y-m-d').'/consume_task.log'), 'info');
        $results = app('ConsumeDetail')->groupBy('consume_id')
            ->get(['id',DB::raw('SUM(amount) as amount'),'consume_id','date'])
            ->toArray();
        foreach ($results as $value){
            $consume =  app('Consume')->find($value['consume_id']);
            $consume->real_amount = $value['amount'];
            $consume->update_at = time();
            $rtn = $consume->save();
            if ($rtn) {
                Log::info("更新实际消费金额成功\t".json_encode($value)."\n");
            } else{
                Log::error("更新实际消费金额失败\t".json_encode($value)."\n");
            }
        }
        //
    }
}
