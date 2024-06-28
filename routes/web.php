<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// --- ADMIN: START SIGN IN ---
Route::get('/admin/sign-in', [AuthenticationController::class, 'signIn'])->name('admin.sign-in');
Route::post('/admin/sign-in', [AuthenticationController::class, 'checkSignIn'])->name('admin.sign-in');
// --- ADMIN: END SIGN IN ---

Route::middleware(['auth.admin'])->prefix('admin')->group(function () {

    // --- ADMIN: START DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    // --- ADMIN: END DASHBOARD ---

    // --- ADMIN: START USER ---
    Route::get('/user', [UserController::class, 'user'])->name('admin.user');
    Route::get('/add-user', [UserController::class, 'addUser'])->name('admin.add-user');
    Route::post('/add-user', [UserController::class, 'saveUser'])->name('admin.save-user');
    Route::post('/check-username', [UserController::class, 'checkUsername'])->name('admin.check-username');
    Route::get('/edit-user/{user_id}', [UserController::class, 'editUser'])->name('admin.edit-user');
    Route::post('/update-user', [UserController::class, 'updateUser'])->name('admin.update-user');
    Route::get('/delete-user/{user_id}', [UserController::class, 'deleteUser'])->name('admin.delete-user');
    // --- ADMIN: END USER ---

    // --- ADMIN: START MANUFACTURER ---
    Route::get('/manufacturer', [ManufacturerController::class, 'manufacturer'])->name('admin.manufacturer');
    Route::get('/add-manufacturer', [ManufacturerController::class, 'addManufacturer'])->name('admin.add-manufacturer');
    Route::post('/add-manufacturer', [ManufacturerController::class, 'saveManufacturer'])->name('admin.save-manufacturer');
    Route::get('/edit-manufacturer/{manufacturer_id}', [ManufacturerController::class, 'editManufacturer'])->name('admin.edit-manufacturer');
    Route::post('/update-manufacturer', [ManufacturerController::class, 'updateManufacturer'])->name('admin.update-manufacturer');
    Route::get('/delete-manufacturer/{manufacturer_id}', [ManufacturerController::class, 'deleteManufacturer'])->name('admin.delete-manufacturer');
    // --- ADMIN: END MANUFACTURER ---

    // --- ADMIN: START CATEGORY ---
    Route::get('/category', [CategoryController::class, 'category'])->name('admin.category');
    Route::get('/add-category', [CategoryController::class, 'addcategory'])->name('admin.add-category');
    Route::post('/add-category', [CategoryController::class, 'savecategory'])->name('admin.save-category');
    Route::get('/edit-category/{category_id}', [CategoryController::class, 'editcategory'])->name('admin.edit-category');
    Route::post('/update-category', [CategoryController::class, 'updatecategory'])->name('admin.update-category');
    Route::get('/delete-category/{category_id}', [CategoryController::class, 'deletecategory'])->name('admin.delete-category');
    // --- ADMIN: END CATEGORY ---

    // --- ADMIN: START PRODUCT ---
    Route::get('/product', [ProductController::class, 'product'])->name('admin.product');
    Route::get('/add-product', [ProductController::class, 'addProduct'])->name('admin.add-product');
    Route::post('/add-product', [ProductController::class, 'saveProduct'])->name('admin.save-product');
    Route::get('/edit-product/{product_id}', [ProductController::class, 'editProduct'])->name('admin.edit-product');
    Route::post('/update-product', [ProductController::class, 'updateProduct'])->name('admin.update-product');
    Route::get('/delete-product/{product_id}', [ProductController::class, 'deleteProduct'])->name('admin.delete-product');
    // --- ADMIN: END PRODUCT ---

    // --- ADMIN: START COLOR ---
    Route::get('/color', [ColorController::class, 'color'])->name('admin.color');
    Route::get('/add-color', [ColorController::class, 'addColor'])->name('admin.add-color');
    Route::post('/add-color', [ColorController::class, 'saveColor'])->name('admin.save-color');
    Route::get('/edit-color/{color_id}', [ColorController::class, 'editColor'])->name('admin.edit-color');
    Route::post('/update-color', [ColorController::class, 'updateColor'])->name('admin.update-color');
    Route::get('/delete-color/{color_id}', [ColorController::class, 'deleteColor'])->name('admin.delete-color');
    // --- ADMIN: END COLOR ---

    // --- ADMIN: START BANNER ---
    Route::get('/banner', [BannerController::class, 'banner'])->name('admin.banner');
    Route::get('/add-banner', [BannerController::class, 'addBanner'])->name('admin.add-banner');
    Route::post('/add-banner', [BannerController::class, 'saveBanner'])->name('admin.save-banner');
    Route::get('/delete-banner/{banner_id}', [BannerController::class, 'deleteBanner'])->name('admin.delete-banner');
    // --- ADMIN: END BANNER ---

    // --- ADMIN: START SIZE ---
    Route::get('/size', [SizeController::class, 'size'])->name('admin.size');
    Route::get('/add-size', [SizeController::class, 'addSize'])->name('admin.add-size');
    Route::post('/add-size', [SizeController::class, 'saveSize'])->name('admin.save-size');
    Route::get('/edit-size/{size_id}', [SizeController::class, 'editSize'])->name('admin.edit-size');
    Route::post('/update-size', [SizeController::class, 'updateSize'])->name('admin.update-size');
    Route::get('/delete-size/{size_id}', [SizeController::class, 'deleteSize'])->name('admin.delete-size');
    // --- ADMIN: END SIZE ---

    // --- ADMIN: START ORDER ---
    Route::get('/order', [OrderController::class, 'order'])->name('admin.order');
    Route::get('/order-details/{order_code}', [OrderController::class, 'orderDetails'])->name('admin.order-details');
    Route::post('/order-cancel', [OrderController::class, 'orderCancel'])->name('admin.order-cancel');
    Route::post('/change-order-process', [OrderController::class, 'changeOrderProcess'])->name('admin.change-order-process');
    Route::post('/change-order-shipped', [OrderController::class, 'changeOrderShipped'])->name('admin.change-order-shipped');
    Route::post('/change-order-delivered', [OrderController::class, 'changeOrderDelivered'])->name('admin.change-order-delivered');
    // --- ADMIN: END ORDER ---

    // --- ADMIN: START CONTACT ---
    Route::get('/contact', [ContactController::class, 'allContact'])->name('admin.contact');
    Route::get('/contact-details/{contact_id}', [ContactController::class, 'contactDetails'])->name('admin.contact-details');
    // --- ADMIN: END CONTACT ---

    // --- ADMIN: START POST ---
    Route::get('/post', [PostController::class, 'post'])->name('admin.post');
    Route::get('/add-post', [PostController::class, 'addPost'])->name('admin.add-post');
    Route::post('/add-post', [PostController::class, 'savePost'])->name('admin.save-post');
    Route::get('/edit-post/{post_id}', [PostController::class, 'editPost'])->name('admin.edit-post');
    Route::post('/update-post', [PostController::class, 'updatePost'])->name('admin.update-post');
    Route::get('/delete-post/{post_id}', [PostController::class, 'deletePost'])->name('admin.delete-post');
    // --- ADMIN: END POST ---

    // --- ADMIN: START SIGN OUT ---
    Route::get('/sign-out', [AuthenticationController::class, 'signOut'])->name('admin.sign-out');
    // --- ADMIN: END SIGN OUT ---

});

