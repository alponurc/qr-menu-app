<?php

namespace App\Orchid\Screens\Promocode;

use App\Models\Promocode;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\DateTimer;

class PromocodeEditScreen extends Screen {
  public $promocode;

  public function query(Promocode $promocode): iterable {
    return [
      'promocode' => $promocode
    ];
  }

  public function name(): ?string {
    return $this->promocode->exists ? 'Edit promocode' : 'Creating a new promocode';
  }

  public function commandBar(): iterable {
    return [
      Button::make('Create promocode')
        ->icon('pencil')
        ->method('create')
        ->canSee(!$this->promocode->exists),

      Button::make('Update')
        ->icon('note')
        ->method('update')
        ->canSee($this->promocode->exists),

      Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->promocode->exists)
        ->confirm('Are you sure you want to delete this promocode ?'),
    ];
  }

  public function layout(): iterable {
    return [
      Layout::rows([
        Input::make('promocode.code')
          ->type('text')
          ->title(__('Code'))
          ->placeholder('Enter code')
          ->required(!$this->promocode->exists),

        Input::make('promocode.discount')
          ->type('number')
          ->title(__('Discount'))
          ->placeholder('Enter discount in %')
          ->required(!$this->promocode->exists),

        DateTimer::make('promocode.expires_at')
          ->title(__('Expires at'))
          ->format('Y-m-d')
      ])
    ];
  }

  public function create(Request $request) {

    $request->validate([
      'promocode.code' => 'required|unique:promocodes,code,' . $this->promocode->id,
      'promocode.discount' => 'required|numeric|min:1|max:100',
    ]);

    $this->promocode->fill($request->get('promocode'))->save();
    Alert::info('You have successfully created the promocode.');
    return redirect()->route('platform.promocode.list');
  }

  public function update(Request $request) {

    $request->validate([
      'promocode.code' => 'required|unique:promocodes,code,' . $this->promocode->id,
      'promocode.discount' => 'required|numeric|min:1|max:100',
    ]);

    $this->promocode->fill($request->get('promocode'))->save();
    Alert::info('You have successfully updated the promocode.');
    return redirect()->route('platform.promocode.list');
  }

  public function remove(Promocode $promocode) {
    $promocode->delete();
    Alert::info('You have successfully deleted the promocode.');
    return redirect()->route('platform.promocode.list');
  }
}
