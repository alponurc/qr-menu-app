<?php

namespace App\Orchid\Screens\Order;

use Orchid\Screen\Screen;


use App\Models\Order;
use Orchid\Support\Facades\Alert;

use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\DropDown;

class OrderListScreen extends Screen {
  public function query(): iterable {
    return [
      // 'order' => Order::filters()->defaultSort('created_at', 'desc')->paginate(10),
      'order' => Order::all(),
    ];
  }

  public function name(): ?string {
    return 'Orders';
  }

  public function commandBar(): iterable {
    return [];
  }

  public function layout(): iterable {
    return [
      Layout::table('order', [
        TD::make('id', 'ID')
          ->cantHide()
          ->sort()
          ->render(function (Order $order) {
            return '#' . $order->id;
          }),

        TD::make('name', 'Name')
          ->cantHide()
          ->sort()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return Link::make(Str::ucfirst($order->name, 25))->route('platform.order.detail', $order->id);
          }),

        TD::make('phone_number', 'Phone')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return $order->phone_number;
          }),

        TD::make('total_price', 'Total')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return '$' . $order->total_price;
          }),

        TD::make('order_status', 'Status')
          ->sort()
          ->cantHide()
          ->filter(Input::make())
          ->render(function (Order $order) {
            return ucfirst($order->order_status);
          }),

        TD::make(__('Actions'))
          ->cantHide()
          ->align(TD::ALIGN_CENTER)
          ->render(fn (Order $order) => DropDown::make()
            ->icon('bs.three-dots-vertical')
            ->list([

              Link::make(__('Details'))
                ->route('platform.order.detail', $order->id)
                ->icon('bs.pencil'),

              Button::make('Delete')
                ->icon('bs.trash3')
                ->confirm('Are you sure you want to delete this order ?')
                ->method('remove')
                ->parameters([
                  'order' => $order->id,
                ]),

            ])),

      ])
    ];
  }

  public function remove(Order $order) {
    $order->delete();
    Alert::info('You have successfully deleted the order.');
    return redirect()->route('platform.order.list');
  }
}
