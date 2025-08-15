<?php

namespace App\Orchid\Screens\Product;

use Orchid\Screen\Screen;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\CheckBox;
use Illuminate\Support\Facades\Storage;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;

class ProductEditScreen extends Screen {
  public $product;

  public function query(Product $product): iterable {
    return ['product' => $product];
  }

  public function name(): ?string {
    return $this->product->exists ? 'Edit product' : 'Creating a new product';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create product')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->product->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->product->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->product->exists)
        ->confirm('Are you sure you want to delete this product ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('product.name')
          ->title(__('Name:'))
          ->required(!$this->product->exists)
          ->placeholder('Enter product name'),

        TextArea::make('product.description')
          ->rows(5)
          ->title(__('Description:'))
          ->required(!$this->product->exists)
          ->placeholder('Enter short description'),

        Input::make('product.price')
          ->title('Price:')
          ->required(!$this->product->exists)
          ->mask([
            'alias' => 'currency',
            'groupSeparator' => '',
          ])
          ->placeholder('Enter price'),

        Input::make('product.weight')
          ->title('Weight:')
          ->required(!$this->product->exists)
          ->mask([
            'alias' => 'numeric',
            'digits' => 0,
            'digitsOptional' => false,
            'groupSeparator' => '',
          ])
          ->placeholder('Enter weight'),

        Input::make('product.calories')
          ->title(__('Calories:'))
          ->required(!$this->product->exists)
          ->mask([
            'alias' => 'numeric',
            'digits' => 0,
            'digitsOptional' => false,
            'groupSeparator' => '',
          ])
          ->placeholder('Enter calories'),

        Select::make('product.category')
          ->multiple()
          ->title(__('Categories:'))
          ->disabled(!Category::count())
          ->fromModel(Category::class, 'name', 'name')
          ->placeholder(Category::count() ? 'Select category' : 'Please create categories first in the "Categories" section.'),

        Select::make('product.tags')
          ->multiple()
          ->title(__('Tags:'))
          ->disabled(!Tag::count())
          ->fromModel(Tag::class, 'name', 'name')
          ->placeholder(Tag::count() ? 'Select tags' : 'Please create tags first in the "Tags" section.'),

        Input::make('product.image')
          ->type('file')
          ->required(!$this->product->exists)
          ->title(__('Image:'))
      ]),
      Layout::rows([
        CheckBox::make('product.is_new')
          ->value(0)
          ->sendTrueOrFalse()
          ->placeholder(__('New')),

        CheckBox::make('product.is_hot')
          ->value(0)
          ->sendTrueOrFalse()
          ->placeholder(__('Hot')),

        CheckBox::make('product.is_recommended')
          ->value(0)
          ->sendTrueOrFalse()
          ->placeholder(__('Recommended')),
      ])
    ];
  }

  public function create(Request $request) {

    $request->validate([
      'product.name' => 'required|min:3|max:225|unique:products,name,',
      'product.image' => 'image|mimes:jpeg,png,jpg|max:2048',
      'product.description' => 'required|min:3|max:225',
      'product.price' => 'required|min:3|max:225',
      'product.weight' => 'required|min:3|max:225',
      'product.calories' => 'required|min:3|max:225',
    ]);

    $product = $this->product->fill($request->get('product'));
    $image = asset('storage/' . $request->file('product.image')->store('', 'public'));

    $product->image = $image;
    $product->save();

    Alert::info('You have successfully created a product.');
    return redirect()->route('platform.product.list');
  }

  public function update(Request $request) {

    $request->validate([
      'product.name' => 'required|min:3|max:225|unique:products,name,' . $this->product->id,
      'product.image' => 'image|mimes:jpeg,png,jpg|max:2048' . $this->product->id,
      'product.description' => 'required|min:3|max:225' . $this->product->id,
      'product.price' => 'required|min:3|max:225' . $this->product->id,
      'product.weight' => 'required|min:3|max:225' . $this->product->id,
      'product.calories' => 'required|min:3|max:225' . $this->product->id,
    ]);

    $product = $request->get('product');

    if ($request->hasFile('product.image')) {
      $image = str_replace(asset('storage/'), '', $this->product->image);
      Storage::disk('public')->delete($image);
      $product['image'] = asset('storage/' . $request->file('product.image')->store('', 'public'));
    }

    $this->product->fill($product)->save();
    Alert::info('You have successfully updated the product.');
    return redirect()->route('platform.product.list');
  }

  public function remove(Product $product) {
    $image = str_replace(asset('storage/'), '', $product->image);
    Storage::disk('public')->delete($image);

    $product->delete();
    Alert::info('You have successfully deleted the product.');
    return redirect()->route('platform.product.list');
  }
}
