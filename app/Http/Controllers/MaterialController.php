<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class MaterialController extends Controller
{
    //
    public $material;

    public function __construct(Application $material)
    {
        // TODO: Implement __construct() method.
        $this->material=$material->material;
    }
    public function audio()
    {
        $result=$this->material->uploadVoice(public_path().'1.mp3');
        return $result;
    }
}

