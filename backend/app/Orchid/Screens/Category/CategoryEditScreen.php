<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;

class CategoryEditScreen extends Screen {
  public $category;

  public function query(Category $category): iterable {
    return [
      'category' => $category
    ];
  }

  public function name(): ?string {
    return $this->category->exists ? 'Edit category' : 'Creating a new category';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create category')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->category->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->category->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->category->exists)
        ->confirm('Are you sure you want to delete this category ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('category.name')
          ->required(!$this->category->exists)
          ->placeholder('Category name')
          ->title(__('Name')),

        Input::make('category.image')
          ->required(!$this->category->exists)
          ->type('file')
          ->title(__('Image')),
      ])
    ];
  }

  public function create(Request $request) {
    $request->validate([
      'category.name' => 'required|min:3|max:225|unique:categories,name',
      'category.image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $category = [
      'name' => ucwords($request->input('category.name')),
      'image' => asset('storage/' . $request->file('category.image')->store('', 'public')),
    ];

    $this->category->fill($category)->save();
    Alert::info('You have successfully created a category.');
    return redirect()->route('platform.category.list');
  }

  public function update(Request $request) {
    $request->validate([
      'category.name' => 'required|min:3|max:225|unique:categories,name,' . $this->category->id,
      'category.image' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $category = [
      'name' => ucwords($request->input('category.name')),
    ];

    if ($request->hasFile('category.image')) {
      $image = str_replace(asset('storage/'), '', $this->category->image);
      Storage::disk('public')->delete($image);
      $category['image'] = asset('storage/' . $request->file('category.image')->store('', 'public'));
    }

    $this->category->fill($category)->save();
    Alert::info('You have successfully updated the category.');
    return redirect()->route('platform.category.list');
  }

  public function remove(Category $category) {
    $image = str_replace(asset('storage/'), '', $category->image);
    Storage::disk('public')->delete($image);

    $category->delete();
    Alert::info('You have successfully deleted the category.');
    return redirect()->route('platform.category.list');
  }
}
