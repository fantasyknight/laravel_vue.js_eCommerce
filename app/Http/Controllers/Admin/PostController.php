<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Post;
use App\Models\Category;
use App\Models\Media;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CategoryController;
use Str;

class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request ) {
		$author_id = $request->user()->id;
		$request->flash();

		$dates               = Post::selectRaw( "DATE_FORMAT(created_at, '%M %Y') as month" )->groupBy( 'month' )->get( 'month' );
		$category_controller = new CategoryController();
		$categories          = $category_controller->categorySorted( 'post' );

		$period           = $request->input( 'date', '*' );
		$certain_category = $request->input( 'category' );
		$search_term      = '%' . $request->input( 'search-term' ) . '%';

		$posts = Post::where( 'title', 'LIKE', $search_term )->with( array( 'author', 'categories', 'tags', 'media' ) );
		if ( $author_id != 1 && $request->user()->role_id != 8 ) {
			$posts = Post::where( 'author_id', $author_id )
							->where( 'title', 'LIKE', $search_term )
							->with( array( 'author', 'categories', 'tags', 'media' ) );
		}

		if ( $certain_category ) {
			$sub_categories = $category_controller->categorySorted( 'post', $certain_category );
			$sub_categories = $sub_categories->pluck( 'id' );
			$sub_categories->prepend( (int) $certain_category );

			$posts = $posts->whereHas(
				'categories',
				function ( $query ) use ( $sub_categories ) {
					$query->whereIn( 'category_id', $sub_categories );
				}
			);
		}

		if ( $period !== '*' ) {
			$posts = $posts->whereRaw( "DATE_FORMAT(created_at, '%M %Y') = '" . $period . "'" );
		}

		if ( $request->has( 'tag' ) ) {
			$certain_tag = $request->input( 'tag' );
			$posts       = $posts->whereHas(
				'tags',
				function ( $query ) use ( $certain_tag ) {
					$query->where( 'slug', $certain_tag );
				}
			);
		}

		if ( $request->has( 'author' ) ) {
			$posts = $posts->where( 'author_id', $request->input( 'author' ) );
		}

		$posts = $posts->withCount( 'comments' )->sortable()->paginate( 20 );

