<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('Products.index',compact('products'));
    }

    /**
     * Summary of trashedProducts
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function trashedProducts()
    {
        $products = Product::onlyTrashed()->latest()->paginate(5);
        return view('Products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', 'price' => 'required'
        ]);
        $product = Product::create($request->all());
        return redirect()->route('product.index')->with('success','product added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('Products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('Products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required', 'price' => 'required'
        ]);
        $product->update($request->all());
        return redirect()->route('product.index')->with('success','product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success','product deleted successfully');
    }

    public function softDelete($id)
    {
        $product = Product::find($id)->delete();
        return redirect()->route('product.index')->with('success','product deleted successfully');
    }
}
