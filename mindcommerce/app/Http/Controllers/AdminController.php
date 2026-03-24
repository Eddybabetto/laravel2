<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use PasswordValidationRules, ProfileValidationRules;
    /**
     * Display a listing of the resource.
     */
    public function get_users()
    {
        return Inertia::render('UsersIndex', [
            "users" => User::get()
            // "users"=> User::paginate()->toResourceCollection();
        ]);
    }
    public function get_user($id)
    {
        $user    = User::with(["carts", "carts.product"])->find($id);
        $products_saved_by_user = $user->products;
        $cart_rows = $user->carts;

     
        return Inertia::render('UserShow', [
            "user" => User::find($id),
            "products" => $products_saved_by_user,
            "cart_rows" => $cart_rows
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
        return Inertia::render("UserCreate");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            "cf" => "size:16|required",
            "tel" => "required"
        ])->validate();
        $admin = false;
        if ($request["admin"] == "on") {
            $admin = true;
        };
        User::create([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'cf' => $request['cf'],
            'tel' => $request['tel'],
            'admin' => $admin,
            'email' => $request['email'],
            'password' => $request['password'],
        ]);
        return Inertia::render('UsersIndex', [
            "users" => User::get()
            // "users"=> User::paginate()->toResourceCollection();
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
     * Update the specified user.
     */
    public function update_user(Request $request, string $id)
    {
        Validator::make($request->all(), [
            ...$this->profileRules($id),
            'password' => $this->passwordRules(),
            "cf" => "size:16|required",
            "tel" => "required"
        ])->validate();
        // select * from users where id = $id
        $utente = User::find($id);


        if (Hash::check($request->old_password, $utente->password)) {
            // verifica password che arr
            $utente->name = $request->name;
            $utente->surname = $request->surname;
            $utente->CF = $request->cf;
            $utente->tel = $request->tel;
            $utente->email = $request->email;

            //qui modifichiamo password
            $utente->password = $request->password;

            $admin = false;
            if ($request["admin"] == "on") {
                $admin = true;
            };
            $utente->admin = $admin;

            $utente->save();

            return Inertia::render('UserShow', [
                "user" => $utente
            ]);
        } else {
            abort(500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete_user(string $id)
    {
        $utente = User::find($id);
        $utente->delete();
        return Inertia::render('UsersIndex', [
            "users" => User::get()
        ]);
    }
}
