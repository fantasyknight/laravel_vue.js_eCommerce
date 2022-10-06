<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Iluuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $request->flash();
        $search_term = '%' . $request->input('search-term') . '%';
        $tags = Tag::where('type', $type)
                ->where(function ($query) use ($search_term) {
                    $query->where('name', 'LIKE', $search_term)
                    ->orWhere('slug', 'LIKE', $search_term)
                    ->orWhere('description', 'LIKE', $search_term);
                })->withCount($type . 's')
                ->sortable()
                ->paginate(20);

        return view('admin.tags.list', ['tags' => $tags, 'type' => $type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        return view('admin.tags.edit', ['tag' => null, 'type' => $type]);
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
        $type = $request->input('type');

        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::slug($name, '-');
        }

        $pattern = $slug . '(-[0-9]+)?$';
        $tags_same_slug = Tag::where('type', $type)->where('slug', 'RLIKE', $pattern)->get();
        $count_same_slug = $tags_same_slug->count();

        if ($count_same_slug) {
            if ($tags_same_slug->contains('name', $name)) {
                return back()->withErrors(['slug' => 'already exists']);
            }
            $slug = $slug . '-' . ($count_same_slug + 1);
        }

        $tag = Tag::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $request->input('description'),
            'type' => $type
        ]);

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
        $tag = Tag::findOrFail($id);
        return view('admin.tags.edit', ['tag' => $tag, 'type' => $tag->type]);
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
        //
        $tag = Tag::findOrFail($id);
        
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = str_slug($name, '-');
        }

        if ($slug != $tag->slug) {
            $pattern = $slug . '(-[0-9]+)?$';
            $tags_same_slug = Tag::where('type', $tag->type)->where('slug', 'RLIKE', $pattern)->get();
            $count_same_slug = $tags_same_slug->count();

            if ($count_same_slug) {
                if ($tags_same_slug->contains('name', $name)) {
                    return back()->withErrors(['slug' => 'already exists']);
                }
                $slug = $slug . '-' . ($count_same_slug + 1);
            }
        }
        $tag->fill($request->except(['type', 'slug']));
        $tag->slug = $slug;
        $tag->save();
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
        Tag::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        Tag::destroy($request->input('data'));
    }
}
