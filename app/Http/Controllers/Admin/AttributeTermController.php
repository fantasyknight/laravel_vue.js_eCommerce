<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeTerm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;

class AttributeTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->flash();
        $search_term = '%' . $request->input('search-term') . '%';
        $terms = AttributeTerm::withCount('product')
                                ->where(function ($query) use ($search_term) {
                                    $query->where('name', 'LIKE', $search_term)
                                            ->orWhere('slug', 'LIKE', $search_term)
                                            ->orWhere('description', 'LIKE', $search_term);
                                })
                                ->where('attribute_id', $request->input('attribute'))
                                ->sortable()
                                ->paginate(20);
        $attribute = Attribute::findOrFail($request->input('attribute'));
        return view('admin.products.attributes.terms.list', ['terms' => $terms, 'attribute' => $attribute]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.attributes.terms.form', ['term' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::slug($name, '-');
        }

        $pattern = $slug . '(-[0-9]+)?$';
        $terms_same_slug = AttributeTerm::where('slug', 'RLIKE', $pattern)->get();
        $count_same_slug = $terms_same_slug->count();

        if ($count_same_slug) {
            if ($terms_same_slug->contains('name', $name)) {
                return back()->withErrors(['slug' => 'already exists']);
            }
            $slug = $slug . '-' . ($count_same_slug + 1);
        }

        $term = AttributeTerm::create([
            'name' => $name,
            'slug' => $slug,
            'attribute_id' => $request->input('attribute_id'),
            'description' => $request->input('description')
        ]);

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $name = $request->input('name');
        $slug = Str::slug($name, '-');

        $pattern = $slug . '(-[0-9]+)?$';
        $terms_same_slug = AttributeTerm::where('slug', 'RLIKE', $pattern)->get();
        $count_same_slug = $terms_same_slug->count();

        if ($count_same_slug) {
            if ($terms_same_slug->contains('name', $name)) {
                return response('same slug', 409);
            }

            $slug = $slug . '-' . ($count_same_slug + 1);
        }

        $term = AttributeTerm::create([
            'name' => $name,
            'slug' => $slug,
            'attribute_id' => $request->input('attribute_id')
        ]);

        return $term;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = AttributeTerm::findOrFail($id);
        return view('admin.products.attributes.terms.form', ['term' => $term]);
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
        $term = AttributeTerm::findOrFail($id);
        
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::slug($name, '-');
        }

        if ($slug != $term->slug) {
            $pattern = $slug . '(-[0-9]+)?$';
            $terms_same_slug = AttributeTerm::where('slug', $pattern)->get();
            $count_same_slug = $terms_same_slug->count();

            if ($count_same_slug) {
                if ($terms_same_slug->contains('name', $name)) {
                    return back()->withErrors(['slug' => 'already exists']);
                }
                $slug = $slug . '-' . ($count_same_slug + 1);
            }
        }

        $term->fill($request->except('slug'));
        $term->slug = $slug;
        $term->save();
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
        AttributeTerm::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        AttributeTerm::destroy($request->input('data'));
    }
}
