<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\CouponCodeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\site\CheckoutController;
use App\Http\Controllers\site\CartController;
use App\Http\Controllers\site\HomeController;
use App\Http\Controllers\site\CategoryController as frontcategorypage;
use App\Http\Controllers\site\CustomerController;
use App\Http\Controllers\site\OrderPurchaseController;
use App\Http\Controllers\site\ProductDetailsController;
use App\Http\Controllers\site\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/product-detail/{pid}',[ProductDetailsController::class, 'index'])->name('product.detail');
Route::get('/shop',[HomeController::class, 'shop']);
Route::get('/shop/{category_slug}',[frontcategorypage::class, 'getCategoryProduct']);
Route::get('/search',[HomeController::class, 'search'])->name('product.search');

// Customer Auth
Route::post('/customer/auth/registration', [CustomerController::class,'register'])->name('customer.registration');
Route::post('/customer/auth/login', [CustomerController::class,'login'])->name('customer.login');

// Middleware for Authentic Customer 
Route::group(['middleware' => ['CustomerAuth']], function(){
    Route::get('/customer/auth', [CustomerController::class,'index'])->name('customer.auth');
    Route::get('/customer/dashboard/', [CustomerController::class,'customerDashboard'])->name('customer.dashboard');
    Route::post('/customer/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    
    Route::get('/wishlist',[WishlistController::class, 'index']);
    Route::post('/wishlist/create',[WishlistController::class, 'create']);
    Route::post('/wishlist/delete',[WishlistController::class, 'delete']);
    Route::get('/cart',[CartController::class, 'index'])->name('cart');
    Route::post('/addtocart', [CartController::class, 'addToCart'])->name('addtocart');
    Route::post('/cart/increment',[CartController::class, 'increment']);
    Route::post('/cart/decrement',[CartController::class, 'decrement']);
    Route::post('/cart/delete',[CartController::class, 'delete']);
    Route::get('/checkout',[CheckoutController::class, 'index'])->name('checkout');

    Route::post('/customer/order/process',[OrderPurchaseController::class, 'OrderPurchase'])->name('customer.order.process');
    // Route::post('/customer/cart/coupon/apply', [CartController::class, 'applyCoupon'])->name('apply.coupon');

    //Customer Profile / Account Setting
    Route::post('/customer/profile/update/{id}', [CustomerController::class, 'accountUpdate'])->name('customer.profile.update');
});
// End of Middleware for Authentic Customer 



// Admin Auth
Auth::routes(['register' => false]);
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::group(['middleware' => ['protectedRoutes']], function(){
    // Admin product routes
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.product');
    Route::get('/admin/product/create', [ProductController::class, 'create'])->name('admin.product.add');
    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::put('/admin/product/bulkOp', [ProductController::class, 'BulkOpration'])->name('admin.product.bulk');
    Route::get('/admin/product/{id}/status',[ProductController::class, 'changeStatus'])->name('admin.product.status');
    Route::get('/admin/product/delete/{id}',[ProductController::class, 'delete'])->name('admin.product.delete');
    Route::post('/admin/getcategory', [ProductController::class, 'getCategory']);

    // Category Routes
    Route::get('/admin/categories',[CategoryController::class, 'index'])->name('admin.category');
    Route::get('/admin/category/create',[CategoryController::class, 'create'])->name('admin.category.add');
    Route::post('/admin/category/create',[CategoryController::class, 'store'])->name('admin.category.store');
    Route::put('/admin/category/bulkOp',[CategoryController::class, 'BulkOpration'])->name('admin.category.bulk');
    // will be post method
    Route::get('/admin/category/delete/{id}',[CategoryController::class, 'permanentlyDelete'])->name('admin.category.delete');
    Route::get('/admin/category/{id}/status',[CategoryController::class, 'changeStatus'])->name('admin.category.status');
    Route::get('/admin/category/{id}/edit',[CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}',[CategoryController::class, 'update'])->name('admin.category.update');
    // will be post method
    Route::get('/admin/category/{id}/trash',[CategoryController::class, 'trash'])->name('admin.category.trash');
    Route::get('/admin/category/trash-list',[CategoryController::class, 'trashList'])->name('admin.category.trashlist');
    // will be post method
    Route::get('/admin/category/{id}/restore',[CategoryController::class, 'restore'])->name('admin.category.restore');


    // Sub Category Routes
    Route::get('/admin/subcategory', [SubCategoryController::class,'index'])->name('admin.subcategory');
    Route::post('/admin/subcategory/create', [SubCategoryController::class,'store'])->name('admin.subcategory.store');
    Route::get('/admin/subcategory/{id}/edit', [SubCategoryController::class,'edit'])->name('admin.subcategory.edit');
    Route::put('/admin/subcategory/update/{id}', [SubCategoryController::class,'update'])->name('admin.subcategory.update');
    Route::get('/admin/subcategory/delete/{id}', [SubCategoryController::class,'delete'])->name('admin.subcategory.delete');
    Route::get('/admin/subcategory/status/{id}', [SubCategoryController::class,'changeStatus'])->name('admin.subcategory.status');


    // Color Routes
    Route::get('/admin/color', [ColorController::class, 'index'])->name('admin.color');
    Route::post('/admin/color/create', [ColorController::class, 'store'])->name('admin.color.store');
    Route::get('/admin/color/status/{id}', [ColorController::class,'changeStatus'])->name('admin.color.status');
    Route::get('/admin/color/{id}/edit', [ColorController::class,'edit'])->name('admin.color.edit');
    Route::put('/admin/color/update/{id}', [ColorController::class,'update'])->name('admin.color.update');
    Route::get('/admin/color/delete/{id}', [ColorController::class,'delete'])->name('admin.color.delete');

    // Brand Routes
    Route::get('/admin/brands', [BrandController::class, 'index'])->name('admin.brand');
    Route::post('/admin/brand/create', [BrandController::class, 'store'])->name('admin.brand.store');
    Route::get('/admin/brand/status/{id}', [BrandController::class,'changeStatus'])->name('admin.brand.status');
    Route::get('/admin/brand/{id}/edit', [BrandController::class,'edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update/{id}', [BrandController::class,'update'])->name('admin.brand.update');
    Route::get('/admin/brand/delete/{id}', [BrandController::class,'delete'])->name('admin.brand.delete');


    // Admin Coupon Code Routes
    Route::get('/admin/coupon-code', [CouponCodeController::class, 'index'])->name('admin.coupon');
    Route::post('/admin/coupon/create',[CouponCodeController::class, 'store'])->name('admin.coupon.store');
    Route::get('/admin/coupon/status/{id}',[CouponCodeController::class,'statusChange'])->name('admin.coupon.status');
    Route::get('/admin/coupon/{id}/edit',[CouponCodeController::class, 'edit'])->name('admin.coupon.edit');
    Route::get('/admin/coupon/delete/{id}',[CouponCodeController::class, 'delete']);
});