<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatArticle extends Model
{
    protected $table = 'wx_article';

    public function scopeUsagePublished($query, $eventkey)
    {
        $query->where(function ($query) use ($eventkey) {
                $query->where('eventkey', $eventkey)
                    ->orWhere('eventkey', 'all');
            })
            ->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->where('startdate', '<=', date('Y-m-d'))
            ->where('enddate', '>=', date('Y-m-d'))
            ->orderBy('eventkey', 'asc')
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc')
            ->skip(0)->take(8);
    }

    public function scopeFocusPublished($query, $eventkey)
    {
        $query->where('msgtype', 'news')
            ->where('focus', '1')
            ->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->where('eventkey', $eventkey)
            ->whereDate('startdate', '<=', date('Y-m-d'))
            ->whereDate('enddate', '>=', date('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc')
            ->skip(0)->take(8);

    }
}
