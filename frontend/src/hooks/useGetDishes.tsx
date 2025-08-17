import axios from 'axios';
import {useState, useEffect} from 'react';

import {URLS} from '../config';
import {DishType} from '../types';

// Import axios config
import '../config/axios';

// Mock data for fallback
const mockDishes: DishType[] = [
  {
    id: 1,
    name: 'Pizza Margherita',
    description: 'Classic Italian pizza with tomatoes and mozzarella',
    price: '12.99',
    image: '/placeholder.jpg',
    kcal: '250',
    weight: '300g',
    menu: ['pizza'],
    isRecommended: true
  },
  {
    id: 2,
    name: 'Spaghetti Carbonara',
    description: 'Traditional pasta with eggs and pecorino cheese',
    price: '10.99',
    image: '/placeholder.jpg',
    kcal: '400',
    weight: '250g',
    menu: ['pasta'],
    isRecommended: true
  }
];

export const useGetDishes = () => {
  const [dishes, setDishes] = useState<DishType[]>([]);
  const [dishesLoading, setDishesLoading] = useState<boolean>(false);

  const getDishes = async () => {
    setDishesLoading(true);

    try {
      console.log('Trying to fetch dishes from:', URLS.GET_DISHES);
      
      const response = await axios.get(URLS.GET_DISHES);
      console.log('API Response:', response.data);
      
      if (response.data) {
        // Backend'den gelen data formatını kontrol et
        const dishesData = response.data.products || response.data.dishes || response.data;
        if (Array.isArray(dishesData)) {
          setDishes(dishesData);
        } else {
          console.error('Invalid dishes data format, using mock data');
          setDishes(mockDishes);
        }
      } else {
        console.error('No data received, using mock data');
        setDishes(mockDishes);
      }
    } catch (error) {
      console.error('Error fetching dishes:', error);
      console.log('Using mock data as fallback');
      setDishes(mockDishes);
    } finally {
      setDishesLoading(false);
    }
  };

  useEffect(() => {
    getDishes();
  }, []);

  return {dishesLoading, dishes};
};
