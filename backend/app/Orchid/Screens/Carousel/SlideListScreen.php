<?php

namespace App\Orchid\Screens\Carousel;

use App\Models\Slide;
use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

class SlideListScreen extends Screen {
  public function query(): iterable {
    return [
      'slides' => Slide::filters()->defaultSort('updated_at', 'desc')->paginate(10)
    ];
  }

  public function name(): ?string {
    return 'Slides';
  }

  public function description(): ?string {
    return 'You can add maximum 3 slides.';
  }

  public function commandBar(): iterable {
    return [
      Link::make('Create')
        ->icon('bs.plus-circle')
        ->route('platform.slide.edit')
        ->canSee(Slide::count() < 3)
    ];
  }

  public function layout(): iterable {
    return [
      Layout::table('slides', [

        TD::make('image', 'Image')
          ->cantHide()
          ->render(function (Slide $slide) {
            return '<img src="' . $slide->image . '" width="90" height="60" style="object-fit: cover; object-position: center; border-radius: 7px;">';
          }),

        TD::make('updated_at', __('Last edit'))
          ->cantHide()
          ->sort()
          ->align(TD::ALIGN_CENTER)
          ->filter(Input::make())
          ->render(function (Slide $slide) {
            return $slide->updated_at->format('M j, Y');
          }),

        TD::make('id', 'ID')
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->align(TD::ALIGN_CENTER)
          ->render(function (Slide $slide) {
            return '#' . $slide->id;
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->width('100px')
          ->render(fn (Slide $slide) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([
              Link::make(__('Edit'))
                ->route('platform.slide.edit', $slide->id)
                ->icon('bs.pencil'),

              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this slide ?')
                ->method('remove')
                ->parameters([
                  'slide' => $slide->id,
                ]),
            ])),
      ])
    ];
  }

  public function remove(Slide $slide) {
    $slide->delete();
    Alert::info('You have successfully deleted the slide.');
    return redirect()->route('platform.slide.list');
  }
}
