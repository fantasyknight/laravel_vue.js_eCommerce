<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Auth;
use Mail;

use App\Http\Controllers\Admin\CategoryController;
use App\Models\User;
use App\Models\Post;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use App\Models\OrderItem;

class HomeController extends Controller {

	/**
	 * Show Client Site
	 */
	public function index() {
		return view(
			'client.layout',
			array(
				'site_title' => config( 'setting.site_title' ),
				'tagline'    => config( 'setting.tagline' ),
			)
		);
	}

	/**
	 * Get Data for demo
	 *
	 * @param \Iluuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function getIndexPageData() {
		$featured_products = Product::select( array( 'id', 'name', 'slug', 'parent', 'type', 'price', 'sale_end', 'sale_price', 'sale_schedule', 'sale_start', 'excerpt', 'short_desc', 'featured', 'manage_stock', 'stock_status', 'stock_quantity', 'sold_individually' ) )
									->with( array( 'media:copy_link', 'categories:slug,name' ) )
									->where( 'parent', 0 )
									->withCount( 'approvedReviews' )
									->where( 'featured', true )
									->has( 'media' )
									->take( 5 )
									->get();
		$new_arrivals      = Product::select( array( 'id', 'name', 'slug', 'parent', 'type', 'price', 'sale_end', 'sale_price', 'sale_schedule', 'sale_start', 'excerpt', 'short_desc', 'featured', 'manage_stock', 'stock_status', 'stock_quantity', 'sold_individually' ) )
								->with( array( 'media:copy_link', 'categories:slug,name' ) )
								->where( 'parent', 0 )
								->withCount( 'approvedReviews' )
								->where( 'created_at', '>', date( strtotime( 'last month' ) ) )
								->has( 'media' )
								->latest()
								->take( 6 )
								->get();

		$top_rates_products = Product::select( array( 'id', 'name', 'slug', 'parent', 'type', 'price', 'sale_end', 'sale_price', 'sale_schedule', 'sale_start', 'excerpt', 'short_desc', 'featured', 'manage_stock', 'stock_status', 'stock_quantity', 'sold_individually' ) )
										->leftJoinSub(
											'select product_id, avg(rating) as average_rating from product_reviews group by product_id',
											'reviews',
											function ( $join ) {
												$join->on( 'id', '=', 'reviews.product_id' );
											}
										)
										->with( array( 'media:copy_link', 'categories:slug,name' ) )
										->where( 'parent', 0 )
										->orderByDesc( 'average_rating' )
										->take( 3 )
										->get();

		$order_items = OrderItem::selectRaw( 'sum(qty) as amount, product_id' )
									->groupBy( 'product_id' );

		$best_sellings = Product::select( array( 'id', 'name', 'slug', 'parent', 'type', 'price', 'sale_end', 'sale_price', 'sale_schedule', 'sale_start', 'excerpt', 'short_desc', 'featured', 'manage_stock', 'stock_status', 'stock_quantity', 'sold_individually' ) )
									->with( array( 'media:copy_link', 'categories:slug,name' ) )
									->where( 'type', 'simple' )
									->leftJoinSub(
										$order_items,
										'items',
										function ( $join ) {
											$join->on( 'id', '=', 'items.product_id' );
										}
									)
									->orderByDesc( 'items.amount' )
									->limit( 3 )
									->get()->toArray();

		foreach ( $best_sellings as &$best ) {
			if ( ( count( $best['media'] ) == 0 ) && $best['parent'] != 0 ) {
				$best['media'] = Product::with( array( 'media:copy_link', 'categories:slug,name' ) )
										->findOrFail( $best['parent'] )->media;
			}
		}

		$categories = Category::select( array( 'id', 'slug', 'name', 'media_id', 'type' ) )
								->with( 'media:copy_link,id' )
								->where( 'type', 'product' )
								->where( 'media_id', '<>', null )
								->take( 6 )
								->get();

		$posts = Post::select( array( 'id', 'short_desc', 'title', 'created_at', 'slug' ) )
					->withCount( 'comments' )
					->with( array( 'media:copy_link,width,height' ) )
					->has( 'media' )
					->take( 4 )
					->get();

		return array(
			'featuredProducts' => $featured_products,
			'newArrivals'      => $new_arrivals,
			'topRates'         => $top_rates_products,
			'bestSellings'     => $best_sellings,
			'categories'       => $categories,
			'posts'            => $posts,
		);
	}

	/**
	 * Get matched products for live search
	 *
	 * @param \Iluuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function productsSearch( Request $request ) {
		$filter_category     = $request->input( 'category', '*' );
		$products            = Product::with( array( 'media' ) )
							->where( 'parent', 0 )
							->where( 'name', 'LIKE', '%' . $request->input( 'search_term' ) . '%' );
		$category_controller = new CategoryController;

		if ( $filter_category != '*' ) {
			$sub_categories = $category_controller->categorySorted( 'product', $filter_category );
			$sub_categories = $sub_categories->pluck( 'id' );
			$sub_categories->prepend( (int) $filter_category );
			$products = $products->whereHas(
				'categories',
				function ( $query ) use ( $sub_categories ) {
					$query->whereIn( 'category_id', $sub_categories );
				}
			);
		}

		$products = $products->take( 5 )->get();

		return array( 'products' => $products );
	}

	/**
	 * login
	 *
	 * @param \Iluuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function login( Request $request ) {
		$data = $request->validate(
			array(
				'email'    => 'required|string|email|max:255',
				'password' => 'required|string|min:4',
			)
		);

		$user = User::where( 'email', $data['email'] )
					->first();

		if ( $user && Hash::check( $data['password'], $user->password ) ) {
			$user->last_active = date( 'Y-m-d H:i:s' );
			$user->save();
			return $user;
		}

		abort( 500, Lang::get( 'custom.login_error' ) );
	}

	/**
	 * register
	 *
	 * @param \Iluuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function register( Request $request ) {
		$data = $request->validate(
			array(
				'email'    => 'required|string|email|max:255',
				'password' => 'required|string|min:4',
			)
		);
		$user = User::where( 'email', $data['email'] )
					->first();

		if ( $user ) {
			$user->password = Hash::make( $data['password'] );
			$user->sign_up  = date( 'Y-m-d H:i:s' );
			$user->save();
		} else {
			$user = User::create(
				array(
					'email'    => $data['email'],
					'password' => Hash::make( $data['password'] ),
					'sign_up'  => date( 'Y-m-d H:i:s' ),
				)
			);
		}

		return $user;
	}

	/**
	 * Get initial data for shop pages.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getInitialData( Request $request ) {
		$category_controller = new CategoryController;
		$categories          = $category_controller->categorySorted( 'product' );

		$tags = Tag::select( array( 'id', 'slug', 'name' ) )
					->withCount( 'products' )
					->where( 'type', 'product' )
					->orderByDesc( 'products_count' )
					->take( 15 )
					->get();

		return response(
			array(
				'tags'       => $tags,
				'categories' => $categories,
				'settings'   => config( 'setting' ),
			),
			200
		);
	}

	/**
	 * Send Mail for Contact Form
	 *
	 */
	public function sendMail( Request $request ) {
		$admin = User::where( 'role_id', 7 )->first();
		Mail::send(
			array( 'text' => 'mail.contact' ),
			array(
				'content' => $request->input( 'contact_message' ),
				'name'    => $admin->first_name . '  ' . $admin->last_name,
			),
			function( $message ) use ( $admin, $request ) {
				$message->to( $admin->email, $admin->first_name . '  ' . $admin->last_name )->subject( $request->input( 'contact_message' ) );
				$message->from( $request->input( 'contact_email' ), $request->input( 'contact_name' ) );
			}
		);
	}
}
