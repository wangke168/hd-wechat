<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatArticle extends Model
{
    protected $table = 'wx_article';
    public function scopePublished($query)
    {
        $query->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->where('startdate', '<=', date('Y-m-d'))
            ->where('enddate', '>=', date('Y-m-d'));
    }
}
