<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->flashExcept('author');
        $search_term = '%' . $request->input('search-term') . '%';
        $comments = ProductReview::with('product:id,name')->where('content', 'LIKE', $search_term);

        if ($request->has('author')) {
            $comments = $comments->where('author_name', $request->input('author'));
        }

        if ($request->has('product')) {
            $comments = $comments->where('product_id', $request->input('product'));
        }

        $comments = $comments->sortable()->paginate(20);

        return view('admin.comments.product.list', ['comments' => $comments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new ProductReview();
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
        $comment = ProductReview::findOrFail($id);
        return view('admin.comments.product.edit', ['comment' => $comment]);
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
        $comment = ProductReview::findOrFail($id);
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
        ProductReview::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        ProductReview::destroy($request->input('data'));
    }
}
