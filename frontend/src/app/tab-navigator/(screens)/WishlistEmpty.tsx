'use client';

import React from 'react';
import Image from 'next/image';

import {URLS} from '../../../config';
import {components} from '../../../components';

export const WishListEmpty: React.FC = () => {
  return (
    <components.Screen>
      <components.Header user={true} showBasket={true} />

      <main className='scrollable container' style={{paddingTop: 10, paddingBottom: 10}}>
        <section
          style={{
            height: '100%',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            borderRadius: 10,
            placeItems: 'center',
            flexDirection: 'column',
            backgroundColor: 'var(--white-color)',
          }}
        >
          <Image
            src={`${URLS.MAIN_URL}/assets/images/01.jpg`}
            alt='profile'
            width={290}
            height={290}
            priority={true}
            style={{
              maxWidth: 290,
              width: '100%',
              marginLeft: 'auto',
              marginRight: 'auto',
              marginBottom: 14,
            }}
          />

          <h2
            style={{
              textAlign: 'center',
              marginBottom: 14,
              textTransform: 'capitalize',
            }}
          >
            Favori Listesi <br /> Şu an boş!
          </h2>

          <p style={{textAlign: 'center'}} className='t16'>
            Favori yemeklerinizin listesi şu anda boş. <br />
            Neden sevdiğiniz yemekleri eklemeye başlamıyorsunuz?
          </p>
        </section>
      </main>

      <components.Modal />
      <components.BottomTabBar />
    </components.Screen>
  );
};
