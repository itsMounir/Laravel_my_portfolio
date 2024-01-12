<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create(){
        return view("register.create");
    }

    public function store(){
        $data = request()->validate([
            'name'=> ['required','max:255',Rule::unique('users','name')],
            'username'=> ['required','max:255',Rule::unique('users','username')],
            'email'=> ['required','email','max:255',Rule::unique('users','email')],
            'password'=> ['required','max:255'],
        ]);

        $user = User::create($data);

        //sign in the user '-' << to do >>
        auth()->login($user);

       // throw

        return redirect('/')->with('success','user created successfully');
    }
}
