<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LinkJumpController extends Controller
{
    public function index($id,$openid,$url)
    {
        header("Location: " . $url);

    }

    private function addclick()
    {

    }
}
