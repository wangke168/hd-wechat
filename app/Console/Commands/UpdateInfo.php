<?php

namespace App\Console\Commands;

use App\Jobs\UpdateClickQueue;
use Illuminate\Console\Command;
use DB;
class UpdateInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update wx_user_info,wx_click_hits';

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
/*        $row = DB::table('wx_user_info')
            ->where('esc', '0')
//            ->where('city','')
//            ->where('id', '>=', '427039')
//            ->whereDate('endtime', '>=', date("Y-m-d", strtotime("-1 day")))
                ->whereDate('endtime','>=','2016-08-28')
            ->orderBy('id','desc')
            ->get();
        foreach ($row as $OpenidInfo)
        {
            dispatch(new UpdateQueue($OpenidInfo));
//            $this->dispatch(new UpdateQueue($OpenidInfo));
        }*/

        $rowClick=DB::table('wx_click_hits')
//            ->whereDate('adddate','>=',date("Y-m-d", strtotime("-1 day")))
            ->whereDate('adddate','>=','2016-08-28')
            ->get();
        foreach ($rowClick as $clickinfo)
        {
            dispatch(new UpdateClickQueue($clickinfo));
        }
    }
}
