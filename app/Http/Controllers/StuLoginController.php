<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StuLoginController extends Controller
{
    use AuthenticatesUsers;

    public function index(){
        if (Auth::guard('student')->check()){
            return redirect('/StuIndex');
        }
        return view('student_frontend.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(),[
            'student_ID' => 'required',
            'password' => 'required'
        ]);

        if($validator->passes()){

            $student_ID = $request -> get('student_ID');
            $password = $request -> get('password');

            if (Auth::guard('student')->attempt(['student_ID' => $student_ID, 'password' => $password])) {
                //登入成功...
                return redirect('/StuIndex');
            }else{
                //登入失敗
                return back()->with('error','帳號或密碼錯誤，請再次確認');
            }
        }else{
            return back()->with('warning','此欄位必填');
        }
    }

    public  function  logout(){
        Auth::guard('student')->logout();
        return redirect('/StuLogin');
    }
}
