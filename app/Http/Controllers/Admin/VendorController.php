<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Lang;
use App\Models\User;
use App\Models\Media;
use App\Models\Vendor;
use App\Models\UserWithdraw;

class VendorController extends Controller
{
    /**
     * Display vendor settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSetting($id) {
        $user = Auth::user();
        if ($user->role_id != 4 || ($user->role_id == 4 && $user->id == $id)) {
            $media = Media::where('type', 'LIKE', 'image%')
                            ->where('author_id', $id)->get();
            $vendor = User::with(['vendor', 'vendor.banner', 'vendor.profile'])
                            ->findOrFail($id);
            return view('admin.ecommerce.vendors.setting', ['media' => $media, 'vendor' => $vendor]);
        } else {
            abort(403);
        }
    }

    /**
     * Update vendor settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateVendor(Request $request, $id) {
        $active_user = Auth::user();
        $user = User::findOrFail($id);
        if ($active_user->role_id == 7 || $active_user->id == $id) {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->save();
            $vendor = Vendor::where('user_id', $id)->first();
            $vendor = $vendor->fill($request->except('balance'));
            $vendor->save();
        } else {
            abort(403);
        }
    }

    /**
     * Display vendor settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWithdraw(Request $request) {
        $request->flash();
        $user = Auth::user();
        $vendor = Vendor::where('user_id', $user->id)->first();
        $filter_by = $request->input('filter-by', '*');
        $withdraws = $user->withdraws();
        
        
        if ($filter_by != '*') {
            $withdraws = $withdraws->where('status', $filter_by);
        }

        $withdraws = $withdraws->get();
        
        $can_add = $withdraws->where('status', 'processing')->count() > 0 ? false : true;
        return view('admin.ecommerce.vendors.withdraw', ['withdraws' => $withdraws, 'can_add' => $can_add, 'balance' => $vendor->balance]);
    }

    /**
     * store vendor withdraw.
     *
     * @return \Illuminate\Http\Response
     */
    public function addWithdraw(Request $request) {
        $user = Auth::user();
        $amount = floatval($request->input('amount', 0));
        $vendor = Vendor::where('user_id', $user->id)->first();

        if ($amount < floatval(config('setting.withdraw_minimum_limit'))) {
            abort(500, Lang::get('custom.withdraw_minimum_limit'));
        }

        if ($amount > $vendor->balance) {
            abort(500, Lang::get('custom.withdraw_exceed_balance'));
        }

        UserWithdraw::create([
            'user_id' => $user->id,
            'amount' => $amount
        ]);

        $vendor->balance = $vendor->balance - $amount;
        $vendor->save();
    }

    /**
     * cancel vendor withdraw.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelWithdraw(Request $request, $id) {
        $user = Auth::user();
        $withdraw = UserWithdraw::findOrFail($id);

        if (($user->role_id == 7 || $user->id == $withdraw->user_id) && $withdraw->status == 'processing') {
            $vendor = Vendor::where('user_id', $withdraw->user_id)->first();
            $vendor->balance = $vendor->balance + $withdraw->amount;
            $vendor->save();
            $withdraw->status = 'cancelled';
            $withdraw->save();
        } else {
            abort(403, Lang::get('custom.unauthorized'));
        }
    }

    /**
     * delete vendor withdraw.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteWithdraw(Request $request, $id) {
        $user = Auth::user();
        $withdraw = UserWithdraw::findOrFail($id);

        if ($user->role_id == 7 || $user->id == $withdraw->user_id) {
            $vendor = Vendor::where('user_id', $withdraw->user_id)->first();
            if ($withdraw->status == 'processing') {
                $vendor->balance = $vendor->balance + $withdraw->amount;
            }

            $vendor->save();
            $withdraw->delete();
        } else {
            abort(403, Lang::get('custom.unauthorized'));
        }
    }

    /**
     * Approve vendor withdraw.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveWithdraw(Request $request, $id) {
        $user = Auth::user();
        $withdraw = UserWithdraw::findOrFail($id);

        if (($user->role_id == 7 || $user->id == $withdraw->user_id) && $withdraw->status == 'processing') {
            $withdraw->status = 'approved';
            $withdraw->save();
        } else {
            abort(403, Lang::get('custom.unauthorized'));
        }
    }

    /**
     * Get All vendors.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendors(Request $request) {
        $request->flash();
        $search_term = '%' . $request->input('search-term') . '%';
        $vendors = User::with(['vendor'])
                        ->where(function ($query) use ($search_term) {
                            $query->where('first_name', 'LIKE', $search_term)
                                    ->orWhere('last_name', 'LIKE', $search_term)
                                    ->orWhere('email', 'LIKE', $search_term);
                        })
                        ->whereHas('vendor')
                        ->where('role_id', 4)
                        ->paginate(20);
        return view('admin.multivendor.vendors', ['vendors' => $vendors]);
    }

    /**
     * Change featured property of vendor
     *
     * @return \Illuminate\Http\Response
     */
    public function changeFeatured(Request $request) {
        $id = $request->input('id');
        $vendor = Vendor::findOrFail($id);
        if ($vendor) {
            $vendor->featured = ! $vendor->featured;
            $vendor->save();
        }
    }

    /**
     * Change status for a vendor
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request) {
        $id = $request->input('id');
        $vendor = Vendor::findOrFail($id);
        if ($vendor) {
            $vendor->status = !$vendor->status;
            $vendor->save();
        }
    }

    /**
     * Get all withdraws
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllWithdraws(Request $request) {
        $request->flash();
        $filter_by = $request->input('filter-by', '*');
        $withdraws = UserWithdraw::with(['user.vendor']);
        
        if ($filter_by !== '*') {
            $withdraws = $withdraws->where('status', $filter_by);
        }

        $withdraws = $withdraws->paginate(20);
        return view('admin.multivendor.withdraw', ['withdraws' => $withdraws]);
    }
}
