<?php

use App\Models\Barang;

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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProfileController;
use App\Models\Product;

// Route untuk autentikasi
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Route untuk admin


// Route untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/admin/users/{id}/update-role', [AdminController::class, 'updateRole'])->name('admin.users.update-role');
    Route::get('/admin/transactions/pdf', [ProductController::class, 'downloadPDF'])->name('admin.transactions.pdf');
    
    Route::get('/admin/search', [ProductController::class, 'search'])->name('admin.search');
    // Route for searching users
Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])->name('admin.users.search');



   Route::get('admin/seacrh/stock',[ProductController::class,'stocksearch'])->name('admin.search.stock');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

   Route::get('/admin/reports/sales',[AdminController::class, 'salesReport'])->name('admin.reports.sales');
   Route::get('/admin/reports/stocks',[AdminController::class, 'stockReport'])->name('admin.reports.stocks');
   Route::get('/admin/reports/financial',[AdminController::class, 'financialReport'])->name('admin.reports.financial');

Route::get('/admin/transactions/search',[TransactionController::class, 'searchtrx'])->name('admin.transactions.search');
   Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/admin/transactions/create', [TransactionController::class, 'create'])->name('admin.transactions.create');
    Route::post('/admin/transactions', [TransactionController::class, 'store'])->name('admin.transactions.store');
    
    Route::get('/admin/transactions/{id}', [TransactionController::class, 'show'])->name('admin.transactions.show');
    Route::get('/admin/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('admin.transactions.edit');
    Route::put('/admin/transactions/{id}', [TransactionController::class, 'update'])->name('admin.transactions.update');
    Route::delete('/admin/transactions/{id}', [TransactionController::class, 'destroy'])->name('admin.transactions.destroy');
    Route::get('/admin/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::put('/admin/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});


// Route untuk pengguna
Route::middleware(['auth', 'role:pengguna'])->group(function () {   
    Route::get('/pengguna/dashboard', function () {
        return view('pengguna.dashboard');
    })->name('pengguna.dashboard');
});

// Route untuk profil pengguna

Route::get('/profile', function () {
    return view('profile');
})->name('main.profile')->middleware('auth');



// Route untuk petugas kasir
Route::middleware(['auth', 'role:petugas_kasir'])->group(function () {
    Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
    Route::get('/kasir/transactions', [KasirController::class, 'index'])->name('kasir.transactions.index');
    Route::get('/kasir/transactions/create', [KasirController::class, 'create'])->name('kasir.transactions.create');
    Route::get('/kasir/reports/stocks',[KasirController::class, 'stockReport'])->name('kasir.reports.stocks');
    Route::post('/kasir/transactions', [KasirController::class, 'store'])->name('kasir.transactions.store');
    Route::delete('/kasir/transactions/{id}', [KasirController::class, 'destroy'])->name('kasir.transactions.destroy');
    Route::get('/kasir/products', [KasirController::class, 'indexkasir'])->name('kasir.products');
    Route::get('/kasir/products/create', [KasirController::class, 'createkasir'])->name('kasir.products.create');
    Route::post('/kasir/products', [KasirController::class, 'storekasir'])->name('kasir.products.store');
    Route::get('/kasir/products/{id}/edit', [KasirController::class, 'editkasir'])->name('kasir.products.edit');
    Route::put('/kasir/products/{id}', [KasirController::class, 'updatekasir'])->name('kasir.products.update');
    Route::delete('/kasir/products/{id}', [KasirController::class, 'destroykasir'])->name('kasir.products.destroy');
    Route::get('/kasir/transactions/pdf', [KasirController::class, 'downloadPDF'])->name('kasir.transactions.pdf');
    Route::get('/kasir/transactions/search', [KasirController::class, 'search'])->name('kasir.transactions.search');
    Route::get('/kasir/product/search', [KasirController::class, 'searchpdct'])->name('kasir.product.search');
    Route::get('/kasir/stock/search', [KasirController::class, 'stocksearch'])->name('kasir.stock.search');
    Route::get('/kasir/profile', [KasirController::class, 'showProfilee'])->name('profile.show');
    Route::put('/kasir/profile', [KasirController::class, 'updateProfilee'])->name('profile.update');
});

// Route for user profile

// Route untuk petugas barang
Route::middleware(['auth', 'role:petugas_barang'])->group(function () {
    Route::get('/barang/dashboard', [BarangController::class, 'dashboard'])->name('barang.dashboard');
    Route::get('/barang/products', [BarangController::class, 'index'])->name('barang.products');
    Route::get('/barang', [BarangController::class, 'search'])->name('barang.search');
    Route::get('/barang/products/create', [BarangController::class, 'create'])->name('barang.products.create');
    Route::post('/barang/products', [BarangController::class, 'store'])->name('barang.products.store');
    Route::get('/barang/products/{id}/edit', [BarangController::class, 'edit'])->name('barang.products.edit');
    Route::put('/barang/products/{id}', [BarangController::class, 'update'])->name('barang.products.update');
    Route::delete('/barang/products/{id}', [BarangController::class, 'destroy'])->name('barang.products.destroy');

});

// Route untuk halaman dashboard umum
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/', function () {
    return view('auth.login');
});
