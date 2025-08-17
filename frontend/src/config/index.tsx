const PROJECT_NAME = 'dinehub';

// Use environment variable with fallback
const LOCAL_API = process.env.NEXT_PUBLIC_API_BASE_URL || 'http://127.0.0.1:8001/api';

// Fallback API for development/testing
const FALLBACK_API = 'https://george-fx.github.io/APIs/dinehub';

export const URLS = {
  MAIN_URL: LOCAL_API,
  GET_MENU: `${LOCAL_API}/categories`,              // Kategorileri getirir
  GET_DISHES: `${LOCAL_API}/products`,              // Ürünleri getirir
  GET_ORDERS: `${LOCAL_API}/orders`,                // (İstersen eklenebilir)
  GET_REVIEWS: `${LOCAL_API}/reviews`,              // (Varsa)
  GET_CAROUSEL: `${LOCAL_API}/slides`,              // Ana sayfa slider verileri
  GET_PROMOCODES: `${LOCAL_API}/promocodes`,        // İndirim kodları
  GET_ONBOARDING: `${LOCAL_API}/onboarding`,        // Giriş ekranı verisi
  GET_NOTIFICATIONS: `${LOCAL_API}/notifications`,  // Bildirim verisi
};


// const MAIN_URL = `https://george-fx.github.io/APIs/${PROJECT_NAME}`;


// const GET_MENU = `${MAIN_URL}/api/menu.json`;
// const GET_DISHES = `${MAIN_URL}/api/dishes.json`;
// const GET_ORDERS = `${MAIN_URL}/api/orders.json`;
// const GET_REVIEWS = `${MAIN_URL}/api/reviews.json`;
// const GET_CAROUSEL = `${MAIN_URL}/api/carousel.json`;
// const GET_ONBOARDING = `${MAIN_URL}/api/onboarding.json`;
// const GET_PROMOCODES = `${MAIN_URL}/api/promocodes.json`;
// const GET_NOTIFICATIONS = `${MAIN_URL}/api/notifications.json`;

// export const URLS = {
//   MAIN_URL,
//   GET_MENU,
//   GET_DISHES,
//   GET_ORDERS,
//   GET_REVIEWS,
//   GET_CAROUSEL,
//   GET_PROMOCODES,
//   GET_ONBOARDING,
//   GET_NOTIFICATIONS,
// };
