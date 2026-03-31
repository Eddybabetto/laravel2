<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->product_id
        $utente = $request->user();
        $qty = $request->qty; // deve arrivare dal frontend

        $cart = Cart::where('user_id', $utente->id)
            ->where('product_id', $request->product_id)
            ->get();


        $found_cart = new Cart();
        if (count($cart)) {
            $found_cart->qty = $cart[0]->qty + $qty;
            $found_cart->user_id = $cart[0]->user_id;
            $found_cart->product_id = $cart[0]->product_id;

            Cart::where('user_id', $utente->id)
                ->where('product_id', $request->product_id)
                ->delete();
        } else {
            $found_cart->user_id = $utente->id;
            $found_cart->product_id = $request->product_id;
            $found_cart->qty = $qty;
        }


        $stock = (Product::find($found_cart->product_id))->stock;

        if ($found_cart->qty > $stock) {
            $found_cart->qty = $stock;
        }

        return $found_cart->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $utente = $request->user();
        $carts  = Cart::with(["product"])->where("user_id", $utente->id)->get();
        // $carts  = $utente->products;
        // $carts = [
        //     {user_id: 1,
        //     product_id:23,
        //     qty: 4,
        //     product: {
        //         id: 23,
        //         name: "shampoo antiforfora"
        //         categories: "beauty",
        //         price: 10.00
        //     }
        // }

        // ]

        $clean_cart = [];

        foreach ($carts as $row) {
            $clean_cart[] = ["qty" => $row->qty, ...($row->product->toArray())];
        }

        // $clean_cart= [
        //     {qty: 4,
        //            id: 23,
        //         name: "shampoo antiforfora"
        //         categories: "beauty",
        //         price: 10.00
        //     }
        // ]


        return Inertia::render("Cart", [
            "products_in_cart" => $clean_cart
        ]);
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
    public function update(Request $request)
    {
        $utente = $request->user();
        $qty=$request->qty;

 $stock = (Product::find($request->product_id))->stock;

        if ($qty > $stock) {
            abort(403);
        }

   
        return Cart::where('user_id', $utente->id)
                ->where('product_id', $request->product_id)
                ->update(["qty" => $qty]);
        
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $utente = $request->user();
        //$id è l'id del prodotto da eliminare a carrello
        return Cart::where('user_id', $utente->id)
            ->where('product_id', $id)
            ->delete();
    }
}
