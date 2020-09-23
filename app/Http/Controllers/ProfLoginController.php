<?php

namespace App\Http\Controllers;

use App\Models\MeetingBulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class ProfLoginController extends Controller
{
    use AuthenticatesUsers;

    public function index(){
        if (Auth::guard('teacher')->check()){
            return redirect('/prof');
        }
        return view('teacher_frontend.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(),[
            'account' => 'required',
            'password' => 'required'
        ]);

        if($validator->passes()){

            $account = $request -> get('account');
            $password = $request -> get('password');

            if (Auth::guard('teacher')->attempt(['account' => $account, 'password' => $password])) { //欄位password > 暗碼；文字框$password > 明碼
                //登入成功...
                return redirect('/prof');
            }else{
                //登入失敗
                return back()->with('error','帳號或密碼錯誤，請再次確認');
            }
        }else{
            return back()->with('warning','此欄位必填');
        }
    }

    public  function  logout(){
        Auth::guard('teacher')->logout();
        return redirect('/ProLogin');
    }
}
