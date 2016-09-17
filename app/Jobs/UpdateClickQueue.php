<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdateClickQueue extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user;

    public function __construct($user)
    {
        $this->user = $user;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        \Log::info('openid is ' . $this->user->wx_openid);

        $row = DB::table('wx_user_info')
            ->where('wx_openid', $this->user->wx_openid)
            ->first();
        if ($row) {
            DB::table('wx_click_hits')
                ->where('id', $this->user->id)
                ->update(['eventkey' => $row->eventkey]);
        }

    }
}