		return view(
			'admin.posts.list',
			array(
				'posts'      => $posts,
				'dates'      => $dates,
				'categories' => $categories,
			)
		);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( Request $request ) {
		$author_id           = $request->user()->id;
		$category_controller = new CategoryController();
		$categories          = $category_controller->categoryTree( 'post' );
		$post_tags           = Tag::select( 'id', 'name', 'type' )->where( 'type', 'post' )->get();
		$media               = Media::where( 'type', 'LIKE', 'image%' )
						->orWhere( 'type', 'LIKE', '%stream' )->get();

		if ( $author_id != 1 && $request->user()->role_id != 8 ) {
			$media = Media::where( 'author_id', $author_id )
							->where( 'type', 'LIKE', 'image%' )
							->orWhere( 'type', 'LIKE', '%stream' )->get();
		}

		return view(
			'admin.posts.create',
			array(
				'post'       => null,
				'categories' => $categories,
				'post_tags'  => $post_tags,
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
		$post = new Post();

		$post->fill( $request->except( 'categories', 'tags' ) );
		$post->author_id = $request->user()->id;

		$slug = Str::slug( $post->title, '-' );

		if ( Post::where( 'slug', $slug )->first() ) {
			$slug_index = 1;
			while ( Post::where( 'slug', $slug . '-' . $slug_index )->first() ) {
				$slug_index ++;
			}
		} else {
			$post->slug = $slug;
		}

		$post->save();

		// Post Images
		if ( $request->filled( 'media_ids' ) ) {
			$post->media()->attach( explode( ',', $request->input( 'media_ids' ) ) );
		}

		// Post Categories
		if ( $request->filled( 'categories' ) ) {
			$post->categories()->attach( explode( ',', $request->input( 'categories' ) ) );
		} else {
			$post->categories()->attach( 2 );
		}

		// Post Tags
		if ( $request->filled( 'tags' ) ) {
			$tag_names = explode( ',', $request->input( 'tags' ) );
			foreach ( $tag_names as $tag_name ) {
				$tag = Tag::where( 'type', 'post' )->where( 'name', $tag_name )->first();
				if ( ! $tag ) {
					$tag       = new Tag();
					$tag->name = $tag_name;
					$slug      = Str::slug( $tag_name, '-' );

					$pattern         = $slug . '(-[0-9]+)?$';
					$tags_same_slug  = Tag::where( 'type', 'post' )->where( 'slug', 'RLIKE', $pattern )->get();
					$count_same_slug = $tags_same_slug->count();

					if ( $count_same_slug ) {
						if ( $tags_same_slug->contains( 'name', $name ) ) {
							return back()->withErrors( array( 'slug' => 'already exists' ) );
						}
						$slug = $slug . '-' . ( $count_same_slug + 1 );
					}

					$tag->slug = $slug;
					$tag->type = 'post';
					$tag->save();
				}
				$post->tags()->attach( $tag->id );
			}
		}

		return redirect( '/admin/posts/' . $post->id . '/edit' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Request $request, $id ) {
		$author_id = $request->user()->id;
		$post      = Post::findOrFail( $id );

		if ( Gate::denies( 'manage-resource', $post ) ) {
			abort( 403 );
		}

		$media = Media::where( 'type', 'LIKE', 'image%' )
						->orWhere( 'type', 'LIKE', '%stream' )->get();
		if ( $author_id != 1 && $request->user()->role_id != 8 ) {
			$media = Media::where( 'author_id', $author_id )
							->where( 'type', 'LIKE', 'image%' )
							->orWhere( 'type', 'LIKE', '%stream' )->get();
		}
		$category_controller = new CategoryController();
		$categories          = $category_controller->categoryTree( 'post' );
		$post_tags           = Tag::select( 'id', 'name', 'type' )->where( 'type', 'post' )->get();
		$current_categories  = collect( array() );
		foreach ( $post->categories as $category ) {
			$current_categories->push( $category->id );
		}
		$used_tag_names = $post->tags->implode( 'name', ',' );
		return view(
			'admin.posts.edit',
			array(
				'post'               => $post,
				'categories'         => $categories,
				'post_tags'          => $post_tags,
				'current_categories' => $current_categories,
				'used_tag_names'     => $used_tag_names,
				'media'              => $media,
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
		$post = Post::findOrFail( $id );
		if ( Gate::denies( 'manage-resource', $post ) ) {
			abort( 403 );
		}

		$post->fill( $request->except( 'categories', 'tags' ) );

		// Post Images
		if ( $request->filled( 'media_ids' ) ) {
			$post->media()->sync( explode( ',', $request->input( 'media_ids' ) ) );
		}

		// Post Categories
		if ( $request->filled( 'categories' ) ) {
			$post->categories()->sync( explode( ',', $request->input( 'categories' ) ) );
		} else {
			$post->categories()->sync( 2 );
		}

		// Post Tags
		if ( $request->filled( 'tags' ) ) {
			$tag_names = explode( ',', $request->input( 'tags' ) );
			$tag_ids   = collect( array() );
			foreach ( $tag_names as $tag_name ) {
				$tag = Tag::where( 'type', 'post' )->where( 'name', $tag_name )->first();
				if ( ! $tag ) {
					$tag       = new Tag();
					$tag->name = $tag_name;
					$slug      = Str::slug( $tag_name, '-' );

					$pattern         = $slug . '(-[0-9]+)?$';
					$tags_same_slug  = Tag::where( 'type', 'post' )->where( 'slug', 'RLIKE', $pattern )->get();
					$count_same_slug = $tags_same_slug->count();

					if ( $count_same_slug ) {
						if ( $tags_same_slug->contains( 'name', $name ) ) {
							return back()->withErrors( array( 'slug' => 'already exists' ) );
						}
						$slug = $slug . '-' . ( $count_same_slug + 1 );
					}

					$tag->slug = $slug;
					$tag->type = 'post';
					$tag->save();
				}
				$tag_ids->push( $tag->id );
			}
			$post->tags()->sync( $tag_ids );
		}

		$post->save();

		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$post = Post::findOrFail( $id );
		if ( Gate::denies( 'manage-resource', $post ) ) {
			abort( 403 );
		}

		$post->delete();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function bulkDestroy( Request $request ) {
		Post::destroy( $request->input( 'data' ) );
	}
}
