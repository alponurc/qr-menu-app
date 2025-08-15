<?php

namespace App\Orchid\Screens;

use App\Models\Dish;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Blank;

class DishListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     */
    public function query(): iterable
    {
        return [
            'mostFavoritedDish' => Dish::orderByDesc('favorite_count')->first(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'En Çok Favorilenen Yemek';
    }

    /**
     * The screen's layout elements.
     */
    public function layout(): iterable
    {
        return [
            Layout::view('admin.most-favorited-dish'),
        ];
    }
}
