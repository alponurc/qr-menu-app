<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function showMostFavoritedDishSetting()
    {
        $setting = DB::table('settings')
            ->where('key', 'show_most_favorited_dish')
            ->value('value');

        return response()->json([
            'show_most_favorited_dish' => $setting === 'true'
        ]);
    }
}
