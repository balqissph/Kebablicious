<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\kebabliciousController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\manageaccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\cartController;
use App\Models\products;

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

Route::view('/', 'customer.customerMain');

Route::view('dashboard', 'customerverifed.customerMain')
<<<<<<< HEAD
    ->middleware(['auth'])
=======
    ->middleware(['verified'])
>>>>>>> 4439a35eae919225986472b7e06c6b7914ce3458
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('tambah', [ProductController::class, 'store'])->name('addmenu');

//untuk logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

//untuk register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::post('cart/add/{menuId}', [cartController::class, 'addTocart']) -> name('tambahcart');
Route::get('kebablicious/menu', [kebabliciousController::class, 'index'])-> name('menukebablicious');
Route::get('kebablicious/keranjang', [cartController::class, 'index']) -> name('keranjang');
Route::post('/update-quantity/{cartId}', [cartController::class, 'updateQuantity'])->name('updatekuantitas');
Route::delete('/deletekeranjang/{cartId}', [cartController::class, 'removeFromCart'])->name('hapuskeranjang');

Route::middleware('role:admin')->group(function () {

    Route::get('/admin-dashboard', function () {
        return view('admin.admin-dashboard');
    })->name('admin.dashboard');

    Route::get('/admin-dashboard-manage-account', function () {
        return view('admin.admin-dashboard-manage-account');
    })->name('admin.admin-dashboard-manage-account');

    Route::get('/admin-dashboard-manage-menu', function () {
        return view('admin.admin-dashboard-manage-menu');
    })->name('admin.admin-dashboard-manage-menu');

    // UNTUK MENU ADMIN("MANAGE MENU")
    Route::get('menu', [ProductController::class, 'tampildata'])->name('menu');
    Route::delete('/menu/{id}', [ProductController::class, 'hapusdata'])->name('delete');
    Route::put('/produk/{id}', [ProductController::class, 'update'])->name('produk.update');

    // UNTUK MENU ADMIN("MANAGE USER)
    Route::get('user', [manageaccountController::class, 'tampildata'])->name('user');
    // UNTUK MENU ADMI N("TAMBAH ROLES")
    Route::post('tambahrole', [manageaccountController::class, 'tambahrole'])->name('tambahrole');

    Route::delete('hapusrole', [manageaccountController::class, 'hapusrole'])->name('hapusrole');
    //UNTUK MENU ADMIN("HAMPUS ROLES")
});



require __DIR__ . '/auth.php';
