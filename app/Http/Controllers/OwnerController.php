<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use App\Models\Storehouse;
use Illuminate\Http\Request;
use App\Http\Requests\sessionRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Validator;

class OwnerController extends Controller
{
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
        $user_id = $user['id'];
        $accessToken = $user->createToken('access_token')->accessToken;

        $user['remember_token'] = $accessToken;

        //$accessToken->token->save();

        //dd($user->with(['storehouse'])->get());
        $user = $user->with(['storehouse'])->get()->find($user_id);
        return response()->json([
            'user' =>$user,
            'access_token' => $accessToken,
            'token_type' => 'Bearer'
         ]);
    }

    public function create(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone_number' => ['required','unique:users,phone_number','digits:10'],
            'password' => 'required',
            'storehouse_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }



        //dd($attributes);
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        $user_id = $user['id'];

        //dd($user);
        $user['role'] = true;
        //$user['user_id'] = $user->id;

        //$user->save();

        //$user['password'] = bcrypt($request->password);





        //dd($user->id);

        Storehouse::create([
            'user_id' => $user->id,
            'name' => $request['storehouse_name']
        ]);

        // here we go
        //$user['storehouse_id'] = $Storehouse['id'];
        // here we end
        $user->save();

        $accessToken = $user->createToken('access_token')->accessToken;

        //dd($accessToken);

        $user['remember_token'] = $accessToken;

        auth()->login($user);

        $user = $user->with(['storehouse'])->get()->find($user_id);

        return response()->json([
            'message' => 'success',
            'user' => $user,
            'access_token' => $accessToken,
            'token_type' => 'Bearer'
    ]);
    }

    public function destroy(){

        Auth::user()->token()->revoke();
        return response()->json(['message' => 'LoggedOut successfully']);

    }
}
