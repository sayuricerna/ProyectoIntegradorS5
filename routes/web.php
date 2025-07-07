<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[UserController::class,'index'])->name('user.index');
});
Route::middleware(['auth',AuthAdmin::class])->group(function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');

    Route::get('/admin/brands',[AdminController::class,'brands'])->name('admin.brands');
    Route::get('/admin/brand-add',[AdminController::class,'addBrand'])->name('admin.brand.add');
    Route::post('/admin/brand/store',[AdminController::class,'brandStore'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}',[AdminController::class,'editBrand'])->name('admin.brand.edit');
    Route::put('/admin/brand/update',[AdminController::class,'brandUpdate'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete',[AdminController::class,'brandDelete'])->name('admin.brand.delete');

    Route::get('/admin/categories',[AdminController::class,'categories'])->name('admin.categories');
    Route::get('/admin/category/add',[AdminController::class,'categoryAdd'])->name('admin.category.add');
    Route::post('/admin/category/store',[AdminController::class,'categoryStore'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}',[AdminController::class,'editCategory'])->name('admin.category.edit');
    Route::put('/admin/category/update',[AdminController::class,'categoryUpdate'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete',[AdminController::class,'categoryDelete'])->name('admin.category.delete');
});
