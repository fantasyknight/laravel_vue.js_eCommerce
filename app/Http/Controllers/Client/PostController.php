<?php

namespace App\Http\Controllers\client;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CategoryController;

class PostController extends Controller
{
    /**
     * Get posts
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPosts(Request $request) {
        $per_page = $request->input('per_page', 6);

        $posts = Post::select(['id', 'title', 'slug', 'short_desc', 'created_at'])
                        ->where('enabled', true)
                        ->with(['media:copy_link,width,height'])
                        ->withCount(['comments' => function ($query) {
                            $query->where('approved', true);
                        }])
                        ->latest();
        
        if($request->has('category')) {
            $certain_category = Category::where('type', 'post')->where('slug', $request->input('category'))->first()->id;
            $category_controller = new CategoryController();
            $sub_categories = $category_controller->categorySorted('post', $certain_category);
            $sub_categories = $sub_categories->pluck('id');
            $sub_categories->prepend((int)$certain_category);
            
            $posts = $posts->whereHas('categories', function ($query) use ($sub_categories) {
                $query->whereIn('category_id', $sub_categories);
            });
        }
        
        if($request->has('tag')) {
            $certain_tag = $request->input('tag');
            $posts = $posts->whereHas('tags', function ($query) use ($certain_tag) {
                $query->where('slug', $certain_tag);
            });
        }

        if($request->has('author')) {
            $certain_author = $request->input('author');
            $posts = $posts->whereHas('author', function ($query) use ($certain_author) {
                $query->where('id', $certain_author);
            });
        }

        $posts_count = $posts->count();
        $posts = $posts->paginate($per_page)->items();

        return response([
            'postsCount' => $posts_count,
            'posts' => $posts
        ], 200);
    }

    /**
     * Get single post
     * 
     * @param Number $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPost($slug, Request $request) {
        $author = $request->input('author');
        $post = Post::with([
                            'media:copy_link,width,height', 
                            'author:id,first_name,last_name,description', 
                            'categories', 
                            'tags',
                            'comments' => function ($query) use ($author) {
                                $query->where('approved', true)->orWhere('author_email', $author);
                            }
                        ])
                        ->withCount(['comments' => function ($query) {
                            $query->where('approved', true);
                        }])
                        ->where('enabled', true)
                        ->where('slug', $slug)
                        ->first();

        if(empty($post)) {
            abort(500, 'MODEL_NOT_FOUND');
        }

        $categories = $post->categories->where('id', '!=', 2)->pluck('id');
            
        $related_posts = Post::with('media:copy_link,width,height')
                                ->where('id', '!=', $post->id)
                                ->whereHas('categories', function ($query) use ($categories) {
                                    $query->whereIn('category_id', $categories);
                                })
                                ->latest()
                                ->take(5)
                                ->get();
        return response([
            'post' => $post,
            'relatedPosts' => $related_posts
        ], 200);
    }

    /**
     * Get sidebar data
     * 
     * @return \Illuminate\Http\Response
     */
    public function getSidebar() { 
        $category_controller = new CategoryController();
        $categories = $category_controller->categoryTreeForVue('post');
        $tags = Tag::where('type', 'post')->whereHas('posts')->get();
        $recent_posts = Post::where('enabled', true)
                                ->with('media')
                                ->orderByDesc('created_at')
                                ->latest()
                                ->take(2)
                                ->get();
        return response([
            'categories' => $categories,
            'tags' => $tags,
            'recentPosts' => $recent_posts
        ]);
    }

    /**
     * Get posts
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postComment(Request $request) {
        $request->validate([
            'content' => 'max:1000'
        ]);
        $comment = new PostComment();
        $comment->fill($request->all());
        if (User::where('email', $request->input('author_email'))->where('role_id', '!=', 2)->exists()) {
            $comment->approved = true;
        } else {
            $comment->approved = false;
        }
        $comment->save();
        return response([
            'comment' => $comment
        ], 200);
    }
}
