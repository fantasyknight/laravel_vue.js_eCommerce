<?php
use App\Http\Controllers\Admin\InstallerController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeTermController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostCommentController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ThemeSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('installer')->name('installer.')->group(function () {
    Route::get('/', [InstallerController::class, 'welcome']);
    Route::get('/welcome', [InstallerController::class, 'welcome']);
    Route::get('/status', [InstallerController::class, 'status']);
    Route::get('/database', [InstallerController::class, 'database']);
    Route::get('/admin', [InstallerController::class, 'admin']);
    Route::get('/demo', [InstallerController::class, 'demo']);
    Route::get('/ready', [InstallerController::class, 'ready']);
    Route::get('/phpinfo', [InstallerController::class, 'phpinfo']);
    Route::get('/site', [InstallerController::class, 'site']);
    Route::post('/database', [InstallerController::class, 'storeDatabase']);
    Route::post('/demo', [InstallerController::class, 'storeDemo']);
    Route::post('/admin', [InstallerController::class, 'storeAdmin']);
    Route::post('/activate', [InstallerController::class, 'activate']);
    Route::post('/site', [InstallerController::class, 'changeSite']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'installed'], 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // media routes
    Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
        Route::get('/setting', [MediaController::class, 'showSetting'])->middleware('role.check');

        Route::put('/setting', [MediaController::class, 'setting'])->middleware('role.check');

        Route::get('/create', [MediaController::class, 'create']);
        Route::get('/{type}', [MediaController::class, 'index'])->where('type', 'grid|list');
        Route::get('/{id}/edit', [MediaController::class, 'edit'])->where('id', '[0-9]+');
        Route::post('/', [MediaController::class, 'store']);
        Route::put('/{id}', [MediaController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [MediaController::class, 'destroy'])->where('id', '[0-9]+');
        Route::delete('/bulk', [MediaController::class, 'bulkDestroy']);
        Route::get('/fetch', [MediaController::class, 'fetch']);
    });

    // posts and products tag routes
    Route::group(['prefix' => 'tags'], function () {
        Route::get('/{type}', [TagController::class, 'index'])->where('type', 'product|post');
        Route::get('/{id}/edit', [TagController::class, 'edit'])->where('id', '[0-9]+')->middleware('role.check');
        Route::post('/', [TagController::class, 'store']);
        Route::get('/{type}/create', [TagController::class, 'create'])->where('type', 'product|post');
        Route::put('/{id}', [TagController::class, 'update'])->where('id', '[0-9]+')->middleware('role.check');
        Route::delete('/{id}', [TagController::class, 'destroy'])->where('id', '[0-9]+')->middleware('role.check');
        Route::delete('/bulk', [TagController::class, 'bulkDestroy'])->middleware('role.check');
    });

    // posts and products category routes
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/{type}', [CategoryController::class, 'index'])->where('type', 'product|post');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->where('id', '[0-9]+')->middleware('role.check');
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{type}/create', [CategoryController::class, 'create'])->where('type', 'product|post');
        Route::put('/{id}', [CategoryController::class, 'update'])->where('id', '[0-9]+')->middleware('role.check');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->where('id', '[0-9]+')->middleware('role.check');
        Route::delete('/bulk', [CategoryController::class, 'bulkDestroy'])->middleware('role.check');
        Route::get('/search', [CategoryController::class, 'search']);
    });

    // ecommerce routes
    Route::group(['prefix' => 'ecommerce', 'as' => 'ecommerce'], function () {
        Route::get('/', [OrderController::class, 'index']);
        
        Route::group(['prefix' => 'settings', 'as' => 'settings', 'middleware' => 'role.check'], function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/general', [SettingController::class, 'ecommerceGeneral']);
            Route::get('/product', [SettingController::class, 'ecommerceProduct']);
            Route::get('/shipping', [SettingController::class, 'ecommerceShipping']);

            Route::group(['prefix' => 'payment', 'as' => 'payment'], function () {
                Route::get('/', [SettingController::class, 'ecommercePayment']);
                Route::get('/{id}/edit', [SettingController::class, 'paymentMethodEdit'])->where('id', '[0-9]+');
                Route::post('/{id}/changeStatus', [SettingController::class, 'changePaymentMethodStatus'])->where('id', '[0-9]+');
                Route::put('/{id}', [SettingController::class, 'paymentUpdate'])->where('id', '[0-9]+');
            });

            Route::group(['prefix' => 'tax', 'as' => 'tax'], function () {
                Route::get('/', [SettingController::class, 'ecommerceTax']);
                Route::get('/create', [SettingController::class, 'ecommerceTaxCreate']);
                Route::post('/', [SettingController::class, 'ecommerceTaxStore']);
                Route::get('/{id}/edit', [SettingController::class, 'ecommerceTaxEdit'])->where('id', '[0-9]+');
                Route::put('/{id}', [SettingController::class, 'ecommerceTaxUpdate'])->where('id', '[0-9]+');
                Route::delete('/bulk', [SettingController::class, 'ecommerceTaxBulkDestroy']);
                Route::post('/tax-rate', [SettingController::class, 'ecommerceTaxRateStore']);
                Route::put('/tax-rate/{id}', [SettingController::class, 'ecommerceTaxRateUpdate'])->where('id', '[0-9]+');
                Route::delete('/tax-rate/bulk', [SettingController::class, 'ecommerceTaxRateBulkDestroy']);
            });

            Route::group(['prefix' => 'shipping', 'as' => 'shipping'], function () {
                Route::get('/', [SettingController::class, 'ecommerceShipping']);
                Route::get('/create', [SettingController::class, 'ecommerceShippingCreate']);
                Route::post('/', [SettingController::class, 'ecommerceShippingStore']);
                Route::get('/{id}/edit', [SettingController::class, 'ecommerceShippingEdit'])->where('id', '[0-9]+');
                Route::put('/{id}', [SettingController::class, 'ecommerceShippingUpdate'])->where('id', '[0-9]+');
                Route::post('/method', [SettingController::class, 'ecommerceShippingMethodStore']);
                Route::post('/method/status', [SettingController::class, 'ecommerceShippingMethodStatus']);
                Route::get('/method/{id}', [SettingController::class, 'ecommerceShippingMethod'])->where('id', '[0-9]+');
                Route::put('/method/{id}', [SettingController::class, 'ecommerceShippingMethodUpdate'])->where('id', '[0-9]+');
                Route::delete('/method/{id}', [SettingController::class, 'ecommerceShippingMethodDestroy'])->where('id', '[0-9]+');
                Route::delete('/bulk', [SettingController::class, 'ecommerceShippingBulkDestroy']);
            });

            Route::post('/theme', [SettingController::class, 'themeSettingsUpdate']);

            Route::put('/', [SettingController::class, 'update']);
        });

        Route::group(['prefix' => 'coupons', 'as' => 'coupons', 'middleware' => 'role.check'], function () {
            Route::get('/', [CouponController::class, 'index']);
            Route::get('/create', [CouponController::class, 'create']);
            Route::post('/', [CouponController::class, 'store']);
            Route::get('/{id}/edit', [CouponController::class, 'edit'])->where('id', '[0-9]+');
            Route::put('/{id}', [CouponController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('/{id}', [CouponController::class, 'destroy'])->where('id', '[0-9]+');
            Route::delete('/bulk', [CouponController::class, 'bulkDestroy']);
        });
        
        Route::group(['prefix' => 'orders', 'as' => 'orders'], function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/create', [OrderController::class, 'create'])->middleware('role.check');
            Route::post('/', [OrderController::class, 'store'])->middleware('role.check');
            Route::get('/{id}/edit', [OrderController::class, 'edit'])->where('id', '[0-9]+');
            Route::put('/{id}', [OrderController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->where('id', '[0-9]+');
            Route::delete('/bulk', [OrderController::class, 'bulkDestroy'])->middleware('role.check');
            Route::post('/refund', [OrderController::class, 'addRefund'])->middleware('role.check');
            Route::delete('/refund/{refund_id}', [OrderController::class, 'deleteRefund'])->where('refund_id', '[0-9]+');
            Route::post('/notes', [OrderController::class, 'addNote']);
            Route::delete('/notes/{note_id}', [OrderController::class, 'deleteNote'])->where('note_id', '[0-9]+');
            Route::get('/holding-orders', [OrderController::class, 'getHoldingOrders']);
            Route::post('/apply-coupons', [OrderController::class, 'calculateCoupons']);
        });

        Route::get('/customers', [UserController::class, 'customers'])->middleware('role.check');

        Route::group(['prefix' => 'reports', 'as' => 'reports', 'middleware' => 'role.check'], function () {
            Route::get('/', [ReportController::class, 'ordersReport']);
            Route::get('/orders', [ReportController::class, 'ordersReport']);
            Route::get('/get-orders', [ReportController::class, 'getOrdersReport']);
            Route::get('/customers', [ReportController::class, 'customersReport']);
            Route::get('/get-customers', [ReportController::class, 'getCustomersReport']);
            Route::get('/stock', [ReportController::class, 'stockReport']);
            Route::get('/get-stock', [ReportController::class, 'getStockReport']);
        });

        Route::group(['prefix' => 'vendor-setting', 'as' => 'vendor-setting'], function () {
            Route::get('/{id}', [VendorController::class, 'getSetting'])->where('id', '[0-9]+');
            Route::put('/{id}', [VendorController::class, 'updateVendor'])->where('id', '[0-9]+');
        });

        Route::group(['prefix' => 'vendor-withdraw', 'as' => 'vendor-withdraw'], function () {
            Route::get('/', [VendorController::class, 'getWithdraw']);
            Route::post('/add', [VendorController::class, 'addWithdraw']);
            Route::put('/cancel/{id}', [VendorController::class, 'cancelWithdraw']);
        });
    });

    // multivendor routes
    Route::group(['prefix' => 'multivendor', 'as' => 'multivendor', 'middleware' => 'role.check'], function () {
        Route::get('/vendor', [VendorController::class, 'getVendors']);
        Route::get('/withdraw', [VendorController::class, 'getAllWithdraws']);
        Route::get('/setting', [SettingController::class, 'ecommerceVendor']);
        Route::post('/featured', [VendorController::class, 'changeFeatured']);
        Route::post('/status', [VendorController::class, 'changeStatus']);
        Route::put('/cancel/{id}', [VendorController::class, 'cancelWithdraw'])->where('id', '[0-9]+');
        Route::put('/delete/{id}', [VendorController::class, 'deleteWithdraw'])->where('id', '[0-9]+');
        Route::put('/approve/{id}', [VendorController::class, 'approveWithdraw'])->where('id', '[0-9]+');
    });

    // posts routes
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/create', [PostController::class, 'create']);
        Route::post('/', [PostController::class, 'store']);
        Route::get('/{id}/edit', [PostController::class, 'edit'])->where('id', '[0-9]+');
        Route::put('/{id}', [PostController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [PostController::class, 'destroy'])->where('id', '[0-9]+');
        Route::delete('/bulk', [PostController::class, 'bulkDestroy']);
        
        Route::group(['prefix' => 'comments', 'middleware' => 'role.check', 'as' => 'comments.'], function () {
            Route::get('/', [PostCommentController::class, 'index']);
            Route::post('/', [PostCommentController::class, 'store']);
            Route::get('/{id}/edit', [PostCommentController::class, 'edit'])->where('id', '[0-9]+');
            Route::put('/{id}', [PostCommentController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('/{id}', [PostCommentController::class, 'destroy'])->where('id', '[0-9]+');
            Route::delete('/bulk', [PostCommentController::class, 'bulkDestroy']);
        });
    });

    // products routes
    Route::group(['prefix' => 'products', 'as' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/create', [ProductController::class, 'create']);
        Route::get('/{id}/edit', [ProductController::class, 'edit']);
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update'])->where('id', '[0-9]+');
        Route::get('/low-out-stock', [ProductController::class, 'getLowOutStockProducts']);
        Route::delete('bulk', [ProductController::class, 'bulkDestroy']);
        Route::post('/featured', [ProductController::class, 'changeFeatured']);
        Route::get('/search', [ProductController::class, 'search']);
        
        Route::group(['prefix' => 'attributes', 'as' => 'attributes'], function () {
            Route::get('/', [AttributeController::class, 'index']);
            Route::post('/', [AttributeController::class, 'store']);
            Route::get('/{id}/edit', [AttributeController::class, 'edit'])->where('id', '[0-9]+')->middleware('role.check');
            Route::put('/{id}', [AttributeController::class, 'update'])->where('id', '[0-9]+')->middleware('role.check');
            Route::delete('/{id}', [AttributeController::class, 'destroy'])->where('id', '[0-9]+')->middleware('role.check');
    
            Route::group(['prefix' => 'terms', 'as' => 'terms'], function () {
                Route::get('/', [AttributeTermController::class, 'index']);
                Route::get('/create', [AttributeTermController::class, 'create']);
                Route::post('/', [AttributeTermController::class, 'store']);
                Route::post('/ajax', [AttributeTermController::class, 'ajaxStore']);
                Route::get('/{id}/edit', [AttributeTermController::class, 'edit'])->where('id', '[0-9]+')->middleware('role.check');
                Route::put('/{id}', [AttributeTermController::class, 'update'])->where('id', '[0-9]+')->middleware('role.check');
                Route::delete('/{id}', [AttributeTermController::class, 'destroy'])->where('id', '[0-9]+')->middleware('role.check');
                Route::delete('/bulk', [AttributeTermController::class, 'bulkDestroy'])->middleware('role.check');
            });
        });
        
        Route::group(['prefix' => 'comments', 'middleware' => 'role.check', 'as' => 'comments'], function () {
            Route::get('/', [ProductReviewController::class, 'index']);
            Route::post('/', [ProductReviewController::class, 'store']);
            Route::get('/{id}/edit', [ProductReviewController::class, 'edit'])->where('id', '[0-9]+');
            Route::put('/{id}', [ProductReviewController::class, 'update'])->where('id', '[0-9]+');
            Route::delete('/{id}', [ProductReviewController::class, 'destroy'])->where('id', '[0-9]+');
            Route::delete('/bulk', [ProductReviewController::class, 'bulkDestroy']);
        });
    });

    Route::group(['prefix' => 'users', 'as' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->middleware('role.check');
        Route::get('/create', [UserController::class, 'create'])->middleware('role.check');
        Route::post('/', [UserController::class, 'store'])->middleware('role.check');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->where('id', '[0-9]+');
        Route::put('/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+')->middleware('role.check');
        Route::delete('/bulk', [UserController::class, 'bulkDestroy'])->middleware('role.check');
        Route::get('/new-customers', [UserController::class, 'getNewCustomers'])->middleware('role.check');
    });

    Route::group(['prefix' => 'customize', 'as' => 'customize'], function () {
        Route::group(['prefix' => 'menu', 'as' => 'menu'], function () {
            Route::get('/', [ThemeSettingController::class, 'menuShow']);
            Route::post('/', [ThemeSettingController::class, 'storeMenu']);
        });
    });

    Route::get('theme-settings{path}', [ThemeSettingController::class, 'index'])->where('path', '(.*)')->middleware('role.check');

    Route::get('logout', [UserController::class, 'logout']);
});
