<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\User;
use App\Models\Role;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request ) {
		$request->flash();
		$search_term = '%' . $request->input( 'search-term' ) . '%';
		$filter_by   = $request->input( 'filter-by', '*' );

		$users = User::where( 'sign_up', '<>', null )
					->where(
						function ( $query ) use ( $search_term ) {
							$query->where( 'first_name', 'LIKE', $search_term )
							->orWhere( 'last_name', 'LIKE', $search_term )
							->orWhere( 'email', 'LIKE', $search_term );
						}
					);
		if ( $filter_by != '*' ) {
			$users = $users->where( 'role_id', $filter_by );
		}

		$users = $users->with( 'role' )
						->withCount( 'posts' )
						->sortable()
						->paginate( 20 );
		return view( 'admin.users.list', array( 'users' => $users ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$roles = Role::all();
		return view( 'admin.users.create', array( 'roles' => $roles ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$validated = $request->validate(
			array(
				'email'    => 'email|unique:users',
				'password' => 'bail|confirmed',
			)
		);

		$user = new User();
		$user->fill( $request->except( 'password' ) );
		if ( $request->filled( 'password' ) ) {
			$user->password = bcrypt( $request->input( 'password' ) );
		}
		$user->sign_up = date( 'Y-m-d H:i:s' );
		$user->save();

		if ( config( 'setting.multivendor' ) == '1' && $request->input( 'role_id' ) == 4 ) {
			Vendor::create(
				array(
					'user_id' => $user->id,
				)
			);
		}

		return redirect( '/admin/users/' . $user->id . '/edit' );
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
		$user        = User::findOrFail( $id );
		$roles       = Role::all();
		$active_user = Auth::user();

		if ( $active_user->role_id == 4 ) {
			if ( $user->id != $active_user->id ) {
				abort( 403 );
			}
		} else {
			$user->is_seen = true;
			$user->save();
		}

		return view(
			'admin.users.edit',
			array(
				'user'  => $user,
				'roles' => $roles,
			)
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
		$user        = User::findOrFail( $id );
		$active_user = Auth::user();
		if ( $active_user->role_id == 4 && $active_user->id != $user->id ) {
			abort( 403 );
		}

		$validated = $request->validate(
			array(
				'email'    => 'nullable|email|unique:users',
				'password' => 'nullable|bail|confirmed',
			)
		);

		if ( $request->email && $request->email !== $user->email ) {
			Order::where( 'customer_email', $user->email )->update( array( 'customer_email' => $request->email ) );
		}

		$vendor = Vendor::where( 'user_id', $user->id )->first();
		if ( $request->input( 'role_id' ) == 4 ) {
			if ( ! isset( $vendor ) ) {
				Vendor::create(
					array(
						'user_id' => $user->id,
					)
				);
			}
		} else {
			if ( isset( $vendor ) ) {
				$vendor->delete();
			}
		}

		$user->fill( $request->except( 'password' ) );
		if ( $request->filled( 'password' ) ) {
			$user->password = bcrypt( $request->input( 'password' ) );
		}

		if ( $active_user->role_id == 4 ) {
			$user->role_id = 4;
		}

		$user->save();

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		User::destroy( $id );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulkDestroy( Request $request ) {
		User::destroy( $request->input( 'data' ) );
	}

	/**
	 * User log out
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout() {
		Auth::logout();
		Session::flush();
		return redirect( '/' );
	}

	/**
	 * User post Logout
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postLogout() {
		Auth::logout();
		Session::flush();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function customers( Request $request ) {
		$search_term = '%' . $request->input( 'search-term' ) . '%';
		$customers   = User::leftJoinSub(
			Order::selectRaw( 'customer_email, count(id) as orders_count, sum(order_total_price) as total_spend, avg(order_total_price) as aov' )
										->groupBy( array( 'customer_email' ) ),
			'orders',
			'email',
			'=',
			'customer_email'
		)
							->where( 'role_id', '2' )
							->sortable()
							->paginate( 24 );
		return view( 'admin.ecommerce.customers.list', array( 'customers' => $customers ) );
	}

	/**
	 * Get new customers
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getNewCustomers() {
		$new_customers = User::where( 'role_id', '2' )->where( 'sign_up', '<>', null )->where( 'is_seen', '0' );

		return response(
			array(
				'count'     => $new_customers->count(),
				'customers' => $new_customers->take( 3 )->get( array( 'id', 'first_name', 'last_name' ) ),
			),
			200
		);
	}
}
