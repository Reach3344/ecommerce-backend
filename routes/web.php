<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => Auth::check()
    ? redirect()->route('admin.dashboard')
    : view('auth.login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'categoryCount' => Category::count(),
            'productCount' => Product::count(),
            'orderCount' => Order::count(),
            'userCount' => User::where('is_admin', false)->count(),
            'latestOrders' => Order::with('user')->latest()->take(5)->get(),
        ]);
    })->name('dashboard');

    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/orders', fn () => view('admin.orders.index', [
        'orders' => Order::with(['user', 'items'])->latest()->paginate(15),
    ]))->name('orders.index');
    Route::get('/orders/{order}', fn (Order $order) => view('admin.orders.show', [
        'order' => $order->load(['user', 'items.product']),
    ]))->name('orders.show');
    Route::post('/orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
    Route::get('/users', fn () => view('admin.users.index', [
        'users' => User::latest()->paginate(15),
    ]))->name('users.index');
    Route::get('/users/{user}', fn (User $user) => view('admin.users.show', [
        'user' => $user->load([
            'cartItems.product',
            'wishlistItems.product',
            'orders' => fn ($query) => $query->with('items.product')->latest(),
        ]),
    ]))->name('users.show');
});
