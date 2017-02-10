<?php
/**
 * Created by PhpStorm.
 * User: wangke
 * Date: 16/10/25
 * Time: 下午1:20
 */

namespace app\Http\ViewComposers;

use EasyWeChat\Foundation\Application;
use Illuminate\Contracts\View\View;

class ArticleComposer
{
    public $wechat;
    public $js;

    public function __construct(Application $app)
    {
        $this->app=$app;
        $this->js=$this->app->js;
    }

    public function compose(View $view)
    {
        $view->with('js',$this->js);
    }
}