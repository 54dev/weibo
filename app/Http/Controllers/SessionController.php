<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials, $request->has('remember'))){
            if(Auth::user()->activated){
                session()->flash('success','welcome back');
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning','no activated,check your email');
                return redirect('/');
            }

        }else{
            session()->flash('danger','sorry,no empty');
            return redirect()->back()->withInput();
        }

        return;
    }



    public function destory()
    {
        Auth::logout();
        session()->flash('success', 'logout succ!');
        return redirect('login');
    }
}
