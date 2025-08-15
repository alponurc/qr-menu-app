<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        return response()->json([
            'onboarding' => [
                [
                    'id' => 1,
                    'title1' => 'Embark On Culinary',
                    'title2' => 'Adventures',
                    'image' => asset('api/assets/images/05.jpg'),
                    'description1' => 'Manage your funds effortlessly.',
                    'description2' => 'Transfer money with ease.',
                ],
                [
                    'id' => 2,
                    'title1' => 'Craft Your',
                    'title2' => 'Perfect Order',
                    'image' => asset('api/assets/images/06.jpg'),
                    'description1' => 'Your new card is just minutes away.',
                    'description2' => 'Instant activation, zero hassle.',
                ],
                [
                    'id' => 3,
                    'title1' => 'Taste The',
                    'title2' => 'Delivered Magic',
                    'image' => asset('api/assets/images/07.jpg'),
                    'description1' => 'Global payments at your fingertips.',
                    'description2' => 'Secure transactions, anytime.',
                ],
            ]
        ]);
    }
}
