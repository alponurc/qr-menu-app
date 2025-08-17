import axios from 'axios';
import {useState, useEffect} from 'react';

import {URLS} from '../config';
import {MenuType} from '../types';

// Import axios config
import '../config/axios';

// Mock data for categories
const mockMenu: MenuType[] = [
  {
    id: 1,
    name: 'Pizza',
    image: '/placeholder.jpg'
  },
  {
    id: 2,
    name: 'Pasta',
    image: '/placeholder.jpg'
  },
  {
    id: 3,
    name: 'Burger',
    image: '/placeholder.jpg'
  }
];

export const useGetMenu = (): {menuLoading: boolean; menu: MenuType[]} => {
  const [menu, setMenu] = useState<MenuType[]>([]);
  const [menuLoading, setMenuLoading] = useState<boolean>(false);

  const getMenu = async () => {
    setMenuLoading(true);

    try {
      console.log('Trying to fetch menu from:', URLS.GET_MENU);
      
      const response = await axios.get(URLS.GET_MENU);
      console.log('Menu API Response:', response.data);
      
      if (response.data) {
        const menuData = response.data.categories || response.data.menu || response.data;
        if (Array.isArray(menuData)) {
          setMenu(menuData);
        } else {
          console.error('Invalid menu data format, using mock data');
          setMenu(mockMenu);
        }
      } else {
        console.error('No menu data received, using mock data');
        setMenu(mockMenu);
      }
    } catch (error) {
      console.error('Error fetching menu:', error);
      console.log('Using mock menu data as fallback');
      setMenu(mockMenu);
    } finally {
      setMenuLoading(false);
    }
  };

  useEffect(() => {
    getMenu();
  }, []);

  return {menuLoading, menu};
};
