<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::with('terms')->get();
        return view('admin.products.attributes.list', ['attributes' => $attributes]);
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
        $name = $request->input('name');
        
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::slug($name, '-');
        }
        
        $pattern = $slug . '(-[0-9]+)?$';
        $attrs_same_slug = Attribute::where('slug', 'RLIKE', $pattern)->get();
        $count_same_slug = $attrs_same_slug->count();

        if ($count_same_slug) {
            if ($attrs_same_slug->contains('name', $name)) {
                return back()->withErrors(['slug' => 'already exists']);
            }
            $slug = $slug . '-' . ($count_same_slug + 1);
        }

        $attribute = new Attribute();
        $attribute->fill($request->except('slug'));
        $attribute->slug = $slug;
        $attribute->save();
        return back();
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
        $attribute = Attribute::findOrFail($id);
        return view('admin.products.attributes.edit', ['attribute' => $attribute]);
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
        $attribute = Attribute::findOrFail($id);
        $name = $request->input('name');

        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::slug($name, '-');
        }
        
        if ($slug != $attribute->slug) {
            $pattern = $slug . '(-[0-9]+)?$';
            $attrs_same_slug = Attribute::where('slug', 'RLIKE', $pattern)->get();
            $count_same_slug = $attrs_same_slug->count();

            if ($count_same_slug) {
                if ($attrs_same_slug->contains('name', $name)) {
                    return back()->withErrors(['slug' => 'already exists']);
                }
                $slug = $slug . '-' . ($count_same_slug + 1);
            }
        }
        $attribute->fill($request->except('slug'));
        $attribute->slug = $slug;
        $attribute->save();
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
        Attribute::destroy([$id]);
    }
}
