<?php


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Middleware\CheckLoginCustomer;
use App\Http\Controllers\admin\AgeController;
use App\Http\Controllers\admin\CastController;
use App\Http\Controllers\admin\FoodController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SeatController;
use App\Http\Controllers\admin\GenreController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\SeatTypeController;
use App\Http\Controllers\admin\ScreeningController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AuditoriumController;

use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\customer\BookingController;
use App\Http\Controllers\admin\ReservationTypeController;

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

//Route::get('/', function (){
//    return 'hello';
//});

Route::get('/', [\App\Http\Controllers\customer\HomeController::class, 'index'])->name('home');
//Route::get('/home', [\App\Http\Controllers\customer\HomeController::class, 'index'])->name('home');


Route::get('/about-us', function () {
    return view('customer.about-us');
})->name('about');

Route::get('/movie/{movieAge?}', [MovieController::class, 'show'])->name('movie');
//Route::get('/book-ticket/{movie}', [MovieController::class, 'bookTickets'])->name('bookTickets');
Route::post('/book-ticket/{movie}', [MovieController::class, 'tickets'])->name('tickets');
Route::get('/movie-details/{movie}', [MovieController::class, 'showDetails'])->name('movie-details');
Route::post('/add-to-wishlist', [\App\Http\Controllers\customer\HomeController::class, 'addToWishlist'])->name('customer.addToWishlist');
Route::get('/contact-us', function (){
    return view('customer.contact-us');
})->name('contact_us');
Route::post('/send-contact-email', [\App\Http\Controllers\customer\HomeController::class, 'sendContactEmail'])->name('sendContactEmail');
Route::get('/forgot-password', [\App\Http\Controllers\customer\CustomerController::class, 'forgotPassword'])->name('customer.forgotPassword');
Route::post('/process-forgot-password', [\App\Http\Controllers\customer\CustomerController::class, 'processForgotPassword'])->name('customer.processForgotPassword');
Route::get('/reset-password/{token}', [\App\Http\Controllers\customer\CustomerController::class, 'resetPassword'])->name('customer.resetPassword');
Route::post('/process-reset-password', [\App\Http\Controllers\customer\CustomerController::class, 'processResetPassword'])->name('customer.processResetPassword');

//show 1 product
//Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.details');
//Route::get('/step-one/{movie}',[OrderController::class,'bookTickets'])->name('bookTickets');
//Route::post('/postScreening',[OrderController::class,'postScreening'])->name('postScreening');
//// Route::post('stepTwo',[OrderController::class,'choosingSeat'])->name('choosingSeat');
//Route::get('/step-two/{movie}',[OrderController::class,'order'])->name('bookTickets_stepTwo');
//
////Route::get('booking',[OrderController::class,'order'])->name('booking');
//Route::post('booking',[OrderController::class,'bookingStore'])->name('bookingStore');
Route::get('/home',[\App\Http\Controllers\customer\HomeController::class,'index'])->name('choosingMovie');
Route::post('postMovie/{movie}',[\App\Http\Controllers\customer\HomeController::class,'postMovie'])->name('postMovie');
Route::get('choosingScreening/{movie_id}',[BookingController::class,'choosingScreening'])->name('choosingScreening');
Route::post('postScreening/{movie_id}',[BookingController::class,'postScreening'])->name('postScreening');
Route::get('/test',[BookingController::class,'finishCheckOut'])->name('test');


Route::get('/help', function () {
    return view('customer.help');
})->name('help');

