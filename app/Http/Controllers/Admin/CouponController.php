<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request ) {
		$request->flash();

		$search_term = $request->input( 'search-term', '' );
		$search_term = '%' . $search_term . '%';
		$coupons     = Coupon::where( 'code', 'LIKE', $search_term );

		if ( $request->filled( 'discount-type' ) ) {
			$filter_by_type = $request->input( 'discount-type' );
			$coupons        = $coupons->where( 'discount_type', $filter_by_type );
		}

		$coupons = $coupons->sortable()->paginate( 24 );

		return view( 'admin.ecommerce.coupons.list', array( 'coupons' => $coupons ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$products   = Product::all();
		$categories = Category::where( 'type', 'product' )->get();
		return view(
			'admin.ecommerce.coupons.create',
			array(
				'products'   => $products,
				'categories' => $categories,
			)
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$coupon = new Coupon();
		$coupon->fill( $request->except( 'expiry_date' ) );
		if ( $request->filled( 'expiry_date' ) ) {
			$coupon->expiry_date = date( 'Y-m-d', strtotime( $request->input( 'expiry_date' ) ) );
		}
		$coupon->save();
		return redirect( '/admin/ecommerce/coupons/' . $coupon->id . '/edit' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$coupon             = Coupon::findOrFail( $id );
		$products           = array();
		$exclude_products   = array();
		$categories         = array();
		$exclude_categories = array();

		if ( count( $coupon->products ) > 0 ) {
			$products = Product::find( $coupon->products );
		}

		if ( count( $coupon->exclude_products ) > 0 ) {
			$exclude_products = Product::find( $coupon->exclude_products );
		}

		if ( count( $coupon->categories ) > 0 ) {
			$categories = Category::find( $coupon->categories );
		}

		if ( count( $coupon->exclude_categories ) > 0 ) {
			$exclude_categories = Category::find( $coupon->exclude_categories );
		}
		return view(
			'admin.ecommerce.coupons.edit',
			compact( 'coupon', 'products', 'exclude_products', 'categories', 'exclude_categories' )
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		$coupon = Coupon::findOrFail( $id );
		$coupon->fill( $request->except( 'expiry_date', 'products', 'exclude_products', 'categories', 'exclude_categories' ) );
		$coupon->products           = $request->input( 'products' );
		$coupon->exclude_products   = $request->input( 'exclude_products' );
		$coupon->categories         = $request->input( 'categories' );
		$coupon->exclude_categories = $request->input( 'exclude_categories' );
		if ( $request->filled( 'expiry_date' ) ) {
			$coupon->expiry_date = date( 'Y-m-d', strtotime( $request->input( 'expiry_date' ) ) );
		}
		$coupon->save();
		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		Coupon::destroy( $id );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulkDestroy( Request $request ) {
		Coupon::destroy( $request->input( 'data' ) );
	}
}
