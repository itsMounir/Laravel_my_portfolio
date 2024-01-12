<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\MyRequest;
use Illuminate\Validation\Rule;
use Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->filter(request(['search','category']))->paginate(20)->withQueryString();
        $categories = Category::all();
        $data = [];
        $data['products'] =$products;
        $data['categories'] = $categories;

        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => 'success'
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)     // handle validation failed !!!!!!!!
    {
        //dd($myRequest->all());
        $validator = Validator::make($request->all(),[
            's_name' => ['required','unique:products,s_name','min:3','max:255'],
            't_name'=> ['required','min:3','max:255'],
            'category_id'=> ['required'],
            'company_name'=> ['required'],
            'amount'=> ['required'],
            'ending_date'=> ['required'],
            'price'=> ['required']
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = Auth::user();
        if (! $user['role']) {
            return response()->json(['message' => 'unauthorized' , 'status'=> 401]);
        }
        $storehouse = $user->storehouse();

        //dd($storehouse->first()->id);

        $product = Product::create(array_merge(
            $validator->validated(),
            ['storehouse_id' => $storehouse->first()->id]
        ));

        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $product = Product::firstWhere('id',$id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::firstWhere('id',$id);
        $product->delete();
        return response()->json(['message' => 'success']);
    }
}
