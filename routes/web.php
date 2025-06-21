<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\Seller\Stores;
use App\Livewire\Admin\SellerRequests;
use App\Livewire\Admin\Users\UsersList;
use App\Livewire\Seller\AddProduct;
use App\Livewire\Seller\MyStore;
use App\Livewire\Seller\Stores as SellerStores;
use App\Livewire\User\ProductsList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('admin/dashboard', DashboardController::class)->name('admin.dashboard');
    Route::get('admin/seller_requests', SellerRequests::class)->name('admin.seller_requests');
    Route::get('admin/users', UsersList::class)->name('admin.users');
    Route::get('admin/stores', Stores::class)->name('admin.stores');
});

Route::middleware(['auth', 'is_seller'])->group(function () {
    Route::get('seller/Add-products',AddProduct::class)->name('addproduct');
    Route::get('seller/stores', SellerStores::class)->name('seller.stores');
    Route::get('seller/MyStore', MyStore::class)->name('seller.MyStore');
});

Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('/user/products', ProductsList::class)->name('user.product');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
