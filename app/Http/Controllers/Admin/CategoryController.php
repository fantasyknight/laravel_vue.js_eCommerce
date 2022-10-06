<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use Str;
use Arr;

class CategoryController extends Controller
{
    private $sorted; // variable which holds data in tree structure
    private $categories; // variable which contains models
    private $prefix; // separator to distinguish depth

    /**
     * Display a listing of the resource.
     *
     * @param $type
     * @param \Iluuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
        $request->flash();

        $order_by = $request->input('order-by');
        $direction = $request->input('direction');

        $this->categories = Category::where('type', $type)
                                    ->orderBy('parent')
                                    ->orderBy('name')
                                    ->get();
        $this->sorted = collect([]);
        $this->constructTree(0, 0);
        $parent_categories = $this->sorted;

        if ($request->anyFilled('search-term', 'sort')) {
            $search_term = '%' . $request->input('search-term') . '%';
            $categories = Category::where('type', $type)
                                    ->where(function ($query) use ($search_term) {
                                        $query->where('name', 'LIKE', $search_term)
                                                ->orWhere('slug', 'LIKE', $search_term)
                                                ->orWhere('description', 'LIKE', $search_term);
                                    });
            if ($request->input('sort') === 'count') {
                $page = $request->input('page', 1);
                $categories = $categories->get()->sortBy('count', SORT_REGULAR, $request->input('direction') === 'desc');
                $categories = new LengthAwarePaginator($categories->forPage($page, 20), $categories->count(), 20, $page, [
                    'path' => Paginator::resolveCurrentPath()
                ]);
            } else {
                $categories = $categories->sortable()->paginate(20);
            }
        } else {
            $this->categories = Category::where('type', $type)->get();
            $this->sorted = Category::where('type', $type)->where('parent', '<', 0)->get();
            $this->prefix = '--';
            $this->constructTree(0, 0);
            $page = $request->input('page', 1);
            $categories = new LengthAwarePaginator($this->sorted->forPage($page, 20), $this->sorted->count(), 20, $page, [
                'path' => Paginator::resolveCurrentPath()
            ]);
        }

        $media = Media::where('type', 'LIKE', 'image%');
        $user = $request->user();
        if ($user->role_id == 4) {
            $media = $media->where('author_id', $user->id);
        }

        $media = $media->get();

        return view('admin.categories.list', [
            'categories' => $categories,
            'type' => $type,
            'parent_categories' => $parent_categories,
            'media' => $media
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $type
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $this->categories = Category::select('id', 'name', 'parent')
                                    ->where('type', $type)
                                    ->orderBy('parent')
                                    ->orderBy('name')
                                    ->get();
        $this->sorted = collect([]);
        $this->constructTree(0, 0);

        $media = Media::where('type', 'LIKE', 'image%')->get();
        return view('admin.categories.edit', [
            'category' => null,
            'type' => $type,
            'categories' => $this->sorted,
            'media' => $media
        ]);
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
        $cats_same_slug = Category::where('type', $type)->where('slug', 'RLIKE', $pattern)->get();
        $count_same_slug = $cats_same_slug->count();

        if ($count_same_slug) {
            if ($cats_same_slug->contains('name', $name)) {
                return back()->withErrors(['slug' => 'already exists']);
            }
            $slug = $slug . '-' . ($count_same_slug + 1);
        }

        $category = Category::create([
            'name' => $name,
            'slug' => $slug,
            'parent' => $request->input('parent'),
            'description' => $request->input('description'),
            'media_id' => $request->input('media_id'),
            'icon' => $request->input('icon'),
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
        $category = Category::findOrFail($id);
        $this->categories = Category::select('id', 'name', 'parent')
                            ->where('type', $category->type)
                            ->where('id', '!=', $id)
                            ->orderBy('parent')
                            ->orderBy('name')->get();
        $this->sorted = collect([]);
        $this->constructTree(0, 0);
        $media = Media::where('type', 'LIKE', 'image%')->get();
        return view('admin.categories.edit', [
            'category' => $category, 
            'type' => $category->type, 
            'categories' => $this->sorted, 
            'media' => $media
        ]);
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
        $category = Category::findOrFail($id);
        
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::slug($name, '-');
        }

        if ($slug != $category->slug) {
            $pattern = $slug . '(-[0-9]+)?$';
            $cats_same_slug = Category::where('type', $category->type)->where('slug', $slug)->get();
            $count_same_slug = $cats_same_slug->count();
    
            if ($count_same_slug) {
                if ($cats_same_slug->contains('name', $name)) {
                    return back()->withErrors(['slug' => 'already exists']);
                }
                $slug = $slug . '-' . ($count_same_slug + 1);
            }
        }
        $category->fill($request->except(['type', 'slug']));
        $category->slug = $slug;
        $category->save();
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
        //
        $category = Category::findOrFail($id);
        Category::where('parent', $id)->update(['parent' => $category->parent]);
        Category::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        //
        $ids_to_remove = $request->input('data');
        $count = count($ids_to_remove);
        for ($i = 0; $i < $count; $i++) {
            $this->destroy($ids_to_remove[$i]);
        }
    }

    /**
     * Return category tree in JSON format
     */
    public function categoryTree($type) {
        $this->categories = Category::select('id', 'name', 'parent')
                                    ->where('type', $type)
                                    ->orderBy('parent')
                                    ->orderBy('name')
                                    ->get();
        $sorted_json = array(
            'id' => 0,
            'text' => 'None',
            'children' => array()
        );

        $this->constructTreeForJSON($sorted_json);

        $uncategorized = array(
            'id' => $type == 'product' ? 1 : 2,
            'text' => 'Uncategorized',
            'state' => array(
                            'checked' => 'true',
                            'disabled' => 'true',
                        )
        );

        if (count($sorted_json['children']) == 0) {
            return json_encode(Arr::prepend($sorted_json['children'], $uncategorized));
        }

        return json_encode($sorted_json['children']);
    }

