<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionController extends Controller
{
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

        if(Auth::attempt($credentials)){
            session()->flash('success','welcome back');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger','sorry,no empty');
            return redirect()->back()->withInput();
        }

        return;
    }
}
