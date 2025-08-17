export const URLS = {
  // Authentication
  LOGIN: '/api/auth/login',
  REGISTER: '/api/auth/register',
  
  // Menu items
  GET_DISHES: '/api/dishes',
  GET_CATEGORIES: '/api/categories',
  GET_MENU: '/api/menu',
  
  // Reviews
  GET_REVIEWS: '/api/reviews',
  POST_REVIEW: '/api/reviews',
  
  // Carousel and banners
  GET_CAROUSEL: '/api/slides',
  GET_BANNERS: '/api/banners',
  
  // User related
  GET_USER_PROFILE: '/api/user/profile',
  UPDATE_USER_PROFILE: '/api/auth/user/update',
  
  // Orders
  GET_ORDERS: '/api/orders',
  CREATE_ORDER: '/api/order/create',
  
  // Promotions
  GET_PROMOCODES: '/api/promocodes',
  GET_DISCOUNT: '/api/discount',
  
  // App content
  GET_ONBOARDING: '/api/onboarding',
  GET_NOTIFICATIONS: '/api/notifications',
  
  // Favorites
  ADD_FAVORITE: (id: number) => `/api/dishes/${id}/favorite`,
  GET_FAVORITES: '/api/dishes/favorites'
};
