import axios from 'axios';
import { URLS } from '../constants/urls';

export const API = {
  // Auth
  login: (data: { email: string; password: string }) => 
    axios.post(URLS.LOGIN, data),

  // Menu
  getDishes: () => 
    axios.get(URLS.GET_DISHES),
  
  getCategories: () => 
    axios.get(URLS.GET_CATEGORIES),
  
  // Reviews
  getReviews: () => 
    axios.get(URLS.GET_REVIEWS),
  
  createReview: (data: { rating: number; comment: string }) => 
    axios.post(URLS.POST_REVIEW, data),
  
  // Notifications
  getNotifications: () => 
    axios.get(URLS.GET_NOTIFICATIONS),
  
  markNotificationAsRead: (id: number) => 
    axios.patch(`${URLS.GET_NOTIFICATIONS}/${id}/read`),
  
  // Orders
  createOrder: (data: any) => 
    axios.post(URLS.CREATE_ORDER, data),
  
  getOrders: () => 
    axios.get(URLS.GET_ORDERS),
  
  // Favorites
  addFavorite: (dishId: number) => 
    axios.post(URLS.ADD_FAVORITE(dishId)),
  
  getFavorites: () => 
    axios.get(URLS.GET_FAVORITES),
};
