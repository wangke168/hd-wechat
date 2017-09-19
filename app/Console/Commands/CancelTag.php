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

        $tagId1 = '100';
        $app = app('wechat');
        $tag = $app->user_tag;
        $openids1 = $tag->usersOfTag($tagId1, $nextOpenId = '')->data;
        $openIds1=$openids1['openid'];

        if (count($openIds1)>0) {
            for ($i = 0; $i <= count($openIds1); $i = $i + 40) {
                $openid1 = (array_slice($openIds1, $i, $i + 39));
                $tag->batchUntagUsers($openid1, $tagId1);
            }
        }

        $tagId2 = '101';
    /*    $app = app('wechat');
        $tag = $app->user_tag;*/
        $openids2 = $tag->usersOfTag($tagId2, $nextOpenId = '')->data;
        $openIds2=$openids2['openid'];

        if (count($openIds2)>0) {
            for ($i = 0; $i <= count($openIds2); $i = $i + 40) {
                $openid2 = (array_slice($openIds2, $i, $i + 39));
                $tag->batchUntagUsers($openid2, $tagId2);
            }
        }

    }
}
