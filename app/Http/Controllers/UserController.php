<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = [
            ['name' => 'Phuc', 'email' => 'phuc@example.com'],
            ['name' => 'Yuu', 'email' => 'yuu@example.com'],
        ];
        return view('user.index', compact('users'));
    }

    public function index2() {
        $title = "Danh sách User";
        $users = [
            ['name' => 'Phuc', 'email' => 'phuc@example.com'],
            ['name' => 'Yuu', 'email' => 'yuu@example.com'],
        ];
        return view('user.index2', compact('users', 'title'));
    }

}
