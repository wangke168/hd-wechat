<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatTxt extends Model
{
    protected $table = 'wx_txt_request';

    public function scopeFocusPublished($query, $eventkey)
    {
        $query->where('eventkey', $eventkey)
            ->where('online', '1')
            ->where('focus', '1')
            ->whereDate('start_date', '<=', date('Y-m-d'))
            ->whereDate('end_date', '>=', date('Y-m-d'));
    }
}
