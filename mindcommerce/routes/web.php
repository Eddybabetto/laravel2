<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
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
Route::get('/thank-you', function () {
    return Inertia::render('ThankYou');
});
Route::get('/error', function () {
    return Inertia::render('Error');
});

Route::get('dashboard', [DashboardController::class, "show_dashboard"])->middleware(['auth', 'verified'])->name('dashboard');

Route::post("cart/add", [CartController::class, "store"])->middleware(['auth', 'verified']);
Route::post("cart/edit", [CartController::class, "update"])->middleware(['auth', 'verified']);
Route::get("cart", [CartController::class, "show"])->middleware(['auth', 'verified']);
Route::get("checkout", [CartController::class, "checkout"])->middleware(['auth', 'verified']);
Route::delete("cart/remove/{id}", [CartController::class, "destroy"])->middleware(['auth', 'verified']);

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
