<?php

namespace App\Http\Controllers;

use App\Models\Storehouse;
use Auth;
use Illuminate\Http\Request;

class StorehouseController extends Controller
{
    public function index(){
        $user = Auth::user();
        if (! $user) {
            return response()->json([
                'message' => 'please make sure you have logged in.',
                'status' => 401
            ]);
        }
        $storehouses = Storehouse::all();
        return response()->json([
            'data' => $storehouses,
            'status' => 200,
            'message' => 'success'
        ]);

    }
}
