<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;

class VendorController extends Controller
{
    /**
     * Get Data for Vendors
     *
     * @param \Iluuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getVendors(Request $request) {
        $vendors = User::with(['vendor:user_id,banner_image,profile_image,country,state,store_name', 'vendor.banner:id,copy_link,width,height', 'vendor.profile:id,copy_link,width,height'])
                        ->where('role_id', 4)
                        ->select(['created_at', 'id', 'role_id'])
                        ->whereHas('vendor', function ($query) {
                            $query->where('status', true);
                        })
                        ->get();
        
        foreach ($vendors as $vendor) {
            $products = Product::where('author_id', $vendor->id)
                                ->where('parent', 0)
                                ->get()
                                ->toArray();
            
            $vendor->rating = array_column($products, 'average_rating');

            if (count($vendor->rating) > 0) {
                $vendor->rating = round(array_sum($vendor->rating) / count($vendor->rating), 2);
            } else {
                $vendor->rating = 0;
            }
        }
        
        return response(['vendors' => $vendors]);
    }

    /**
     * Get Data for Vendors
     *
     * @param \Iluuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSingleVendor(Request $request, $id) {
        $per_page = 9;
        $vendor = User::with(['vendor:user_id,banner_image,profile_image,country,state,store_name', 'vendor.banner:id,copy_link,width,height', 'vendor.profile:id,copy_link,width,height'])
                        ->where('role_id', 4)
                        ->select(['created_at', 'id', 'role_id'])
                        ->whereHas('vendor', function ($query) {
                            $query->where('status', true);
                        })
                        ->findOrFail($id);

        $products = Product::where('author_id', $id)
                            ->withCount('approvedReviews')
                            ->where('parent', 0)
                            ->get()
                            ->toArray();

        $approved_reviews_count = array_sum(array_column($products, 'approved_reviews_count'));
        $ratings_array = array_column($products, 'average_rating');
        $totalCount = count($ratings_array);

        if ($totalCount > 0) {
            $vendor->rating = round(array_sum($ratings_array) / $totalCount, 2);
        } else {
            $vendor->rating = 0;
        }

        $vendor->approved_reviews_count = $approved_reviews_count;

        $products = Product::select(['id', 'name', 'slug', 'parent', 'type', 'price', 'sale_end', 'sale_price', 'sale_schedule', 'sale_start', 'excerpt', 'short_desc', 'featured', 'manage_stock', 'stock_status','stock_quantity', 'sold_individually'])
                            ->with(['media:copy_link', 'categories'])
                            ->where('author_id', $id)
                            ->where('parent', 0);
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

            $temp = $products;
            $totalCount = $temp->count();

            if ($certain_category->parent == -1) {
                $parent_categories = collect([])->prepend($certain_category)->all();
            } else {
                $parent_categories = $category_controller->getParentCategories($certain_category)->all();
            }
        }

        $products = $products->paginate($per_page);
        
        $category_controller = new CategoryController();
        $categories = $category_controller->categoryTreeForVue('product');
        
        return response(['vendor' => $vendor, 'products' => $products, 'totalCount' => $totalCount, 'categories' => $categories]);
    }
}
