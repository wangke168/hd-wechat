<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
class UpdateEscQueue extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $row = DB::table('wx_user_info')
            ->where('wx_openid', $this->user->wx_openid)
            ->first();
        if ($row) {
            DB::table('wx_user_esc')
                ->where('id', $this->user->id)
                ->update(['eventkey' => $row->eventkey]);
        }
    }
}
