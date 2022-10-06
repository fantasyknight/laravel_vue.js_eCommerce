<?php

namespace App\Http\Controllers\Admin;

use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->flashExcept('author');
        $search_term = '%' . $request->input('search-term') . '%';
        $comments = PostComment::with('post:id,title')->where('content', 'LIKE', $search_term);

        if ($request->has('author')) {
            $comments = $comments->where('author_name', $request->input('author'));
        }

        if ($request->has('post')) {
            $comments = $comments->where('post_id', $request->input('post'));
        }

        $comments = $comments->sortable()->paginate(20);

        return view('admin.comments.post.list', ['comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new PostComment();
        $comment->fill($request->all());
        $comment->approved = true;
        $comment->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = PostComment::findOrFail($id);
        return view('admin.comments.post.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = PostComment::findOrFail($id);
        $comment->fill($request->except('approved'));
        $comment->approved = intval($request->input('approved'));
        $comment->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PostComment::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        PostComment::destroy($request->input('data'));
    }

    /**
     * Get commet tree of specific post in json format
     * 
     * @param \App\Models\PostComment $commen
     * @return JSON
     */
    public static function getCommentTreeForVue($post_id) {
        $aproved_comments = PostComment::where('post_id', $post_id)->where('approved', true)->get();
        $approved_comment_ids = $approved_comment->pluck('id');
        $stack = collect([$approved_comment_ids]);
        $tree = collect([]);
        while($stack->isNotEmpty()) {
        }
    }
}
