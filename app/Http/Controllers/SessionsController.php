<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class SessionsController extends Controller
{
    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success','good bye!');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email'=> ['required','email'],
            'password'=> ['required','max:255'],
        ]);
        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages(['email'=> 'your provided credentials cannot be verified .']);
        }

        session()->regenerate();
        return redirect('/')->with('success','Welcome Back!');
    }
}
