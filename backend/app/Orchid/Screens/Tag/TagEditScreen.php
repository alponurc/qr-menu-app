<?php

namespace App\Orchid\Screens\Tag;

use App\Models\Tag;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;

class TagEditScreen extends Screen {
  public $tag;

  public function query(Tag $tag): iterable {
    return [
      'tag' => $tag,
    ];
  }

  public function name(): ?string {
    return $this->tag->exists ? 'Edit tag' : 'Creating a new tag';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create tag')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->tag->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->tag->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->tag->exists)
        ->confirm('Are you sure you want to delete this tag ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('tag.name')
          ->required(!$this->tag->exists)
          ->placeholder('Dietary tag name')
          ->title(__('Name')),
      ])
    ];
  }

  public function create(Request $request) {

    $request->validate([
      'tag.name' => 'required|min:3|max:225|unique:tags,name',
    ]);

    $tag = [
      'name' => ucwords($request->input('tag.name')),
    ];

    $this->tag->fill($tag)->save();
    Alert::info('You have successfully created the tag.');
    return redirect()->route('platform.tag.list');
  }

  public function update(Request $request) {

    $request->validate([
      'tag.name' => 'required|min:3|max:225|unique:tags,name,' . $this->tag->id,
    ]);

    $tag = [
      'name' => ucwords($request->input('tag.name')),
    ];

    $this->tag->fill($tag)->save();
    Alert::info('You have successfully updated the tag.');
    return redirect()->route('platform.tag.list');
  }

  public function remove(Tag $tag) {
    $tag->delete();
    Alert::info('You have successfully deleted the tag.');
    return redirect()->route('platform.tag.list');
  }
}
