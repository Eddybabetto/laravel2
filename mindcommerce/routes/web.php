<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//  Route::get('/product/{id}', [ProductController::class, "show"]);

 Route::resource("/product", ProductController::class)->middleware("auth")->only([
    'create',
    'store',
    'update',
    'destroy'
 ]);

  Route::resource("/product", ProductController::class)->only([
    'index',
    'show'
 ]);

Route::post("/product/{id}/addtocart", [ProductController::class, "addtocart"])->middleware("auth");

// Route::get("/api/user/addresses", [UserController::class, "fetch_addresses"])->middleware("auth");

// Route::get("/", [IndexController::class, "index"]);
// Route::get("/admin", [IndexController::class, "index"])->middleware("auth");




Route::prefix("/admin/user")->group(function () {
    Route::get("/", [AdminController::class, "get_users"]);
    Route::post("/", [AdminController::class, "create_user"]);
    Route::delete("/{id}", [AdminController::class, "delete_user"]);
    Route::put("/{id}/restore", [AdminController::class, "restore_user"]);
    Route::put("/{id}", [AdminController::class, "update_user"]);
    Route::get("/{id}", [AdminController::class, "get_user"]);
        
    Route::prefix("/{id}/address")->group(function () {
        Route::get("/", [AdminController::class, "get_addresses_for_user"]);
        Route::get("/{address_id}", [AdminController::class, "get_address_for_user"]);
        Route::post("/", [AdminController::class, "create_address_to_user"]);
        Route::put("/{address_id}", [AdminController::class, "update_address_to_user"]);
        Route::delete("/{address_id}", [AdminController::class, "delete_address_to_user"]);
    });

})->middleware(["auth", "admin"]);


require __DIR__.'/settings.php';