// --- CLIENT: START HOME ---
Route::get('/', [HomePageController::class, 'home'])->name('client.home');
// --- CLIENT: END HOME ---

// --- CLIENT: START DETAILS ---
Route::get('/product-details/{product_id}', [HomePageController::class, 'productDetails'])->name('client.product-details');
// --- CLIENT: END DETAILS ---

// --- CLIENT: START MANUFACTURER ---
Route::get('/manufacturer/{manufacturer_id}', [HomePageController::class, 'getAllManufacturerById'])->name('client.manufacturer');
// --- CLIENT: END MANUFACTURER ---

// --- CLIENT: START CATEGORY ---
Route::get('/category/{category_id}', [HomePageController::class, 'getAllCategoryById'])->name('client.category');
// --- CLIENT: END CATEGORY ---

// --- CLIENT: START SEARCH ---
Route::get('/search', [HomePageController::class, 'search'])->name('client.search');
// --- CLIENT: END SEARCH ---

// --- CLIENT: START CART ---
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/remove', [CartController::class, 'removeFromCart']);
Route::post('/cart/update-cart', [CartController::class, 'updateCart']);
// --- CLIENT: END CART ---

// --- CLIENT: START LOGIN & REGISTER ---
Route::post('/check-account', [AuthenticationController::class, 'checkAccount'])->name('check-account');
Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
// --- CLIENT: END LOGIN & REGISTER ---

// --- CLIENT: START CONTACT ---
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/send-contact', [ContactController::class, 'sendContact'])->name('send-contact');
// --- CLIENT: END CONTACT ---

// --- CLIENT: START POST ---
Route::get('/post-details/{post_id}', [PostController::class, 'postDetails'])->name('post-details');
// --- CLIENT: END POST ---

Route::middleware(['customer.auth'])->group(function () {
    // --- CLIENT: START CHECKOUT ---
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/save-order', [CheckoutController::class, 'saveOrder']);
    // --- CLIENT: END CHECKOUT ---

    // --- CLIENT: START LOGOUT ---
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
    // --- CLIENT: END LOGOUT ---

    // --- CLIENT: START CITY, DISTRICT, WARD ---
    Route::get('/get-districts/{city_id}', [ShippingController::class, 'getDistricts']);
    Route::get('/get-wards/{city_id}', [ShippingController::class, 'getWards']);
    // --- CLIENT: START CITY, DISTRICT, WARD ---

    // --- CLIENT: START SHIPPING ---
    Route::post('/add-shipping', [ShippingController::class, 'addShipping']);
    Route::get('/get-all-shipping-by-customer-id', [ShippingController::class, 'getAllShippingByCustomerId']);
    Route::post('/set-default-shipping', [ShippingController::class, 'setDefaultShipping']);
    Route::delete('/delete-shipping/{shipping_id}', [ShippingController::class, 'deleteShipping']);
    Route::get('/check-shipping-address', [ShippingController::class, 'checkShippingAddress']);
    // --- CLIENT: END SHIPPING ---

    // --- CLIENT: START ORDER ---
    Route::get('/my-order', [OrderController::class, 'myOrder'])->name('my-order');
    Route::post('/cancel-order', [OrderController::class, 'cancelOrder'])->name('cancel-order');
    // --- CLIENT: END ORDER ---

    // --- CLIENT: START REVIEW ---
    Route::post('/add-review/{product_id}', [ProductReviewController::class, 'addReview'])->name('product-review');
    // --- CLIENT: END REVIEW ---
});
