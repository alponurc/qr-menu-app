<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;

class DishController extends Controller
{
    /**
     * Favori sayısını bir artırır.
     */
    public function addFavorite($id)
    {
        $dish = Dish::findOrFail($id);
        $dish->favorite_count += 1;
        $dish->save();

        return response()->json([
            'message' => 'Favorite count updated.',
            'favorites' => $dish->favorite_count,
        ]);
    }

    /**
     * En çok favorilenen yemeği döndürür.
     */
    public function mostFavoritedDish()
    {
        $dish = Dish::orderByDesc('favorite_count')->first();

        if (!$dish) {
            return response()->json([
                'message' => 'No dishes found.'
            ], 404);
        }

        return response()->json($dish);
    }
}
