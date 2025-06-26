<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Livewire\User\ShowMainCategories;
use App\Livewire\User\WishlistProducts;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\MainCategories as AdminMainCategories;
use App\Livewire\Admin\Payments as AdminPayments;
use App\Livewire\Admin\Seller\Stores;
use App\Livewire\Admin\SellerRequests;
use App\Livewire\Admin\Users\UsersList;
use App\Livewire\Cart;
use App\Livewire\Payments as LivewirePayments;
use App\Livewire\Seller\AddProduct;
use App\Livewire\Seller\MyStore;
use App\Livewire\Seller\Payments as SellerPayments;
use App\Livewire\Seller\Stores as SellerStores;
use App\Livewire\User\MainCategories;
use App\Livewire\User\ProductsList;
use App\Livewire\User\ShowProduct;
use App\Livewire\User\ShowStores;
use App\Models\payments;
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
    Route::get('/admin/payments', AdminPayments::class)->name('admin.payments');
    Route::get('admin/users', UsersList::class)->name('admin.users');
    Route::get('admin/categories', Categories::class)->name('admin.categories');
    Route::get('admin/stores', Stores::class)->name('admin.stores');
    Route::get('/admin/mainCategories', AdminMainCategories::class)->name('admin.mainCategories');
});

Route::middleware(['auth', 'is_seller'])->group(function () {
    Route::get('seller/Add-products',AddProduct::class)->name('addproduct');
    Route::get('seller/stores', SellerStores::class)->name('seller.stores');
    Route::get('seller/MyStore', MyStore::class)->name('seller.MyStore');
    Route::get('/seller/payments', SellerPayments::class)->name('seller.payments');
});

Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('/user/products', ProductsList::class)->name('user.product');
    Route::get('/user/stores', ShowStores::class)->name('user.stores');
    Route::get('/user/pay/success', [StripeController::class, 'success'])->name('success');
    Route::get('/user/pay/cancel', [StripeController::class, 'cancel'])->name('cancel');
    Route::get('/user/payments', LivewirePayments::class)->name('payments');
    Route::get('/product/{id}', ShowProduct::class)->name('product.show');
    Route::get('/user/main_categories', MainCategories::class)->name('user.main_categories');
    Route::get('/user/WishList', WishlistProducts::class)->name('user.wishlist');

    Route::get('user/Shopping_cart', Cart::class)->name('user.cart')->middleware('auth');
    Route::get('/user/main-categories/show/{mainCategoryId}', ShowMainCategories::class)->name('main-category.show');

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
