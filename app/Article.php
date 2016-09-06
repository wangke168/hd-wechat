<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
//    protected $fillable=['title','content','published_at'];


    public function article()
    {
        return $this->hasOne('app\Models\wx_article');
    }

}
