<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\Dish;

class PlatformScreen extends Screen
{
    public function query(): iterable
    {
        $mostFavoritedDish = Dish::orderByDesc('favorites')->first();

        return [
            'mostFavoritedDish' => $mostFavoritedDish,
        ];
    }

    public function name(): ?string
    {
        return 'Get Started';
    }

    public function description(): ?string
    {
        return 'Welcome to your Orchid application.';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('platform::partials.update-assets'),
            Layout::view('platform::partials.welcome'),
            Layout::view('admin.most-favorited'), // ✅ Bunu ekliyoruz
        ];
    }
}
