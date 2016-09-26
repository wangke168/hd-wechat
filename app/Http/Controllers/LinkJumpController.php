<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LinkJumpController extends Controller
{
    public function index($id,$openid,$url)
    {
      return header("Location:www.baidu.com ");

//        return redirect('www.baidu.com');


    }

    private function addclick()
    {

    }
}
