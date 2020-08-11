<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfLoginController extends Controller
{
    public function index(){
        return view('teacher_frontend.login');
    }
}
