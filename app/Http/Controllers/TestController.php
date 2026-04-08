<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index1() {
        return "Xin chào...";
    }

    public function index2() {
        return view('index2');
    }

    public function index3() {
        $random = rand(1, 10);
        $xx = md5($random . 'abc');
        return view('index3', ['data' => $xx]);
    }

    public function index4() {
        $random = rand(1, 10);
        $xx = md5($random . 'abc');
        return view('index4', compact('xx'));
    }
    
    public function index5() {
        $random = rand(1, 10);
        $xx = md5($random . 'abc');
        return view('index5')->with('xx', $xx);
    }
}
