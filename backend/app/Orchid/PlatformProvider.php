<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;
use App\Models\Order;

class PlatformProvider extends OrchidServiceProvider {
  /**
   * Bootstrap the application services.
   *
   * @param Dashboard $dashboard
   *
   * @return void
   */
  public function boot(Dashboard $dashboard): void {
    parent::boot($dashboard);

    // ...
  }

  /**
   * Register the application menu.
   *
   * @return Menu[]
   */
  public function menu(): array {
    return [

      Menu::make('Products')
        ->icon('bs.list')
        ->route('platform.product.list'),

      Menu::make('Promocodes')
        ->icon('bs.percent')
        ->route('platform.promocode.list'),

      Menu::make('Categories')
        ->icon('bs.grid')
        ->route('platform.category.list'),

      Menu::make('Tags')
        ->icon('bs.tag')
        ->route('platform.tag.list'),

      Menu::make('Orders')
        ->icon('bs.cart3')
        ->badge(function () {
          if (Order::where('order_status', 'pending')->count() > 0) {
            return Order::where('order_status', 'pending')->count();
          }
        })
        ->route('platform.order.list'),

      Menu::make('Carousel')
        ->icon('bs.collection-play')
        ->route('platform.slide.list'),

        Menu::make('Dishes')
        ->icon('list')
        ->route('platform.dishes'),


      Menu::make(__('Users'))
        ->icon('bs.people')
        ->route('platform.systems.users')
        ->permission('platform.systems.users')
        ->title(__('Access Controls')),

      Menu::make(__('Roles'))
        ->icon('bs.shield')
        ->route('platform.systems.roles')
        ->permission('platform.systems.roles')
        ->divider(),

      Menu::make('Documentation')
        ->title('Docs')
        ->icon('bs.box-arrow-up-right')
        ->url('https://orchid.software/en/docs')
        ->target('_blank'),

      Menu::make('Changelog')
        ->icon('bs.box-arrow-up-right')
        ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
        ->target('_blank')
        ->badge(fn () => Dashboard::version(), Color::DARK),
    ];
  }

  /**
   * Register permissions for the application.
   *
   * @return ItemPermission[]
   */
  public function permissions(): array {
    return [
      ItemPermission::group(__('System'))
        ->addPermission('platform.systems.roles', __('Roles'))
        ->addPermission('platform.systems.users', __('Users')),
    ];
  }
}
