'use client';

import React from 'react';

import {items} from '../../../items';
import {stores} from '../../../stores';
import {components} from '../../../components';

import {useGetMostFavoritedDish} from '@/hooks/useGetMostFavoritedDish';
import {useGetShowMostFavoritedDishSetting} from '@/hooks/useGetShowMostFavoritedDishSetting';



export const Wishlist: React.FC = () => {
  const {list: wishlist} = stores.useWishlistStore();
  const {data: mostFavoritedDish} = useGetMostFavoritedDish();
  const {data: showMostFavoritedSetting} = useGetShowMostFavoritedDishSetting();

  const renderHeader = () => (
    <components.Header user={true} showBasket={true} title='Favorite' />
  );

  const renderContent = () => (
    <main className='scrollable container' style={{paddingTop: 10, paddingBottom: 20}}>
      <ul
        style={{
          display: 'grid',
          gap: 15,
          gridTemplateColumns: 'repeat(2, 1fr)',
        }}
      >
        {showMostFavoritedSetting?.show_most_favorited_dish && mostFavoritedDish && (
          <li style={{gridColumn: 'span 2'}}>
            <items.WishlistItem dish={mostFavoritedDish} isMostFavorited />
          </li>
        )}
        {wishlist.map((dish) => (
          <items.WishlistItem dish={dish} key={dish.id} />
        ))}
      </ul>
    </main>
  );

  return (
    <components.Screen>
      {renderHeader()}
      {renderContent()}
      <components.Modal />
      <components.BottomTabBar />
    </components.Screen>
  );
};
