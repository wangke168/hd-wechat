<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelTag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CancelTag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CancelTag';

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
        $tagId = '102';
        $app = app('wechat');
        $tag = $app->user_tag;
        $openIds = $tag->usersOfTag($tagId, $nextOpenId = '')->data;
        $tag->batchUntagUsers($openIds, $tagId);
    }
}
