'use client';

import Link from 'next/link';
import Image from 'next/image';
import React, { useState, useEffect } from 'react';
import {Swiper, SwiperSlide} from 'swiper/react';
import PuffLoader from 'react-spinners/PuffLoader';

import {items} from '../../../items';
import {hooks} from '../../../hooks';
import {Routes} from '../../../routes';
import {components} from '../../../components';

export const Home: React.FC = () => {
  const [isClient, setIsClient] = useState(false);
  const [activeSlide, setActiveSlide] = useState(0);

  // Avoid hydration mismatch by rendering dynamic content only on client
  useEffect(() => {
    setIsClient(true);
  }, []);

  const {menu, menuLoading} = hooks.useGetMenu();
  const {dishes, dishesLoading} = hooks.useGetDishes();
  const {reviews, reviewsLoading} = hooks.useGetReviews();
  const {carousel, carouselLoading} = hooks.useGetCarousel();

  const isLoading =
    menuLoading || dishesLoading || reviewsLoading || carouselLoading;

  const handleSlideChange = (swiper: any) => {
    setActiveSlide(swiper.activeIndex);
  };

  const renderHeader = () => {
    return (
      <components.Header
        user={true}
        userName={true}
        showBasket={true}
      />
    );
  };

  const renderCategories = () => {
    if (!menu || menu.length === 0) {
      console.log('Menu data is empty or undefined');
      return null;
    }

    return (
      <section style={{marginBottom: 30}}>
        <components.BlockHeading
          title='We offer'
          className='container'
          containerStyle={{marginBottom: 14}}
        />
        <Swiper
          spaceBetween={10}
          slidesPerView={3.5}
          onSlideChange={() => {}}
          onSwiper={(swiper) => {}}
          style={{padding: '0 20px'}}
        >
          {menu.map((item) => (
            <SwiperSlide key={item.id}>
              <Link
                href={`${Routes.MENU_LIST}/all`}
                className='clickable'
                style={{position: 'relative'}}
              >
                {item.image && (
                  <Image
                    src={item.image}
                    alt={`Category image for ${item.name}`}
                    width={90}
                    height={90}
                    sizes='100vw'
                    priority={true}
                    style={{width: '100%', height: '100%', borderRadius: 10}}
                  />
                )}
                <span
                  style={{
                    position: 'absolute',
                    bottom: 10,
                    left: 15,
                    textAlign: 'center',
                    backgroundColor: 'var(--white-color)',
                    borderRadius: '0 0 10px 10px',
                    color: 'var(--main-dark)',
                  }}
                  className='t10 number-of-lines-1'
                >
                  {item.name}
                </span>
              </Link>
            </SwiperSlide>
          ))}
        </Swiper>
      </section>
    );
  };

  const renderCarousel = () => {
    if (!carousel || carousel.length === 0) {
      console.log('Carousel data is empty or undefined');
      return null;
    }

    return (
      <section style={{marginBottom: 30, position: 'relative'}}>
        <Swiper
          slidesPerView={'auto'}
          pagination={{clickable: true}}
          navigation={true}
          mousewheel={true}
          onSlideChange={handleSlideChange}
        >
          {carousel.map((banner, index) => {
            if (!dishes[index]) {
              console.log(`No dish found for index ${index}`);
              return null;
            }
            return (
              <SwiperSlide key={banner.id}>
                <Link href={`${Routes.MENU_ITEM}/${dishes[index].id}`}>
                  <Image
                    src={banner.banner || '/placeholder.jpg'}
                    alt={dishes[index]?.name ? `Featured dish banner for ${dishes[index].name}` : 'Featured dish banner'}
                    width={0}
                    height={0}
                    sizes='100vw'
                    priority={true}
                    className='clickable'
                    style={{width: '100%', height: 'auto'}}
                  />
                </Link>
              </SwiperSlide>
            );
          })}
        </Swiper>
        <div
          style={{
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            position: 'absolute',
            bottom: 27,
            zIndex: 1,
            width: '100%',
            gap: 6,
          }}
        >
          {carousel.map((_, index) => {
            return (
              <div
                key={_.id}
                style={{
                  width: 8,
                  height: activeSlide === index ? 20 : 8,
                  borderRadius: 10,
                  backgroundColor:
                    activeSlide === index
                      ? 'var(--white-color)'
                      : `rgba(255, 255, 255, 0.5)`,
                }}
              />
            );
          })}
        </div>
      </section>
    );
  };

  const renderRecommendedDishes = () => {
    if (!dishes || dishes.length === 0) {
      console.log('Dishes data is empty or undefined');
      return null;
    }

    const recommendedDishes = dishes.filter((dish) => dish.isRecommended);
    
    if (recommendedDishes.length === 0) {
      console.log('No recommended dishes found');
      return null;
    }

    return (
      <section style={{marginBottom: 30}}>
        <components.BlockHeading
          title='Recommended for you'
          className='container'
          containerStyle={{marginBottom: 14}}
        />
        <Swiper
          spaceBetween={14}
          slidesPerView={1.6}
          onSlideChange={() => {}}
          onSwiper={(swiper) => {}}
          style={{padding: '0 20px'}}
        >
          {recommendedDishes.map((dish) => (
            <SwiperSlide key={dish.id}>
              <items.RecommendedItem item={dish} />
            </SwiperSlide>
          ))}
        </Swiper>
      </section>
    );
  };

  const renderReviews = () => {
    return (
      <section style={{marginBottom: 20}}>
        <components.BlockHeading
          href={Routes.REVIEWS}
          title='Our Happy clients say'
          containerStyle={{marginLeft: 20, marginRight: 20, marginBottom: 14}}
        />
        <Swiper
          spaceBetween={14}
          slidesPerView={1.2}
          pagination={{clickable: true}}
          navigation={true}
          mousewheel={true}
          style={{padding: '0 20px'}}
        >
          {reviews.map((review: any) => {
            return (
              <SwiperSlide key={review.id}>
                <items.ReviewItem review={review} />
              </SwiperSlide>
            );
          })}
        </Swiper>
      </section>
    );
  };

  const renderContent = () => {
    if (isLoading) return null;
    return (
      <main
        className='scrollable'
        style={{paddingTop: 10, height: '100%'}}
      >
        {isClient && (
          <>
            {renderCarousel()}
            {renderCategories()}
            {renderRecommendedDishes()}
            {renderReviews()}
          </>
        )}
      </main>
    );
  };

  const renderLoader = () => {
    if (!isLoading) return null;

    return (
      <div
        style={{
          display: 'flex',
          justifyContent: 'center',
          alignItems: 'center',
          position: 'absolute',
          inset: 0,
          height: '100%',
        }}
        className='flex-center'
      >
        <PuffLoader
          size={40}
          color={'#455A81'}
          aria-label='Loading Spinner'
          data-testid='loader'
          speedMultiplier={1}
        />
      </div>
    );
  };

  const renderModal = () => {
    return <components.Modal />;
  };

  const renderBottomTabBar = () => {
    return <components.BottomTabBar />;
  };

  return (
    <components.Screen>
      {renderHeader()}
      {renderContent()}
      {renderModal()}
      {renderLoader()}
      {renderBottomTabBar()}
    </components.Screen>
  );
};
