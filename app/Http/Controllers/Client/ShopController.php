<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Admin\CategoryController;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use App\Models\AttributeTerm;

class ShopController extends Controller
{
    /**
     * Get data for shop page
     *
     * @return \Illuminate\Http\Response
     */
    public function getShopSidebarData() {
        $attributes = Attribute::with('terms')->get();

        $category_controller = new CategoryController();
        $categories = $category_controller->categoryTreeForVue('product');

        $featured_products = Product::select(['id', 'name', 'slug', 'parent', 'type', 'price', 'sale_end', 'sale_price', 'sale_schedule', 'sale_start', 'excerpt'])
                                    ->with(['media:copy_link', 'categories:slug,name'])
                                    ->where('parent', 0)
                                    ->withCount('approvedReviews')
                                    ->where('featured', true)
                                    ->has('media')
                                    ->take(3)
                                    ->get();

        return array(
            'attributes' => $attributes,
            'categories' => $categories,
            'featuredProducts' => $featured_products
        );
    }

    /**
     * Get data for shop page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getShopData(Request $request) {
        $per_page = $request->input('per_page', 8);
        $page = $request->input('page', 1);
        $min_price = $request->input('min_price', 0);
        $max_price = $request->input('max_price', 100000);

        $parent_categories = array();
        $products = Product::select(['id', 'name', 'slug', 'parent', 'type', 'price', 'sale_end', 'sale_price', 'sale_schedule', 'sale_start', 'excerpt', 'short_desc', 'featured', 'manage_stock', 'stock_status','stock_quantity', 'sold_individually'])
                            ->with(['media:copy_link', 'categories'])
                            ->where('parent', 0)
                            ->where('name', 'LIKE', '%' . $request->input('search_term') . '%')
                            ->withCount('approvedReviews');
        
        if (config('setting.product_out_of_stock_visibility') == '1') {
            $products = $products->where('stock_status', 'in-stock');
        }

        if ($request->filled('category')) {
            $category_controller = new CategoryController();

            $certain_category = Category::where('type', 'product')
                                        ->where('slug', $request->input('category'))
                                        ->first();

            $sub_categories = $category_controller->categorySorted('product', $certain_category->id);
            $sub_categories = $sub_categories->pluck('id');
            $sub_categories->prepend((int)$certain_category->id);
            
            $products = $products->whereHas('categories', function ($query) use ($sub_categories) {
                $query->whereIn('category_id', $sub_categories);
            });

            if ($certain_category->parent == -1) {
                $parent_categories = collect([])->prepend($certain_category)->all();
            } else {
                $parent_categories = $category_controller->getParentCategories($certain_category)->all();
            }
        }

        if ($request->filled('attributes')) {
            $certain_terms = explode(',', $request->input('attributes'));
            $term_ids = AttributeTerm::whereIn('slug', $certain_terms)->get()->pluck('id');

            $products = $products->where(function ($q) use ($term_ids) {
                foreach ($term_ids as $term_id) {
                    $q = $q->orWhereHas('terms', function ($query) use ($term_id) {
                        $query->where('attribute_term_id', $term_id);
                    });
                }
            });
        }
        
        if ($request->filled('tag')) {
            $certain_tag = $request->input('tag');

            $products = $products->whereHas('tags', function ($query) use ($certain_tag) {
                $query->where('slug', $certain_tag);
            });
        }

        $total_count = $products->count();

        if ($request->filled('orderBy')) {
            $sort_by = $request->input('orderBy');
            
            if ($sort_by == 'popularity') {
                $products = $products->orderByDesc('featured')->get();
            } elseif ($sort_by == 'date') {
                $products = $products->latest()->get();
            } elseif ($sort_by == 'rating') {
                $products = $products->leftJoinSub('select product_id, avg(rating) as average_rating from product_reviews group by product_id', 'reviews', function ($join) {
                    $join->on('id', '=', 'reviews.product_id');
                })
                ->orderByDesc('average_rating')
                ->get();
            } elseif ($sort_by == 'price') {
                $products = $products->get();

                $products = $products->sortBy(function ($product) {
                    return $product->min_max_price[0];
                });
            } elseif ($sort_by == 'price-desc') {
                $products = $products->get();

                $products = $products->sortByDesc(function ($product) {
                    return $product->min_max_price[0];
                });
            } else {
                $products = $products->get();
            }
        } else {
            $products = $products->get();
        }

        $products = $products->filter(function ($value, $key) use ($min_price, $max_price) {
            return ($value->min_max_price[0] > $min_price) && ($value->min_max_price[1] < $max_price);
        });

        $products = $products->forPage($page, $per_page)->values();
        
        return array(
            'products' => $products,
            'totalCount' => $total_count,
            'parentCategories' => $parent_categories
        );
    }
}
