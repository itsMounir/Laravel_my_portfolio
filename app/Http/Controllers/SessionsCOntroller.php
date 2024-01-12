<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use Illuminate\Http\Request;
use App\Http\Requests\sessionRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Validator;


class SessionsCOntroller extends Controller
{
    // public function store(Request $request) {   //how to do something if validation failed
    //     $attributes = $request->validate([
    //         'mobile_number' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $user = Pharmacist::where('mobile_number',$attributes['mobile_number'])->get();
    //     //check if exists first ^-^
    //     if ($user->count()) {
    //         $name = $user[0]['name'];
    //     }
    //     else {
    //         return response()->json(['message' => 'invalid information']);
    //     }

    //     //dd([$request['password'],$name]);
    //     if (! auth()->attempt(['password' => $request['password'],'name' => $name])) {
    //         return response()->json(['message' => 'invalid information']);
    //     }


    //     return response()->json(['message' => 'success']);
    // }

    public function store(Request $request) {
        //dd($myRequest);
        $attributes = $request->validate([
            'phone_number' => ['required','exists:users,phone_number'],
            'password' => 'required'
        ]);

        //dd($attributes->validated());

        if (!auth()->attempt($attributes)) {
            return response()->json(['error'=> 'your provided credentials cannot be verified .'],422);
        }

        //dd($token);

        $user = $request->user();
        $accessToken = $user->createToken('access_token');

        $user['remember_token'] = $accessToken;

        $accessToken->token->save();

        return response()->json([
            'user' => auth()->user(),
            'access_token' => $accessToken,
            'token_type' => 'Bearer'
     ]);
    }

    public function create(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone_number' => ['required','unique:users,phone_number','digits:10'],
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        //dd($validator->validated()['name']);

        //update
        //$validator->role = false;


        //dd($attributes);
        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password)
            ]
        ));

        $user['role'] = false ;

        $user->save();
        //$user['password'] = bcrypt($request->password);


        $accessToken = $user->createToken('access_token')->accessToken;

        //dd($accessToken);

        $user['remember_token'] = $accessToken;

        auth()->login($user);

        return response()->json([
            'message' => 'success',
            'access_token' => $accessToken,
            'token_type' => 'Bearer'
    ]);
    }

    public function destroy(){

        Auth::user()->token()->revoke();
        return response()->json(['message' => 'LoggedOut successfully']);

    }
}