    /**
     * Return category tree in JSON format
     */
    public function categoryTreeForVue($type) {
        $this->categories = Category::where('type', $type)
                                    ->orderBy('parent')
                                    ->orderBy('name')
                                    ->get();
        $sorted_json = array(
            'id' => 0,
            'name' => 'None',
            'slug' => 'None',
            'children' => array()
        );

        $this->constructTreeForVue($sorted_json);

        $uncategorized = array(
            'id' => $type === 'product' ? 1 : 2,
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'count' => $this->categories->firstWhere('id', $type === 'product' ? 1 : 2)->count,
            'disabled' => true
        );
        return Arr::prepend($sorted_json['children'], $uncategorized);
    }

    /**
     * Return sorted category list
     */
    public function categorySorted($type, $root = 0, $prefix = '- ')
    {
        $this->categories = Category::select('id', 'name', 'slug', 'parent', 'icon')
                                    ->where('type', $type)
                                    ->orderBy('parent')
                                    ->orderBy('name')
                                    ->get();
        $this->sorted = collect([]);
        $this->prefix = $prefix;
        if ($root) {
            $this->sorted->push($this->categories->where('id', $root)->first());
        }
        $this->constructTree($root, 0);
        return $this->sorted;
    }

    /**
     * Get all parent categories for a cetain category
     *
     * @param  int  $caretory_id
     * @return array $parent_categories
     */
    public function getParentCategories($certain_category) {
        $parent_categories = collect([]);
        $parent_categories->prepend($certain_category);
        $parent_id = $certain_category->parent;
        
        while ($parent_id != 0) {
            $category = Category::select(['id', 'slug', 'name', 'parent'])->findOrFail($parent_id);
            $parent_categories->prepend($category);
            $parent_id = $category->parent;
        }

        return $parent_categories;
    }

    /**
     * Construct sorted categories tree
     *
     *
     */
    private function constructTree($parent, $depth) {
        $children = $this->categories->filter(function ($item) use ($parent) {
            return $item->parent == $parent;
        });

        $children->each(function ($item) use ($depth) {
            $item->name = str_repeat($this->prefix, $depth) . $item->name;
            $this->sorted->push($item);
            $this->constructTree($item->id, $depth + 1);
        });
    }
    
    /**
     * Construct sorted categories tree in JSON format
     *
     *
     */
    private function constructTreeForJSON(&$parent_node) {
        $id = $parent_node['id'];
        $children = $this->categories->filter(function ($item) use ($id) {
            return $item->parent == $id;
        });

        $children->each(function ($item, $index) use (&$parent_node) {
            $child = array(
                'id' => $item->id,
                'text' => $item->name,
                'state' => array('opened' => 'true'),
                'children' => array()
            );
            $count = array_push($parent_node['children'], $child);
            $this->constructTreeForJSON($parent_node['children'][$count-1]);
        });
    }
    
    /**
     * Construct sorted categories tree in JSON format
     *
     *
     */
    private function constructTreeForVue(&$parent_node) {
        $id = $parent_node['id'];
        $children = $this->categories->filter(function ($item) use ($id) {
            return $item->parent == $id;
        });

        $children->each(function ($item) use (&$parent_node) {
            $child = array(
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'count' => $item->count,
                'disabled' => true,
                'children' => array()
            );
            $count = array_push($parent_node['children'], $child);
            $this->constructTreeForVue($parent_node['children'][$count-1]);
        });
    }

    /**
     * Get categories for search result
     */
    public function search(request $request) {
        $search_term = '%' . $request->input('term') . '%';
        $categories = Category::where('name', 'LIKE', $search_term)->get(['id', 'name']);
        $options = $categories->map(function ($category) {
            return array(
                'id' => $category->id,
                'text' => $category->name
            );
        });

        return array(
            'results' => $options
        );
    }
}
