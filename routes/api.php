<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Address\StateController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Bank\BankController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use App\Http\Controllers\DeliveryManagement\DeliveryManagementController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\People\PeopleController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ShoppingCart\ShoppingCartController;
use App\Http\Controllers\VariationSize\VariationSizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* PUBLIC */

Route::prefix('public')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/signup', [AuthController::class, 'signUp']);
        Route::post('/signin', [AuthController::class, 'signIn']);
    });
    Route::prefix('forgot')->group(function () {
        Route::post('/password', [ForgotPasswordController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
        Route::post('/password-reset', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
    });

    Route::get('/delivery/management', [DeliveryManagementController::class, 'index']);
    Route::get('/bank', [BankController::class, 'index']);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/tracking/{order}', [OrderController::class, 'showTracking']);
    Route::get('/state', [StateController::class, 'index']);
    Route::get('/state/{state}', [StateController::class, 'show']);
    Route::get('/municipality/{municipality}', [StateController::class, 'showMunicipality']);
    Route::prefix('banners')->group(function () {
        Route::get('', [BannerController::class, 'index']);
        Route::post('', [BannerController::class, 'store']);
    });
});

/* AUTHENTICATE */

Route::middleware('auth:api')->group(function () {
    /* API RESOURCE */

    /* BANK */
    Route::prefix('bank')->group(function () {
        Route::apiResource('', BankController::class, array('as' => 'bank'))->except(['index', 'show'])->parameters([
            '' => 'bank'
        ])->middleware(['role:admin']);
    });

    /* DELIVERY MANAGEMENT */
    Route::prefix('delivery/management')->group(function () {
        Route::post('/{deliveryManagement}', [DeliveryManagementController::class, 'update'])->middleware(['role:admin']);
        Route::apiResource('', DeliveryManagementController::class, array('as' => 'deliveryManagement'))->except(['index', 'show', 'put'])->parameters([
            '' => 'deliveryManagement'
        ])->middleware(['role:admin']);
    });

    /* CATEGORY AND SUB CATEGORY */
    Route::prefix('category')->group(function () {
        Route::apiResource('', CategoryController::class, array('as' => 'category'))->except(['index', 'show'])->parameters([
            '' => 'category'
        ])->middleware(['role:admin']);

        Route::post('sub/{category}', [SubCategoryController::class, 'store'])->middleware(['role:admin']);
        Route::apiResource('/sub', SubCategoryController::class, array('as' => 'subCategory'))->except(['show', 'store'])->parameters([
            'sub' => 'subCategory'
        ])->middleware(['role:admin']);
    });

    /* VARIATION SIZE */
    Route::prefix('variation')->group(function () {
        Route::apiResource('', VariationSizeController::class, array('as' => 'variationSize'))->except(['show'])->parameters([
            '' => 'variationSize'
        ])->middleware(['role:admin']);
    });

    /* PRODUCTS */
    Route::prefix('product')->group(function () {
        Route::post('/{product}', [ProductController::class, 'update'])->middleware(['role:admin']);
        Route::apiResource('', ProductController::class, array('as' => 'product'))->except(['index', 'show', 'update'])->parameters([
            '' => 'product'
        ])->middleware(['role:admin']);
    });

    /* ADDRESS */

    Route::prefix('address')->group(function () {
        Route::apiResource('', AddressController::class, array('as' => 'address'))->except(['show', 'update'])->parameters([
            '' => 'address'
        ])->middleware(['role:customer', 'address']);
    });

    /* PREFIX */

    /* PROFILE */

    Route::prefix('profile')->group(function () {
        Route::put('', [PeopleController::class, 'update']);
        Route::put('/password', [PeopleController::class, 'updatePassword']);
    });

    /* SHOPPING CART */

    Route::prefix('shopping/cart')->group(function () {
        Route::get('', [ShoppingCartController::class, 'index'])->middleware(['role:customer']);
        Route::post('/{variation}', [ShoppingCartController::class, 'store'])->middleware(['role:customer']);
        Route::delete('/{shoppingCart}', [ShoppingCartController::class, 'destroy'])->middleware(['shoppingCart']);
    });

    /* ORDER */
    Route::prefix('order')->group(function () {
        Route::post('', [OrderController::class, 'store'])->middleware(['role:customer', 'order']);
        Route::post('/payment/{order}', [OrderController::class, 'addPayment'])->middleware(['role:customer', 'order']);
        Route::put('/{order}', [OrderController::class, 'update'])->middleware(['role:customer|admin', 'order']);
        Route::get('/{order}', [OrderController::class, 'show'])->middleware(['role:customer|admin', 'order']);
        Route::get('', [OrderController::class, 'index'])->middleware(['role:customer|admin']);
    });

    /* TOKEN */
    Route::prefix('check/token')->group(function () {
        Route::get('', [AuthController::class, 'checkToken']);
    });

    /* PEOPLE */
    Route::prefix('people')->group(function () {
        Route::get('', [PeopleController::class, 'index'])->middleware(['role:admin|customer']);
    });

    /* NOTIFICATION */

    Route::prefix('notification')->group(function () {
        Route::get('', [NotificationController::class, 'index']);
        Route::put('/{notification}', [NotificationController::class, 'updateOne']);
        Route::put('/update/all', [NotificationController::class, 'updateAll']);
    });

    /* CONVERSATIONS */
    Route::prefix('conversation')->group(function () {
        Route::get('', [MessageController::class, 'index']);
        Route::get('/{conversation}', [MessageController::class, 'show'])->middleware(['conversation']);
        Route::post('/{people}', [MessageController::class, 'storeConversation'])->middleware(['conversation']);
        Route::post('/message/{conversation}', [MessageController::class, 'store'])->middleware(['message']);
    });
    Route::post('auth/logout', [AuthController::class, 'logout']);
});
