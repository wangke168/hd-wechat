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
/*        $tagId = '171';
        $app = app('wechat');
        $tag = $app->user_tag;
        $openids = $tag->usersOfTag($tagId, $nextOpenId = '')->data;
        $openIds=$openids['openid'];
        $tag->batchUntagUsers($openIds, $tagId);*/

        $tagId = '171';
        $app = app('wechat');
        $tag = $app->user_tag;
        $openids = $tag->usersOfTag($tagId, $nextOpenId = '')->data;
        $openIds=$openids['openid'];

        if (count($openIds)>0) {
            for ($i = 0; $i <= count($openIds); $i = $i + 40) {
                $openid = (array_slice($openIds, $i, $i + 39));
                $tag->batchUntagUsers($openid, $tagId);
            }
        }
    }
}
