<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Session;
use File;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;

class InstallerController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function welcome( Request $request ) {
		Session::flush();
		if ( config( 'install.installed' ) ) {
			return redirect( '/' );
		}

		try {
			Artisan::call( 'cache:clear' );
			Artisan::call( 'config:clear' );
			Artisan::call( 'clear-compiled' );
		} catch ( Exception $e ) {
			return view( 'install.welcome' );
		}

		return view( 'install.welcome' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function status( Request $request ) {
		if ( config( 'install.installed' ) ) {
			return redirect( '/' );
		}

		$activated = false;
		if ( Hash::check( 'activated', session( 'activated' ) ) ) {
			$activated = true;
		}

		$activation_key = session( 'activation_key' );

		if ( config( 'setting.activated' ) && config( 'setting.activation_key' ) ) {
			if ( Hash::check( 'activated', config( 'setting.activated' ) ) ) {
				$activated = true;
			}

			$activation_key = config( 'setting.activation_key' );
		}

		return view(
			'install.status',
			array(
				'activated'      => $activated,
				'activation_key' => $activation_key,
			)
		);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function admin( Request $request ) {
		if ( config( 'install.installed' ) ) {
			return redirect( '/installer/welcome' );
		}

		if ( session( 'activation_key' ) && ! Hash::check( 'activated', session( 'activated' ) ) ) {
			return redirect( '/installer/status' );
		}

		return view( 'install.admin' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function database( Request $request ) {
		if ( config( 'install.installed' ) ) {
			return redirect( '/installer/welcome' );
		}

		if ( session( 'activation_key' ) && ! Hash::check( 'activated', session( 'activated' ) ) ) {
			return redirect( '/installer/status' );
		}

		return view( 'install.database' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function demo( Request $request ) {
		if ( config( 'install.installed' ) ) {
			return redirect( '/installer/welcome' );
		}

		if ( session( 'activation_key' ) && ! Hash::check( 'activated', session( 'activated' ) ) ) {
			return redirect( '/installer/status' );
		}

		return view( 'install.demo' );
	}

	/**
	 * Site settings for App Url
	 */
	public function site( Request $request ) {
		return view( 'install.site' );
	}

	/**
	 * Replace compiled files
	 */
	public function changeSite( Request $request ) {
		$server_path = public_path( 'server/js/app.js' );
		$client_path = public_path( 'client/js/app.js' );
		$url         = $request->input( 'app-url' );

		if ( file_exists( $client_path ) ) {
			file_put_contents(
				$client_path,
				str_replace(
					'laravel/porto/' . env( 'DEMO' ),
					$url,
					file_get_contents( $client_path )
				)
			);
		}

		if ( file_exists( $server_path ) ) {
			file_put_contents(
				$server_path,
				str_replace(
					'laravel/porto/' . env( 'DEMO' ),
					$url,
					file_get_contents( $server_path )
				)
			);
		}

		return redirect( '/installer/ready' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function ready( Request $request ) {
		if ( session( 'activation_key' ) && ! Hash::check( 'activated', session( 'activated' ) ) ) {
			return redirect( '/installer/status' );
		}

		if ( ! User::find( 1 ) ) {
			return redirect( '/installer/admin' )
					->withErrors( array( 'admin' => Lang::get( 'custom.database_admin' ) ) );
		}

		try {
			DB::reconnect( config( 'database.default' ) );
			$database = DB::connection()->getDatabaseName();
		} catch ( Exception $e ) {
			return redirect( '/installer/admin' )->withErrors( array( 'database' => Lang::get( 'custom.database_access_denied' ) ) );
		}

		$install = "<?php \n\n return [\n 'installed' => '" . bcrypt( 'installed' ) . "'\n ];\n";
		try {
			file_put_contents( config_path( 'install.php' ), $install );
		} catch ( Exception $e ) {
			return back()->withErrors( array( 'database' => Lang::get( 'custom.database_install' ) ) );
		}

		return view( 'install.ready' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function phpinfo( Request $request ) {
		return view( 'install.phpinfo' );
	}

	/**
	 * Store resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeDatabase( Request $request ) {
		$request->flash();
		$env = file_get_contents( base_path( '.env' ) );
		$env = $this->replaceEnv( $env, $request->input( 'hostname' ), 'DB_HOST' );
		$env = $this->replaceEnv( $env, $request->input( 'port' ), 'DB_PORT' );
		$env = $this->replaceEnv( $env, $request->input( 'db_name' ), 'DB_DATABASE' );
		$env = $this->replaceEnv( $env, $request->input( 'db_user' ), 'DB_USERNAME' );
		$env = $this->replaceEnv( $env, $request->input( 'db_password' ), 'DB_PASSWORD' );
		try {
			file_put_contents( base_path( '.env' ), $env );
		} catch ( Exception $e ) {
			return back()->withErrors( array( 'database' => Lang::get( 'custom.database_install' ) ) );
		}

		try {
			if ( file_exists( base_path( 'bootstrap/cache/config.php' ) ) ) {
				unlink( base_path( 'bootstrap/cache/config.php' ) );
			}
			DB::reconnect( config( 'database.default' ) );
		} catch ( Exception $e ) {
			if ( strpos( $e->getMessage(), 'No such host' ) ) {
				return back()->withErrors( array( 'database' => Lang::get( 'custom.database_host_unknown' ) ) );
			} elseif ( strpos( $e->getMessage(), 'Unknown database' ) ) {
				return back()->withErrors( array( 'database' => Lang::get( 'custom.database_unknown' ) ) );
			} elseif ( strpos( $e->getMessage(), 'No connection could be made' ) ) {
				return back()->withErrors( array( 'database' => Lang::get( 'custom.database_connection' ) ) );
			} elseif ( strpos( $e->getMessage(), 'Access denied for user' ) ) {
				return back()->withErrors( array( 'database' => Lang::get( 'custom.database_user_denied' ) ) );
			}

			return back()->withErrors( array( 'database' => Lang::get( 'custom.database_access_denied' ) ) );
		}

		try {
			Artisan::call( 'migrate:fresh' );
		} catch ( Exception $e ) {
			return back()->withErrors( array( 'database' => Lang::get( 'custom.database_migration' ) ) );
		}

		try {
			Artisan::call( 'db:seed --class=BaseTableSeeder' );
			Artisan::call( 'db:seed --class=SettingsTableSeeder' );
			Artisan::call( 'db:seed --class=PaymentMethodsTableSeeder' );
			Artisan::call( 'db:seed --class=RolesTableSeeder' );
			Artisan::call( 'db:seed --class=TaxTypesTableSeeder' );
		} catch ( Exception $e ) {
			return back()->withErrors( array( 'database' => Lang::get( 'custom.database_seed' ) ) );
		}

		$activation_key = Setting::where( 'meta', 'activation_key' )->first();
		if ( $activation_key ) {
			$activation_key->value = session( 'activation_key' );
			$activation_key->save();
		}

		$activated = Setting::where( 'meta', 'activated' )->first();
		if ( $activated ) {
			$activated->value = session( 'activated' );
			$activated->save();
		}

		return redirect( '/installer/admin' );
	}

	/**
	 * Store resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeAdmin( Request $request ) {
		$request->flash();
		$data = $request->validate(
			array(
				'password' => 'required|confirmed|string|min:4',
			)
		);

		try {
			DB::reconnect( config( 'database.default' ) );
			$database = DB::connection()->getDatabaseName();
		} catch ( Exception $e ) {
			return back()->withErrors( array( 'admin' => Lang::get( 'custom.database_access_denied' ) ) );
		}

		try {
			$user = new User();
			$user->fill( $request->except( 'password' ) );
			$user->role_id  = 7;
			$user->password = bcrypt( $request->input( 'password' ) );
			$user->sign_up  = date( 'Y-m-d' );
			$user->save();
		} catch ( Exception $e ) {
			return back()->withErrors( array( 'admin' => Lang::get( 'custom.database_duplicate_entry' ) ) );
		}

		Artisan::call( 'storage:link' );

		return redirect( '/installer/demo' );
	}

	/**
	 * Store resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeDemo( Request $request ) {
		try {
			Artisan::call( 'db:seed' );
		} catch ( Exception $e ) {
			return back()->withErrors( array( 'demo' => Lang::get( 'custom.database_seed' ) ) );
		}

		return redirect( '/installer/site' );
	}

	/**
	 * Activate project
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	public function activate( Request $request ) {
		session( array( 'activation_key' => $request->input( 'key' ) ) );
		session( array( 'activated' => $request->input( 'activated' ) ) );
	}

	/**
	 * Relace env file with key.
	 *
	 * @param string $env
	 * @param string $key
	 */
	private function replaceEnv( $env, $key, $name ) {
		$start = strpos( $env, $name );
		$end   = strpos( $env, "\n", $start );
		$env   = substr_replace( $env, $name . '=' . $key . "\n", $start, ( $end - $start + 1 ) );
		return $env;
	}
}
