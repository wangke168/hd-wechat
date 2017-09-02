<?php

namespace App\Console\Commands;

use App\Jobs\UpdateOpenidQueue;
use Illuminate\Console\Command;
use DB;
use App\Http\Requests;

class UpdateOpenidInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateOpenidInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update wx_user_info';

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
        
        $row = DB::table('wx_user_info')
            ->where('esc', '0')
//            ->whereDate('endtime', '>=', date("Y-m-d", strtotime("-1 day")))
            ->whereDate('endtime','>=','2016-08-28')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $OpenidInfo)
        {
            dispatch(new UpdateOpenidQueue($OpenidInfo));
        }
    }

}