// CUSTOMER
Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'customer.guest'] , function (){
        Route::get('/login', [\App\Http\Controllers\customer\CustomerController::class, 'login'])->name('customer.login');
        Route::post('/authenticate', [\App\Http\Controllers\customer\CustomerController::class, 'authenticate'])->name('customer.loginProcess');
        Route::get('/register', [\App\Http\Controllers\customer\CustomerController::class, 'register'])->name('customer.register');
        Route::post('/process-register', [\App\Http\Controllers\customer\CustomerController::class, 'registerProcess'])->name('customer.registerProcess');
    });

    Route::group(['middleware' => 'customer.auth'] , function (){
        Route::get('/logout', [\App\Http\Controllers\customer\CustomerController::class, 'logout'])->name('customer.logout');

        Route::get('/profile', [\App\Http\Controllers\customer\CustomerController::class, 'profile'])->name('profile');
        Route::post('/update-profile', [\App\Http\Controllers\customer\CustomerController::class, 'update_profile'])->name('updateProfile');

        Route::get('/my-wishlist', [\App\Http\Controllers\customer\CustomerController::class, 'wishlist'])->name('wishlist');
        Route::post('/remove-movie-from-wishlist', [\App\Http\Controllers\customer\CustomerController::class, 'removeMovieFromWishList'])->name('removeMovieFromWishlist');

        Route::get('/change-password', [\App\Http\Controllers\customer\CustomerController::class, 'showChangePassword'])->name('customer.change_password');
        Route::post('/process-change-password', [\App\Http\Controllers\customer\CustomerController::class, 'changePassword'])->name('customer.process_change_password');

        Route::get('/orders_history', [App\Http\Controllers\customer\CustomerController::class, 'showOrderHistory'])->name('orderHistory');
        Route::get('/order_detail/{reservation}', [App\Http\Controllers\customer\CustomerController::class, 'orderDetail'])->name('orderDetail');

        Route::get('choosingSeat/{movie_id}',[BookingController::class,'choosingSeat'])->name('choosingSeat');
        Route::post('postSeat/{movie_id}',[BookingController::class,'postSeat'])->name('postSeat');
        Route::get('/checkout/{movie_id}', [BookingController::class, 'checkout'])->name('customer.checkout');
        Route::post('/vnpay_payment',[BookingController::class,'vnpay_payment'])->name('vnpay_payment');
    });
});


