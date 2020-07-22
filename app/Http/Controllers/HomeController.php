<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $pageUrl = \request()->path();
        return view('welcome', compact('pageUrl'));
    }
}
