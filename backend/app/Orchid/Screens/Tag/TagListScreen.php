<?php

namespace App\Orchid\Screens\Tag;

use App\Models\Tag;
use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

class TagListScreen extends Screen {

  public function query(): iterable {
    return [
      'tags' => Tag::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Tags';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create')
        ->icon('bs.plus-circle')
        ->route('platform.tag.edit')
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('tags', [

        TD::make('name', 'Name')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Tag $tag) {
            return Link::make(Str::ucfirst($tag->name))->route('platform.tag.edit', $tag->id);
          }),

        TD::make('updated_at', __('Last edit'))
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->align(TD::ALIGN_CENTER)
          ->render(function (Tag $tag) {
            return $tag->updated_at->format('M j, Y');
          }),

        TD::make('id', 'ID')
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->align(TD::ALIGN_CENTER)
          ->render(function (Tag $tag) {
            return '#' . $tag->id;
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Tag $tag) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.tag.edit', $tag->id)
                ->icon('bs.pencil'),
              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this tag ?')
                ->method('remove')
                ->parameters([
                  'tag' => $tag->id,
                ]),
            ])),
      ])
    ];
  }

  public function remove(Tag $tag) {
    $tag->delete();
    Alert::info('You have successfully deleted the tag.');
    return redirect()->route('platform.tag.list');
  }
}
