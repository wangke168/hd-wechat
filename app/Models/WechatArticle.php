<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatArticle extends Model
{
    protected $table = 'wx_article';

    public function scopeUsagePublished($query, $eventkey)
    {
        $query->where(function ($query) use ($eventkey) {
            $query->whereRaw('FIND_IN_SET("'.$eventkey.'", eventkey)')
                ->orWhereRaw('FIND_IN_SET("all", eventkey)');
        })
            ->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->where('startdate', '<=', date('Y-m-d'))
            ->where('enddate', '>=', date('Y-m-d'))
            ->orderBy('eventkey', 'asc')
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc');

    }

    public function scopeFocusPublished($query, $eventkey)
    {
        $query->whereRaw('FIND_IN_SET("'.$eventkey.'", eventkey)')
            ->where('msgtype', 'news')
            ->where('focus', '1')
            ->where('audit', '1')
            ->where('del', '0')
            ->where('online', '1')
            ->whereDate('startdate', '<=', date('Y-m-d'))
            ->whereDate('enddate', '>=', date('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc');

    }
}