// ADMIN
Route::group(['prefix' => 'admin'], function (){

   Route::group(['middleware' => 'admin.guest'], function() {
       Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
       Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
   });

    Route::group(['middleware' => 'admin.auth'], function() {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');
        Route::get('/profile', [\App\Http\Controllers\admin\AdminController::class, 'profile'])->name('admin.profile');
        Route::get('/change-password', [AdminLoginController::class, 'showChangePasswordForm'])->name('change_password');
        Route::post('/process-change-password', [AdminLoginController::class, 'processChangePassword'])->name('process_change_password');
        Route::post('/upload-temp-image', [TempImagesController::class, 'createImgUser'])->name('user.temp-images.create');
        Route::post('/update', [\App\Http\Controllers\admin\AdminController::class, 'update'])->name('user.update');
        // GENRE ROUTE
        Route::prefix('/genre')->group(function () {

            Route::get('/', [GenreController::class, 'index'])->name('genre.index');
            //show create form
            Route::get('/create', [GenreController::class, 'create'])->name('genre.create');
            Route::post('/create', [GenreController::class, 'store'])->name('genre.store');

            //show edit form
            Route::get('/{genre}/edit', [GenreController::class, 'edit'])->name('genre.edit');
            Route::put('/{genre}', [GenreController::class, 'update'])->name('genre.update');
            Route::delete('/{genre}', [GenreController::class, 'destroy'])->name('genre.destroy');
        });


        Route::prefix('/food')->group(function () {

            Route::get('/', [FoodController::class, 'index'])->name('food.index');
        
            // Show create form for food
            Route::get('/create', [FoodController::class, 'create'])->name('food.create');
            Route::post('/create', [FoodController::class, 'store'])->name('food.store');
        
            // Edit and update routes for food
            Route::get('/{food}/edit', [FoodController::class, 'edit'])->name('food.edit');
            Route::put('/{food}', [FoodController::class, 'update'])->name('food.update');
            Route::post('/upload-temp-image', [TempImagesController::class, 'createFoodImg'])->name('food.temp-images.create');

            // Delete route for food
            Route::delete('/{food}', [FoodController::class, 'destroy'])->name('food.destroy');
        });

        
        // MOVIE ROUTE
        Route::prefix('/movie')->group(function () {

            Route::get('/', [MovieController::class, 'index'])->name('movie.index');
            Route::get('/detail/{movie}', [MovieController::class, 'indexDetail'])->name('movie.indexDetail');
            //show create form
            Route::get('/create', [MovieController::class, 'create'])->name('movie.create');
            Route::post('/create', [MovieController::class, 'store'])->name('movie.store');
            Route::post('/upload-temp-image', [TempImagesController::class, 'createImgMovie'])->name('movie.temp-images.create');

            //show edit form
            Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('movie.edit');
            Route::put('/{movie}', [MovieController::class, 'update'])->name('movie.update');
            Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('movie.destroy');
        });

        // ADMIN SCREENING ROUTE
        Route::prefix('/screening')->group(function () {

            Route::get('/', [ScreeningController::class, 'index'])->name('screening.index');
            //show create form
            Route::get('/create', [ScreeningController::class, 'create'])->name('screening.create');
            Route::post('/create', [ScreeningController::class, 'store'])->name('screening.store');

            //show edit form
            Route::get('/{screening}/edit', [ScreeningController::class, 'edit'])->name('screening.edit');
            Route::put('/{screening}', [ScreeningController::class, 'update'])->name('screening.update');
            Route::delete('/{screening}', [ScreeningController::class, 'destroy'])->name('screening.destroy');
        });

        // ADMIN AUDITORIUM ROUTE
        Route::prefix('/auditorium')->group(function () {

            Route::get('/', [AuditoriumController::class, 'index'])->name('auditorium.index');
            //show create form
            Route::get('/create', [AuditoriumController::class, 'create'])->name('auditorium.create');
            Route::post('/create', [AuditoriumController::class, 'store'])->name('auditorium.store');

            //show edit form
            Route::get('/{auditorium}/edit', [AuditoriumController::class, 'edit'])->name('auditorium.edit');
            Route::put('/{auditorium}', [AuditoriumController::class, 'update'])->name('auditorium.update');
            Route::delete('/{auditorium}', [AuditoriumController::class, 'destroy'])->name('auditorium.destroy');
        });


        // ADMIN SEAT ROUTE

        Route::prefix('/seat')->group(function () {

            Route::get('/', [SeatController::class, 'index'])->name('seat.index');
            //show create form
            Route::get('/create', [SeatController::class, 'create'])->name('seat.create');
            Route::post('/create', [SeatController::class, 'store'])->name('seat.store');

            Route::get('/change', [SeatController::class, 'change'])->name('seat.change');
            Route::put('/change', [SeatController::class, 'changeStore'])->name('seat.changeStore');

            //show edit form
            Route::get('/{seat}/edit', [SeatController::class, 'edit'])->name('seat.edit');
            Route::put('/{seat}', [SeatController::class, 'update'])->name('seat.update');
            Route::delete('/{seat}', [SeatController::class, 'destroy'])->name('seat.destroy');
        });

        // Reservation Type Admin Controller Route
        Route::prefix('/seatType')->group(function () {

            Route::get('/', [SeatTypeController::class, 'index'])->name('seatType.index');
            //show create form
            Route::get('/create', [SeatTypeController::class, 'create'])->name('seatType.create');
            Route::post('/create', [SeatTypeController::class, 'store'])->name('seatType.store');

            //show edit form
            Route::get('/{seatType}/edit', [SeatTypeController::class, 'edit'])->name('seatType.edit');
            Route::put('/{seatType}', [SeatTypeController::class, 'update'])->name('seatType.update');
            Route::delete('/{seatType}', [SeatTypeController::class, 'destroy'])->name('seatType.destroy');
        });




        // ADMIN ORDER MANAGER
        Route::prefix('/order')->group(function () {

            Route::get('/', [OrderController::class, 'index'])->name('order.index');
            //show create form
            Route::get('/create', [OrderController::class, 'create'])->name('order.create');
            Route::post('/create', [OrderController::class, 'store'])->name('order.store');

            //show edit form
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('order.edit');
            Route::put('/{order}', [OrderController::class, 'update'])->name('order.update');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
        });

        // CAST ROUTE
        Route::prefix('/cast')->group(function () {

            Route::get('/', [CastController::class, 'index'])->name('cast.index');
            //show create form
            Route::get('/create', [CastController::class, 'create'])->name('cast.create');
            Route::post('/create', [CastController::class, 'store'])->name('cast.store');
            Route::post('/upload-temp-image', [TempImagesController::class, 'createImgCast'])->name('cast.temp-images.create');

            //show edit form
            Route::get('/{cast}/edit', [CastController::class, 'edit'])->name('cast.edit');
            Route::put('/{cast}', [CastController::class, 'update'])->name('cast.update');
            Route::delete('/{cast}', [CastController::class, 'destroy'])->name('cast.destroy');
            Route::get('/getSlug', function (\Illuminate\Http\Request $request){
               $slug = '';
               if (!empty($request->title)) {
                   $slug = Str::slug($request->title);
               }
               return response()->json([
                  'status' => true,
                   'slug' => $slug
               ]);
            })->name('getSlug');
        });

        // GENRE ROUTE
        Route::prefix('/age')->group(function () {

            Route::get('/', [AgeController::class, 'index'])->name('age.index');
            //show create form
            Route::get('/create', [AgeController::class, 'create'])->name('age.create');
            Route::post('/create', [AgeController::class, 'store'])->name('age.store');

            //show edit form
            Route::get('/{age}/edit', [AgeController::class, 'edit'])->name('age.edit');
            Route::put('/{age}', [AgeController::class, 'update'])->name('age.update');
            Route::delete('/{age}', [AgeController::class, 'destroy'])->name('age.destroy');
        });

        //  CUSTOMER ADMIN ROUTE
        Route::prefix('/customer')->group(function () {

            Route::get('/', [CustomerController::class, 'indexAdmin'])->name('customerAdmin.index');
            //show create form
            Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
            Route::post('/create', [CustomerController::class, 'store'])->name('customer.store');

            //show edit form
            Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
            Route::put('/{customer}', [CustomerController::class, 'update'])->name('customer.update');
            Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
        });
    });
});




