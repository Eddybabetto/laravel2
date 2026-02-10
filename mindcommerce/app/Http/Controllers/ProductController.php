<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return json_encode(Product::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("ProductCreate");
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

     Validator::make($request->all(), [
            "SKU"=>"required|unique:products",
            "price"=>"integer|gte:0|required",
            "stock"=>"integer|gte:0|required",
            "name"=>"required",
            "description"=>"required",
            "categories"=>"required"
        ])->validate();

       Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return json_encode(Product::find($id));
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
        //
    }

    public function get_products()
    {

        $products = Product::all();

        return Inertia::render("ProductsIndex", [
            "prodotti" => $products
        ]);
    }

    public function get_product($id)
    {
        $product = Product::find($id);

        if ($product) {
        return Inertia::render("ProductDetails", [
            "prodotto" => $product
        ]);
        }else{
            abort(404);
        }
      
    }
}
