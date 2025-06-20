<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Livewire\Admin\Users\UsersList;
use App\Livewire\Admin\SellerRequests;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/dashboard', DashboardController::class)->name('admin.dashboard');

Route::get('admin/users', UsersList::class)->name('admin.users');
Route::get('admin/seller_requests', SellerRequests::class)->name('admin.seller_requests');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');
