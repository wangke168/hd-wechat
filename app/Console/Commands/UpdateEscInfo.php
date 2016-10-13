<?php

namespace App\Console\Commands;

use App\Jobs\UpdateEscQueue;
use Illuminate\Console\Command;
use DB;
class UpdateEscInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateEscInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update wx_user_esc';

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
        $rowEsc=DB::table('wx_user_esc')
            ->whereDate('esc_time','>=',date("Y-m-d", strtotime("-1 day")))
//            ->whereDate('esc_time','>=','2016-08-28')
            ->get();
        foreach ($rowEsc as $EscInfo)
        {
            dispatch(new UpdateEscQueue($EscInfo));
        }
    }
}
