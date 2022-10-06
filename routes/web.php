<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Client\VendorController;

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

Route::prefix( 'web' )->name( 'client.' )->group(
	function () {
		// Route for retrieving initial data (tags, categories and settings)
		Route::get( '/initial-data', array( HomeController::class, 'getInitialData' ) );

		// Route for index page
		Route::get( '/', array( HomeController::class, 'getIndexPageData' ) );
		Route::get( '/products-search', array( HomeController::class, 'productsSearch' ) );

		// Route for shop page
		Route::group(
			array(
				'prefix' => 'shop',
				'as'     => 'shop',
			),
			function () {
				Route::get( '/sidebar', array( ShopController::class, 'getShopSidebarData' ) );
				Route::get( '/', array( ShopController::class, 'getShopData' ) );
			}
		);

		// Route for product page
		Route::group(
			array(
				'prefix' => 'products',
				'as'     => 'products',
			),
			function () {
				Route::get( '/quick/{slug}', array( ProductController::class, 'getQuickViewProduct' ) );
				Route::get( '/{slug}', array( ProductController::class, 'getProduct' ) );
				Route::post( '/review', array( ProductController::class, 'productReview' ) );
			}
		);

		// Route for blog page
		Route::prefix( 'posts' )->name( 'posts.' )->group(
			function () {
				Route::get( '/', array( PostController::class, 'getPosts' ) );
				Route::get( '/sidebar', array( PostController::class, 'getSidebar' ) );
				Route::get( '/{slug}', array( PostController::class, 'getPost' ) );

				Route::post( '/comment', array( PostController::class, 'postComment' ) );
			}
		);

		// Route for vendor page
		Route::prefix( 'vendors' )->name( 'vendors.' )->group(
			function () {
				Route::get( '/', array( VendorController::class, 'getVendors' ) );
				Route::get( '/{id}', array( VendorController::class, 'getSingleVendor' ) )->where( 'id', '[0-9]+' );
			}
		);

		// Route for chekout page
		Route::post( '/shipping-tax-info', array( CheckoutController::class, 'getCalculatedItems' ) );
		Route::post( '/place-order', array( CheckoutController::class, 'placeOrder' ) );
		Route::get( '/payment-methods', array( CheckoutController::class, 'getAvailablePaymentMethods' ) );

		// Route for account pages
		Route::get( '/customer-orders/{customer}', array( AccountController::class, 'getCustomerOrders' ) );
		Route::get( '/order-detail/{id}', array( AccountController::class, 'getOrderDetail' ) )->where( 'id', '[0-9]+' );
		Route::get( '/downloads/{customer}', array( AccountController::class, 'getDownloadableProducts' ) );
		Route::put( '/account-detail', array( AccountController::class, 'changeAccountDetail' ) );
		Route::put( '/account-billing-address', array( AccountController::class, 'changeAccountBillingAddress' ) );
		Route::put( '/account-shipping-address', array( AccountController::class, 'changeAccountShippingAddress' ) );
		Route::get( '/download', array( AccountController::class, 'downloadFile' ) );

		// contact form
		Route::post( '/contact', array( HomeController::class, 'sendMail' ) );
	}
);

Route::get( '/{vue?}', array( HomeController::class, 'index' ) )
		->where( 'vue', '.*' )
		->middleware( 'installed' );
