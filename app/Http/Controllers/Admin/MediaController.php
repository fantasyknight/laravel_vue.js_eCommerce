<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Image;
use Gate;
use App\Models\Media;
use App\Models\Setting;

class MediaController extends Controller {

	/**
	 * Display a listing of the media.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  string $type
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request, $type ) {
		$filter_by = $request->input( 'filter-by', '*' );
		$request->flash();
		$author_id = $request->user()->id;

		if ( $request->user()->role_id == 7 || $request->user()->role_id == 8 ) {
			if ( $request->filled( 'search-term' ) ) {
				$search_term = '%' . $request->input( 'search-term' ) . '%';

				if ( $filter_by == '*' ) {
					$media = Media::where( 'name', 'LIKE', $search_term )
									->orWhere( 'alt_text', 'LIKE', $search_term )
									->orWhere( 'description', 'LIKE', $search_term )
									->sortable()
									->paginate( 24 );
				} else {
					$media = Media::where( 'name', 'LIKE', $search_term )
									->orWhere( 'alt_text', 'LIKE', $search_term )
									->orWhere( 'description', 'LIKE', $search_term )
									->where( 'type', 'LIKE', '%' . $filter_by . '%' )
									->sortable()
									->paginate( 24 );
				}
			} else {
				if ( $filter_by == '*' ) {
					$media = Media::sortable()
									->paginate( 24 );
				} else {
					$media = Media::where( 'type', 'LIKE', '%' . $filter_by . '%' )
									->sortable()
									->paginate( 24 );
				}
			}
		} else {
			if ( $request->filled( 'search-term' ) ) {
				$search_term = '%' . $request->input( 'search-term' ) . '%';

				if ( $filter_by == '*' ) {
					$media = Media::where( 'author_id', $author_id )
									->where(
										function ( $query ) use ( $search_term ) {
											$query->where( 'name', 'LIKE', $search_term )
												->orWhere( 'alt_text', 'LIKE', $search_term )
												->orWhere( 'description', 'LIKE', $search_term );
										}
									)
									->sortable()
									->paginate( 24 );
				} else {
					$media = Media::where( 'author_id', $author_id )
									->where(
										function ( $query ) use ( $search_term ) {
											$query->where( 'name', 'LIKE', $search_term )
											->orWhere( 'alt_text', 'LIKE', $search_term )
											->orWhere( 'description', 'LIKE', $search_term );
										}
									)
									->where( 'type', 'LIKE', '%' . $filter_by . '%' )
									->sortable()
									->paginate( 24 );
				}
			} else {
				if ( $filter_by == '*' ) {
					$media = Media::where( 'author_id', $author_id )
									->sortable()
									->paginate( 24 );
				} else {
					$media = Media::where( 'author_id', $author_id )
									->where( 'type', 'LIKE', '%' . $filter_by . '%' )
									->sortable()
									->paginate( 24 );
				}
			}
		}

		if ( $type == 'grid' ) {
			return view( 'admin.media.grid', array( 'media' => $media ) );
		} elseif ( $type == 'list' ) {
			return view( 'admin.media.list', array( 'media' => $media ) );
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'admin.media.create' );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showSetting() {
		return view( 'admin.media.setting' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$author_id = $request->user()->id;
		$file_temp = $request->file( 'file' );
		$extension = $file_temp->getClientOriginalExtension();
		$name      = $file_temp->getClientOriginalName();
		$directory = 'public/' . idate( 'Y' ) . '/' . idate( 'm' ) . '/';
		$only_name = substr( $name, 0, strpos( $name, '.' ) );
		$index     = 1;

		if ( Storage::exists( idate( 'Y' ) . '/' . idate( 'm' ) . '/' . $name ) ) {
			while ( Storage::exists( idate( 'Y' ) . '/' . idate( 'm' ) . '/' . $only_name . '-' . $index . '.' . $extension ) ) {
				$index ++;
			}

			$file_temp->storeAs( idate( 'Y' ) . '/' . idate( 'm' ) . '/', $only_name . '-' . $index . '.' . $extension );
		} else {
			$file_temp->storeAs( idate( 'Y' ) . '/' . idate( 'm' ) . '/', $name );
			$index --;
		}

		// make images of size 100, 150, 300, 600px
		if ( in_array( $extension, array( 'gif', 'jpg', 'jpeg', 'png', 'GIF', 'JPG', 'JPEG', 'PNG' ) ) ) {
			if ( $index == 0 ) {
				$ori_image = $only_name;
			} else {
				$ori_image = $only_name . '-' . $index;
			}

			$uploaded_image = Image::make( storage_path( 'app/' ) . $directory . $ori_image . '.' . $extension );

			Image::make( storage_path( 'app/' ) . $directory . $ori_image . '.' . $extension )->resize(
				100,
				100,
				function ( $constraint ) {
					$constraint->aspectRatio();
				}
			)->save( storage_path( 'app/' ) . $directory . $ori_image . '-100x100.' . $extension );

			Image::make( storage_path( 'app/' ) . $directory . $ori_image . '.' . $extension )->resize(
				150,
				150,
				function ( $constraint ) {
					$constraint->aspectRatio();
				}
			)->save( storage_path( 'app/' ) . $directory . $ori_image . '-150x150.' . $extension );

			Image::make( storage_path( 'app/' ) . $directory . $ori_image . '.' . $extension )->resize(
				300,
				300,
				function ( $constraint ) {
					$constraint->aspectRatio();
				}
			)->save( storage_path( 'app/' ) . $directory . $ori_image . '-300x300.' . $extension );

			Image::make( storage_path( 'app/' ) . $directory . $ori_image . '.' . $extension )->resize(
				600,
				600,
				function ( $constraint ) {
					$constraint->aspectRatio();
				}
			)->save( storage_path( 'app/' ) . $directory . $ori_image . '-600x600.' . $extension );

			$new_media = Media::create(
				array(
					'name'        => $index == 0 ? $only_name : $only_name . '-' . $index,
					'type'        => $file_temp->getClientMimeType(),
					'size'        => $file_temp->getSize(),
					'width'       => $uploaded_image->getWidth(),
					'height'      => $uploaded_image->getHeight(),
					'uploaded_by' => $request->user()->first_name . ' ' . $request->user()->last_name,
					'copy_link'   => $index == 0 ? idate( 'Y' ) . '/' . idate( 'm' ) . '/' . $name : idate( 'Y' ) . '/' . idate( 'm' ) . '/' . $only_name . '-' . $index . '.' . $extension,
					'author_id'   => $author_id,
				)
			);

			return $new_media->toJson();
		} else {
			$new_media = Media::create(
				array(
					'name'        => $index == 0 ? $only_name : $only_name . '-' . $index,
					'type'        => $file_temp->getClientMimeType(),
					'size'        => $file_temp->getSize(),
					'uploaded_by' => $request->user()->first_name . ' ' . $request->user()->last_name,
					'copy_link'   => $index == 0 ? idate( 'Y' ) . '/' . idate( 'm' ) . '/' . $name : idate( 'Y' ) . '/' . idate( 'm' ) . '/' . $only_name . '-' . $index . '.' . $extension,
					'author_id'   => $author_id,
				)
			);

			return $new_media->toJson();
		}
	}

	/**
	 * Show the form for edit media page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$media = Media::findOrFail( $id );
		if ( Gate::denies( 'manage-resource', $media ) ) {
			abort( 403 );
		}

		return view( 'admin.media.edit', array( 'media' => $media ) );
	}

	/**
	 * Update the specified media in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		$media = Media::findOrFail( $id );

		if ( Gate::allows( 'manage-resource', $media ) ) {
			$media->name        = $request->name;
			$media->alt_text    = $request->alt_text;
			$media->description = $request->description;
			$media->save();
		}

		return back();
	}

	/**
	 * Remove the specified media from storage.
	 * Remove all related images.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$media = Media::find( $id );

		if ( Gate::allows( 'manage-resource', $media ) ) {
			$extension = substr( $media->copy_link, strpos( $media->copy_link, '.' ) + 1 );

			if ( in_array( $extension, array( 'gif', 'jpg', 'jpeg', 'png' ) ) ) {
				$path = 'public/' . substr( $media->copy_link, 0, strpos( $media->copy_link, '.' ) );

				Storage::delete(
					array(
						$media->copy_link,
						$path . '-100x100' . '.' . $extension,
						$path . '-150x150' . '.' . $extension,
						$path . '-300x300' . '.' . $extension,
						$path . '-600x600' . '.' . $extension,
					)
				);
			}

			$media->delete();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulkDestroy( Request $request ) {
		$media = Media::find( $request->data );

		foreach ( $media as $medium ) {
			$extension = substr( $medium->copy_link, strpos( $medium->copy_link, '.' ) + 1 );

			if ( in_array( $extension, array( 'gif', 'jpg', 'jpeg', 'png' ) ) ) {
				$path = 'public/' . substr( $medium->copy_link, 0, strpos( $medium->copy_link, '.' ) );
				Storage::delete(
					array(
						$path . $extension,
						$path . '-100x100' . '.' . $extension,
						$path . '-150x150' . '.' . $extension,
						$path . '-300x300' . '.' . $extension,
						$path . '-600x600' . '.' . $extension,
					)
				);
			}

			$medium->delete();
		}
	}

	/**
	 * Media setting function. By using this setting, we can slice media in different size and use.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function setting( Request $request ) {
		Setting::where( 'meta', 'media_small_thumbnail_width' )
				->update( array( 'value' => $request->input( 'media_small_thumbnail_width' ) ) );

		Setting::where( 'meta', 'media_small_thumbnail_height' )
				->update( array( 'value' => $request->input( 'media_small_thumbnail_height' ) ) );

		Setting::where( 'meta', 'media_medium_thumbnail_width' )
				->update( array( 'value' => $request->input( 'media_medium_thumbnail_width' ) ) );

		Setting::where( 'meta', 'media_medium_thumbnail_height' )
				->update( array( 'value' => $request->input( 'media_small_thumbnail_height' ) ) );

		Setting::where( 'meta', 'media_large_thumbnail_width' )
				->update( array( 'value' => $request->input( 'media_large_thumbnail_width' ) ) );

		Setting::where( 'meta', 'media_large_thumbnail_height' )
				->update( array( 'value' => $request->input( 'media_large_thumbnail_height' ) ) );

		return back()->withInput();
	}

	/**
	 * Media setting function. By using this setting, we can slice media in different size and use.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function fetch( Request $request ) {
		return response(
			array(
				'data' => Media::get( array( 'copy_link', 'id', 'type' ) ),
			)
		);
	}
}
