<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

Auth::routes();

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class,'index'])->name('shop.index');
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/shop/{product_slug}', [ShopController::class,'productDetails'])->name('shop.product.details');

// carrito
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class,'addToCart'])->name('cart.add');
Route::put('cart/increase-quantity/{rowId}', [CartController::class,'increaseCartQuantity'])->name('cart.qty.increase');
Route::put('cart/decrease-quantity/{rowId}', [CartController::class,'decreaseCartQuantity'])->name('cart.qty.decrease');

Route::delete('cart/remove/{rowId}', [CartController::class,'removeItem'])->name('cart.item.remove');
Route::delete('cart/clear', [CartController::class,'emptyCart'])->name('cart.empty');
Route::get('/cart-content', function (Request $request) {
    return response()->json(Cart::instance('cart')->content());
})->name('cart.content');


// lista de deseos (wishlist)
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WishlistController::class, 'emptyWishlist'])->name('wishlist.empty');
Route::post('/wishlist/move-to-cart/{rowId}', [WishlistController::class, 'moveToCart'])->name('wishlist.move.to.cart');

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout/place-order', [CartController::class, 'placeOrder'])->name('cart.place.order');
Route::get('/checkout/order-confirmation/{order_id}', [CartController::class, 'orderConfirmation'])->name('cart.order.confirmation');

// Rutas de usuario loggeado
Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard', [UserController::class,'index'])->name('user.index');
    Route::get('/account-orders', [UserController::class,'orders'])->name('user.orders');
    Route::get('/account-order/{order_id}/details', [UserController::class,'orderDetails'])->name(   'user.order.details');
    Route::put('/account-order/cancel', [UserController::class,'cancelOrder'])->name('user.order.cancel');
    Route::get('/orders/{order}/invoice/download', [InvoiceController::class, 'download']) ->name('invoice.download');

    // Rutas para la gestión de direcciones del usuario
Route::get('/user/address', [UserController::class, 'showAddressForm'])->name('user.address.form');
Route::post('/user/address/save', [UserController::class, 'saveAddress'])->name('user.address.save');
    Route::get('/user/account/edit', [UserController::class, 'editProfile'])->name('user.account.edit');
    Route::post('/user/account/update', [UserController::class, 'updateProfile'])->name('user.account.update');
    // Route::get('/account-address', [UserController::class, 'editAdress'])->name('user.address.edit');
    // Route::post('/account-address', [UserController::class, 'updateAdress'])->name('user.address.update');
});

//  administración
Route::middleware(['auth',AuthAdmin::class])->group(function(){
    Route::get('/admin',[DashboardController::class,'index'])->name('admin.index');
    
    // Marcas 
    Route::get('/admin/brands',[BrandController::class,'brands'])->name('admin.brands');
    Route::get('/admin/brand-add',[BrandController::class,'addBrand'])->name('admin.brand.add');
    Route::post('/admin/brand/store',[BrandController::class,'storeBrand'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}',[BrandController::class,'editBrand'])->name('admin.brand.edit');
    Route::put('/admin/brand/update',[BrandController::class,'updateBrand'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete',[BrandController::class,'deleteBrand'])->name('admin.brand.delete');
    
    // Categorías
    Route::get('/admin/categories',[CategoryController::class,'categories'])->name('admin.categories');
    Route::get('/admin/category/add',[CategoryController::class,'addCategory'])->name('admin.category.add');
    Route::post('/admin/category/store',[CategoryController::class,'storeCategory'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}',[CategoryController::class,'editCategory'])->name('admin.category.edit');
    Route::put('/admin/category/update',[CategoryController::class,'updateCategory'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete',[CategoryController::class,'deleteCategory'])->name('admin.category.delete');
    
    // Productos
    Route::get('/admin/products',[ProductController::class,'products'])->name('admin.products');
    Route::get('/admin/product/add',[ProductController::class,'addProduct'])->name('admin.product.add');
    Route::post('/admin/product/store',[ProductController::class,'storeProduct'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}',[ProductController::class,'editProduct'])->name('admin.product.edit');
    Route::put('/admin/product/update',[ProductController::class,'updateProduct'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete',[ProductController::class,'deleteProduct'])->name('admin.product.delete');

    // Pedidos
    Route::get('admin/orders', [OrderController::class, 'orders'])->name('admin.orders');
    Route::get('admin/order/details/{id}', [OrderController::class, 'orderDetails'])->name('admin.order.details');
    Route::put('admin/order/update-status', [OrderController::class, 'updateOrderStatus'])->name('admin.order.status.update');

    //Usuarios
    Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/add', [App\Http\Controllers\Admin\UserController::class, 'addUser'])->name('admin.users.add');
    Route::post('/admin/users/store', [App\Http\Controllers\Admin\UserController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/admin/users/update', [App\Http\Controllers\Admin\UserController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/admin/users/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'deleteUser'])->name('admin.users.delete');
    
   //Pos
    // Route::get('/admin/pos', [PosController::class, 'showPos'])->name('admin.pos');
    // Route::post('/admin/pos/process-order', [PosController::class, 'processOrder'])->name('admin.pos.process_order');

    // Rutas para el POS

        // Ruta para la descarga de la factura
    Route::get('invoices/download/{order}', [InvoiceController::class, 'download'])->name('admin.invoices.download');
    Route::get('pos/simple', [PosController::class, 'showSimplePos'])->name('admin.pos.simple');
    Route::post('pos/simple/process', [PosController::class, 'processSimpleOrder'])->name('admin.pos.process_simple_order');
});