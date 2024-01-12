<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;

class PharmacistController extends Controller
{
    public function store(){
        //dd(request()->all('mobile_number'));
        $attributes = request()->validate([
            'name' => ['required','max:255'],
            'mobile_number' => ['required'],
            'password' => ['required','max:255']
        ]);

        //dd($attributes);
        $user =User::create([
            'name' => $attributes['name'],
            'password' => $attributes['password']
        ]);

        auth()->login($user);

        //dd(auth()->user()->id);

         Pharmacist::create([
            'user_id' => auth()->user()->id ,
            'name' => $attributes['name'] ,
            'mobile_number' =>  $attributes['mobile_number'],
            'password' => $attributes['password']
            ]);

            //dd($p);



        return response()->json(['message' => 'success']);
    }
}