//Route::middleware(CheckLoginCustomer::class)->group(function () {
//
//
//    Route::get('/orders_history', [CustomerController::class, 'showOrderHistory'])->name('orderHistory');
//    Route::get('/order_detail/{order}', [CustomerController::class, 'orderDetail'])->name('orderDetail');
////    Route::get('/cancel_order/{order}', [OrderController::class, 'cancelOrder'])->name('cancelOrder');
//
//    Route::get('/change_password', [CustomerController::class, 'editPassword'])->name('pwd.edit');
//    Route::put('/change_password', [CustomerController::class, 'updatePassword'])->name('pwd.update');
//
////    Route::get('/cart', [ProductController::class, 'cart'])->name('product.cart');
////    Route::get('/addToCart/{id}', [ProductController::class, 'addToCart'])->name('product.addToCart');
////    Route::get('/addToCartAjax/{id}', [ProductController::class, 'addToCartAjax'])->name('product.addToCartAjax');
////    Route::get('/updateCartQuantity/{id}', [ProductController::class, 'updateCartQuantity'])->name('product.updateCartQuantity');
////    Route::get('/deleteFromCart/{id}', [ProductController::class, 'deleteFromCart'])->name('product.deleteFromCart');
////    Route::get('/deleteAllFromCart', [ProductController::class, 'deleteAllFromCart'])->name('product.deleteAllFromCart');
////
////    Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
////    Route::post('/checkout', [OrderController::class, 'checkoutProcess'])->name('checkoutProcess');
//});