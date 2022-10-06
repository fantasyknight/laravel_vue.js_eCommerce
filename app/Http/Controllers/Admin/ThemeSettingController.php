<?php

namespace App\Http\Controllers\Admin;

use App\Models\Media;
use App\Models\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThemeSettingController extends Controller
{
    public function index() {
        $media = Media::all();
        return view('admin.theme.index', [ 'settings' => config('setting'), 'media' => $media ]);
    }

    public function menuShow() {
        $content = file_get_contents(resource_path('js/data/menu.js'));
        return view('admin.theme.menu', compact('content'));
    }

    public function storeMenu(Request $request) {
        file_put_contents(resource_path('js/data/menu.js'), $request->input('menu-json'));
        return back();
    }
}
