<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use App\Models\Media;
use App\Models\Tag;
use App\Models\Product;
use App\Models\TaxType;
use App\Models\Attribute;
use App\Models\AttributeTerm;
use Helper;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $author_id = $request->user()->id;
        $filter_category = $request->input('filter-category', '*');
        $filter_type = $request->input('filter-type', '*');
        $filter_stock = $request->input('filter-stock', '*');
        $category_controller = new CategoryController;
        $categories = $category_controller->categorySorted('product');
        $request->flash();
        
        $search_term = '%' . $request->input('search-term') . '%';
            
        $products = Product::with(['media', 'tags', 'categories'])
                        ->where('parent', 0);
        
        if ($author_id != 1 && $request->user()->role_id != 8) {
            $products = $products->where('author_id', $author_id);
        }

        if ($filter_category != '*') {
            $sub_categories = $category_controller->categorySorted('product', $filter_category);
            $sub_categories = $sub_categories->pluck('id');
            $sub_categories->prepend((int) $filter_category);
            $products = $products->whereHas('categories', function ($query) use ($sub_categories) {
                $query->whereIn('category_id', $sub_categories);
            });
        }

        if ($filter_type != '*') {
            $products = $products->where('type', $filter_type);
        }

        if ($filter_stock != '*') {
            $products = $products->where('stock_status', $filter_stock);
        }

        $products = $products->where(function ($query) use ($search_term) {
                        $query->where('name', 'LIKE', $search_term)
                                ->orWhere('sku', 'LIKE', $search_term)
                                ->orWhere('description', 'LIKE', $search_term);
                    })
                    ->sortable()
                    ->paginate(15);

        return view('admin.products.list', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $author_id = $request->user()->id;

        $category_controller = new CategoryController;
        $categories = $category_controller->categoryTree('product');
        $product_tags = Tag::select('id', 'name', 'type')
                            ->where('type', 'product')
                            ->get();
        $products = Product::where('enabled', true)
                            ->where('parent', 0);
        if ($author_id != 1 && $request->user()->role_id != 8) {
            $products = $products->where('author_id', $author_id);
        }

        $products = $products->get();
        $tax_types = TaxType::all();
        $attributes = Attribute::with('terms')->get();

        return view('admin.products.create', [
            'categories' => $categories,
            'product_tags' => $product_tags,
            'tax_types' => $tax_types,
            'attributes' => $attributes
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
        $author_id = $request->user()->id;
        $product = new Product();
        $product->fill($request->except(['attributes', 'media', 'files', 'variations']));

        if ($request->input('manage_stock')) {
            if ($request->filled('stock_quantity') && $request->input('stock_quantity') > intval(config('setting.product_low_stock_threshold'))) {
                $product->stock_status = 'in-stock';
            } else {
                $product->stock_status = 'out-of-stock';
            }

            if ($product->allow_backorder == 'yes') {
                $product->stock_status = 'on-backorder';
            }
        }

        $product->author_id = $author_id;
        $product_parent_slug = Str::slug($product->name, '-');

        if (Product::where('slug', $product_parent_slug)->first()) {
            $slug_index = 1;
            while (Product::where('slug', $product_parent_slug . '-' . $slug_index)->first()) {
                $slug_index ++;
            }
            $product->slug = $product_parent_slug . '-' . $slug_index;
        } else {
            $product->slug = $product_parent_slug;
        }

        $product->save();

        if ($request->filled('attributes')) {
            foreach ($request->input('attributes') as $attribute) {
                if (isset($attribute['pivot']) && implode(',', $attribute['pivot']['term_ids']) != "") {
                    $product->attributes()->attach(
                        $attribute['id'],
                        [
                            'used_for_variation' => $attribute['pivot']['used_for_variation'],
                            'show_product_page' => $attribute['pivot']['show_product_page'],
                            'term_ids' => implode(',', $attribute['pivot']['term_ids'])
                        ]
                    );
                    
                    $product->terms()->attach($attribute['pivot']['term_ids']);
                }
            }
        }

        if (count($request->input('media')) > 0) {
            $is_default = false;
            $media = $request->input('media');
            usort($media, function ($a, $b) {
                if ($b['pivot']['default']) {
                    return true;
                }
                return false;
            });
            foreach ($media as $medium) {
                $product->media()->attach($medium['id'], ['default' => $medium['pivot']['default']]);
                $is_default |= $medium['pivot']['default'];
            }

            if (! $is_default) {
                $product->media()->updateExistingPivot($media[0]['id'], ['default' => true]);
            }
        }

        if ($request->filled('product_tags')) {
            $tag_names = $request->input('product_tags');
            foreach ($tag_names as $tag_name) {
                $tag = Tag::where('type', 'product')->where('name', $tag_name)->first();

                if (! $tag) {
                    $tag = new Tag();
                    $tag->name = $tag_name;
                    $slug = Str::slug($tag_name, '-');
                    
                    $pattern = $slug . '(-[0-9]+)?$';
                    $tags_same_slug = Tag::where('type', 'product')->where('slug', 'RLIKE', $pattern)->get();
                    $count_same_slug = $tags_same_slug->count();
                    
                    if ($count_same_slug) {
                        $slug = $slug . '-' . ($count_same_slug + 1);
                    } else {
                        $tag->slug = $slug;
                        $tag->type = 'product';
                        $tag->save();
                        $product->tags()->attach($tag->id);
                    }
                } else {
                    $product->tags()->attach($tag->id);
                }
            }
        }

        if (count($request->input('product_categories')) > 0) {
            foreach ($request->input('product_categories') as $category) {
                $product->categories()->attach($category);
            }
        }

        if (count($request->input('files')) > 0) {
            foreach ($request->input('files') as $file) {
                if (! isset($file['copy_link'])) {
                    continue;
                }
                $product->files()->attach(
                    $file['id'],
                    ['name' => isset($file['pivot']['name']) ? $file['pivot']['name'] : $file['name']]
                );
            }
        }

        $id = $product->id;
        if ($request->input('type') == 'variable') {
            foreach ($request->input('variations') as $variation) {
                if (! isset($variation['price'])) {
                    continue;
                }
                
                $v_product = new Product();
                $v_product->fill(array_diff_key(
                    $variation,
                    array('excerpt' => '', 'files' => '', 'vAttrSelectOptions' => '', 'media' => '')
                ));
                $v_name = $product['name'] . ' - ';
    
                foreach ($variation['excerpt'] as $exc) {
                    foreach ($request->input('attributes') as $attribute) {
                        if ($attribute['id'] == $exc['attrId']) {
                            if (isset($exc['termId'])) {
                                $temp_term = AttributeTerm::find($exc['termId']);
                                $v_name .= (strpos($temp_term->name, '#') === false ? ucfirst($temp_term->name) : ucfirst($temp_term->slug)) . ', ';
                            }
                        }
                    }
                }

                $v_product->excerpt = json_encode($variation['excerpt']);
    
                if (substr($v_name, -2) == ', ') {
                    $v_name = substr($v_name, 0, -2);
                }

                if (! isset($variation['tax_type_id'])) {
                    $v_product->tax_type_id = $product['tax_type_id'];
                }

                $v_product->name = $v_name;
                $v_product->slug = $product_parent_slug;
                $v_product->parent = $id;
                $v_product->author_id = $author_id;
                $v_product->save();

                if (count($variation['files']) > 0) {
                    foreach ($variation['files'] as $file) {
                        if (! isset($file['copy_link'])) {
                            continue;
                        }
                        $v_product->files()->attach($file['id'], ['name' => isset($file['pivot']['name']) ? $file['pivot']['name'] : $file['name'] ]);
                    }
                }

                if (count($variation['media']) > 0) {
                    foreach ($variation['media'] as $medium) {
                        $v_product->media()->attach($medium['id'], ['default' => true]);
                    }
                }
            }
        }

        return array(
                    Product::with(['attributes', 'media', 'tags', 'files'])
                            ->where('id', $product->id)
                            ->first(),
                    Product::with(['media', 'files'])
                            ->where('parent', $id)
                            ->get()
                );
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
    public function edit(Request $request, $id)
    {
        $product = Product::with(['media', 'attributes', 'tags', 'files'])
                            ->where('id', $id)
                            ->first();
        if (Gate::denies('manage-resource', $product)) {
            abort(403);
        }

        if (! isset($product) || (isset($product) && $product->parent != 0)) {
            return response(view('admin.pages.404'), 404);
        }

        $author_id = $request->user()->id;

        $category_controller = new CategoryController;
        $categories = $category_controller->categoryTree('product');
        $current_categories = collect([]);
        foreach ($product->categories as $category) {
            $current_categories->push($category->id);
        }

        $product_tags = Tag::select('id', 'name', 'type')
                            ->where('type', 'product')
                            ->get();
        $products = Product::where('enabled', true)
                            ->where('parent', 0);

        if ($author_id != 1 && $request->user()->role_id != 8) {
            $products = $products->where('author_id', $author_id);
        }

        $products = $products->get();

        $tax_types = TaxType::all();
        $attributes = Attribute::with('terms')->get();
        $variations = Product::with(['media', 'files'])
                                ->where('parent', $id)
                                ->get();

        $upsells = Product::whereIn('id', $product->upsells)->get(['id', 'name']);
        $upsells = $upsells->map(function($item) {
            return array(
                'id' => $item->id,
                'text' => $item->name
            );
        });

        $cross_sells = Product::whereIn('id', $product->cross_sells)->get(['id', 'name']);
        $cross_sells = $cross_sells->map(function($item) {
            return array(
                'id' => $item->id,
                'text' => $item->name
            );
        });

        return view('admin.products.create', [
            'categories' => $categories,
            'product_tags' => $product_tags,
            'products' => $products,
            'tax_types' => $tax_types,
            'attributes' => $attributes,
            'product' => $product,
            'current_categories' => $current_categories,
            'variations' => $variations,
            'upsells' => $upsells,
            'cross_sells' => $cross_sells
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
        $product = Product::findOrFail($id);
        if(Gate::denies('manage-resource', $product)) {
            abort(403);
        }

        $product->fill($request->except(['attributes', 'media', 'tags', 'categories', 'variations']));

        if ($request->input('manage_stock')) {
            if ($request->filled('stock_quantity') && $request->input('stock_quantity') > intval(config('setting.product_low_stock_threshold'))) {
                $product->stock_status = 'in-stock';
            } else {
                $product->stock_status = 'out-of-stock';
            }
            if ($product->allow_backorder == 'yes') {
                $product->stock_status = 'on-backorder';
            }
        }
        
        if ($request->filled('attributes')) {
            $product->attributes()->detach();
            $product->terms()->detach();
            foreach ($request->input('attributes') as $attribute) {
                if (isset($attribute['pivot']) && implode(',', $attribute['pivot']['term_ids']) != "") {
                    $product->attributes()->attach(
                        $attribute['id'],
                        [
                            'used_for_variation' => $attribute['pivot']['used_for_variation'],
                            'show_product_page' => $attribute['pivot']['show_product_page'],
                            'term_ids' => implode(',', $attribute['pivot']['term_ids'])
                        ]
                    );
                    $product->terms()->attach($attribute['pivot']['term_ids']);
                }
            }
        }

        $product->media()->detach();
        if (count($request->input('media')) > 0) {
            $is_default = false;
            $media = $request->input('media');
            usort($media, function ($a, $b) {
                if ($b['pivot']['default']) {
                    return true;
                }
                return false;
            });
            foreach ($media as $medium) {
                $product->media()->attach($medium['id'], ['default' => $medium['pivot']['default']]);
                $is_default |= $medium['pivot']['default'];
            }

            if (! $is_default) {
                $product->media()->updateExistingPivot($media[0]['id'], ['default' => true]);
            }
        }

        if ($request->filled('product_tags')) {
            $tag_names = $request->input('product_tags');
            $product->tags()->detach();
            foreach ($tag_names as $tag_name) {
                $tag = Tag::where('type', 'product')->where('name', $tag_name)->first();

                if (! $tag) {
                    $tag = new Tag();
                    $tag->name = $tag_name;
                    $slug = Str::slug($tag_name, '-');
                    
                    $pattern = $slug . '(-[0-9]+)?$';
                    $tags_same_slug = Tag::where('type', 'product')->where('slug', 'RLIKE', $pattern)->get();
                    $count_same_slug = $tags_same_slug->count();
                    
                    if ($count_same_slug) {
                        $slug = $slug . '-' . ($count_same_slug + 1);
                    } else {
                        $tag->slug = $slug;
                        $tag->type = 'product';
                        $tag->save();
                    }
                }
                $product->tags()->attach($tag->id);
            }
        }

        $product->categories()->detach();
        if (count($request->input('product_categories')) > 0) {
            foreach ($request->input('product_categories') as $category) {
                $product->categories()->attach($category);
            }
        }

        $product->files()->detach();
        if (count($request->input('files')) > 0) {
            foreach ($request->input('files') as $file) {
                if (! isset($file['copy_link'])) {
                    continue;
                }
                $product->files()->attach($file['id'], ['name' => isset($file['pivot']['name']) ? $file['pivot']['name'] : $file['name'] ]);
            }
        }

        if ($request->filled('sale_start') && $request->filled('sale_end') && (date($request->input('sale_start')) > date($request->input('sale_end')))) {
            $product->sale_start = null;
            $product->sale_end = null;
        }

        $v_ids = Product::where('parent', $id)->pluck('id')->toArray();
        $v_input_ids = array_column($request->input('variations'), 'id');
        $v_diff_ids = array_values(array_diff($v_ids, $v_input_ids));
        Product::destroy($v_diff_ids);

        if ($request->input('type') == 'variable') {
            foreach ($request->input('variations') as $variation) {
                if (! isset($variation['price'])) {
                    continue;
                }
                if (isset($variation['id'])) {
                    $v_product = Product::findOrFail($variation['id']);
                } else {
                    $v_product = new Product();
                }
                $v_product->fill(array_diff_key($variation, array('excerpt' => '', 'files' => '', 'vAttrSelectOptions' => '', 'media' => '')));
                $v_name = $product['name'] . ' - ';
    
                foreach ($variation['excerpt'] as $exc) {
                    foreach ($request->input('attributes') as $attribute) {
                        if ($attribute['id'] == $exc['attrId']) {
                            if (isset($exc['termId'])) {
                                $temp_term = AttributeTerm::find($exc['termId']);
                                $v_name .= (strpos($temp_term->name, '#') === false ? ucfirst($temp_term->name) : ucfirst($temp_term->slug)) . ', ';
                            }
                        }
                    }
                }

                $v_product->excerpt = json_encode($variation['excerpt']);
    
                if (substr($v_name, -2) == ', ') {
                    $v_name = substr($v_name, 0, -2);
                }
    
                if (! isset($variation['tax_type_id'])) {
                    $v_product->tax_type_id = $product['tax_type_id'];
                }
    
                $v_product->name = $v_name;
                $v_product->parent = $id;
                $v_product->save();
    
                $v_product->files()->detach();
                if (count($variation['files']) > 0) {
                    foreach ($variation['files'] as $file) {
                        if (! isset($file['copy_link'])) {
                            continue;
                        }
                        $v_product->files()->attach($file['id'], ['name' => isset($file['pivot']['name']) ? $file['pivot']['name'] : $file['name'] ]);
                    }
                }
    
                $v_product->media()->detach();
                if (count($variation['media']) > 0) {
                    foreach ($variation['media'] as $medium) {
                        $v_product->media()->attach($medium['id'], ['default' => true]);
                    }
                }

                if (isset($variation['sale_start']) && isset($variation['sale_end']) && (date($variation['sale_start']) > date($variation['sale_end']))) {
                    $v_product->sale_start = null;
                    $v_product->sale_end = null;
                }
            }
        }
        
        $product->save();

        return array(
            Product::with(['media', 'attributes', 'tags', 'files'])
                ->where('id', $id)
                ->first(),
            Product::with(['media', 'files'])
                ->where('parent', $id)
                ->get()
        );
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request)
    {
        Product::destroy($request->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeFeatured(Request $request)
    {
        $product = Product::findOrFail($request->input('id'));
        if (Gate::allows('manage-resource', $product)) {
            $product->featured = ! $product->featured;
            $product->save();
        }
    }

    /**
     * Get products that are low in stack and out of stock
     *
     * @return \Illuminate\Http\Response
     */
    public function getLowOutStockProducts() {
        $low_out_stock_products = Product::where('manage_stock', '1')
                                            ->whereRaw('stock_quantity <= low_stock_threshold');
        $user = Auth::user();
        if ($user->role_id == 4) {
            $low_out_stock_products = $low_out_stock_products->where('author_id', $user->id);
        }
        $low_out_stock_products_count = $low_out_stock_products->count();
        $low_out_stock_products = $low_out_stock_products->take(5)->get(['id', 'stock_quantity', 'name']);
        
        return response([
            'count' => $low_out_stock_products_count,
            'products' => $low_out_stock_products->toJson()
        ], 200);
    }

    /**
     * Get products for upsells
     */
    public function search(request $request) {
        $search_term = '%' . $request->input('term') . '%';
        $products = Product::where('name', 'LIKE', $search_term)->get(['id', 'name']);
        $options = $products->map(function ($product) {
            return array(
                'id' => $product->id,
                'text' => $product->name
            );
        });

        return array(
            'results' => $options
        );
    }
}