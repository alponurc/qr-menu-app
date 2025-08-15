<?php

namespace App\Orchid\Screens\Product;

use App\Models\Product;
use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;
use Illuminate\Support\Facades\Storage;

class ProductListScreen extends Screen {
  public function query(): iterable {
    return [
      'products' => Product::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Products';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create')
        ->icon('bs.plus-circle')
        ->route('platform.product.edit')
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('products', [
        TD::make('image', 'Image')
          ->cantHide()
          ->render(function (Product $product) {
            return '<img src="' . $product->image . '" width="50" height="50" style="object-fit: cover; object-position: center; border-radius: 7%;">';
          }),

        TD::make('name', 'Name')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Product $product) {
            return Link::make(Str::ucfirst($product->name))->route('platform.product.edit', $product->id);
          }),

        TD::make('price', 'Price')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Product $product) {
            return Link::make('$' . " " . $product->price)->route('platform.product.edit', $product->id);
          }),

        TD::make('weight', 'Weight')
          ->sort()
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->filter(Input::make())
          ->render(function (Product $product) {
            return Link::make($product->weight . " " . 'g')->route('platform.product.edit', $product->id);
          }),

        TD::make('updated_at', __('Last edit'))
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->align(TD::ALIGN_CENTER)
          ->render(function (Product $product) {
            return $product->updated_at->format('M j, Y');
          }),

        TD::make('id', 'ID')
          ->cantHide()
          ->sort()
          ->align(TD::ALIGN_CENTER)
          ->filter(Input::make())
          ->render(function (Product $product) {
            return '#' . $product->id;
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Product $product) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.product.edit', $product->id)
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this product ?')
                ->method('remove')
                ->parameters([
                  'product' => $product->id,
                ]),
            ])),
      ])
    ];
  }

  public function remove(Product $product) {
    $image = str_replace(asset('storage/'), '', $product->image);
    Storage::disk('public')->delete($image);

    $product->delete();
    Alert::info('You have successfully deleted the product.');
    return redirect()->route('platform.product.list');
  }
}
