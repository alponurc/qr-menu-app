<?php

namespace App\Orchid\Screens\Carousel;

use App\Models\Slide;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Illuminate\Support\Facades\File;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Storage;

class SlideEditScreen extends Screen {
  public $slide;

  public function query(Slide $slide): iterable {
    return [
      'slide' => $slide,
    ];
  }

  public function name(): ?string {
    return $this->slide->exists ? 'Edit slide' : 'Creating a new slide';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create slide')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->slide->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->slide->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->slide->exists)
        ->confirm('Are you sure you want to delete this slide ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('slide.image')
          ->type('file')
          ->title('Image'),
      ]),
    ];
  }

  public function create(Request $request) {
    $request->validate([
      'slide.image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $slide = [
      'image' => asset('storage/' . $request->file('slide.image')->store('', 'public')),
    ];

    $this->slide->fill($slide)->save();
    Alert::info('You have successfully created a slide.');
    return redirect()->route('platform.slide.list');
  }

  public function update(Request $request) {
    $request->validate([
      'slide.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' . $this->slide->id,
    ]);

    $slide = [];

    if ($request->hasFile('slide.image')) {
      $image = str_replace(asset('storage/'), '', $this->slide->image);
      Storage::disk('public')->delete($image);
      $slide['image'] = asset('storage/' . $request->file('slide.image')->store('', 'public'));
    }

    $this->slide->fill($slide)->save();
    Alert::info('You have successfully updated the slide.');
    return redirect()->route('platform.slide.list');
  }

  public function remove(Slide $slide) {
    $image = str_replace(asset('storage/'), '', $slide->image);
    Storage::disk('public')->delete($image);

    $slide->delete();
    Alert::info('You have successfully deleted the slide.');
    return redirect()->route('platform.slide.list');
  }
}
