<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Error;
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
            "SKU" => "required|unique:products",
            "price" => "gte:0|required",
            "stock" => "integer|gte:0|required",
            "name" => "required",
            "description" => "required",
            "categories" => "required"
        ])->validate();

        // $this->control_decimal($request->price);
        Product::create($request->all());
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            "price" => "required",
            "stock" => "integer|gte:0|required",
            "name" => "required",
            "description" => "required",
            "categories" => "required"
        ])->validate();

        $number = $this->control_decimal_explode($request->price);

        $prodotto = Product::find($id);

        $prodotto->name = $request->name;
        $prodotto->price = $number;
        $prodotto->stock = $request->stock;
        $prodotto->categories = $request->categories;
        $prodotto->description = $request->description;

        $prodotto->save();

        return Inertia::render("ProductDetails", [
            "prodotto" => $prodotto
        ]);
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
        } else {
            abort(404);
        }
    }

    //casistiche
    /*
        $number puo avere zero, uno, due o piu di due decimali
        $number puo essere stringa
    */
    public function control_decimal_strpos($number)
    {

        if (!(substr_count($number, ".") > 1) && is_numeric(substr($number, 0, 1))) {
            // ho trovato solo un punto

            $reverse_number = strrev($number);
            $position = strpos($reverse_number, ".");

            switch ($position) {
                case false:
                    # aggiungiamo punto e 2 decimali (zeri)
                    $number .= ".00";
                    break;
                case 0:
                    # aggiungiamo 2 decimali (zeri)
                    $number .= "00";
                    break;
                case 1:
                    # aggiungiamo 1 decimali (zeri)
                    $number .= "0";
                    break;
                case 2:
                    # numero è ok non faccio nulla
                    break;

                default:
                    # numero ha piu di 2 decimali, devo trimmare
                    $number = substr($number, 0, - ($position - 2));
                    break;
            }
        } else {
            throw new Error("invalid price");
        }
        return number_format((float) $number, 2);
    }


    public function control_decimal_explode($number)
    {
        if (is_numeric(substr($number, 0, 1))) {
            $array_exploded_num = explode(".", $number);

            switch (count($array_exploded_num)) {
                case 1:
                    $number = $array_exploded_num[0] . ".00";
                    break;
                case 2:
                    switch (strlen($array_exploded_num[1])) {
                        case 0:
                            $number = $array_exploded_num[0] . ".00";
                            break;
                        case 1:
                            $number = $array_exploded_num[0] . "." . $array_exploded_num[1] . "0";
                            break;
                        case 2:
                            break;
                        default:
                            $number = $array_exploded_num[0] . "." . substr($array_exploded_num[1], 0, 2);
                    }
                    break;
                default:
                    throw new Error("invalid price");
                    die();
            }

    

        } else {
            throw new Error("invalid price");
        }


        return number_format((float) $number, 2);
    }
}
