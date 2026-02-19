<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/admin/products", [ProductController::class, "get_products"])->middleware(["auth", IsAdmin::class]);
Route::get("/admin/products/create", [ProductController::class, "create"])->middleware(["auth", IsAdmin::class]);
Route::post("/admin/products/create", [ProductController::class, "store"])->middleware(["auth", IsAdmin::class]);
Route::get("/admin/products/{id}", [ProductController::class, "get_product"])->middleware(["auth", IsAdmin::class]);
Route::put("/admin/products/{id}", [ProductController::class, "update"])->middleware(["auth", IsAdmin::class]);


Route::prefix("/admin/user")->middleware(["auth", IsAdmin::class])->group(function () {
    Route::get("/", [AdminController::class, "get_users"]);
    Route::get("/create",[AdminController::class, "create"]);
    Route::post("/create", [AdminController::class, "store"]);
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
});


require __DIR__ . '/settings.php';
