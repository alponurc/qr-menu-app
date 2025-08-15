// frontend/src/utils/api.ts

const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL || 'http://127.0.0.1:8000/api';

export const addFavorite = async (dishId: number) => {
  try {
    const response = await fetch(`${API_BASE_URL}/dishes/${dishId}/favorite`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error('Failed to update favorite');
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error('API Error:', error);
    throw error;
  }
};

export const fetchMostFavoritedDish = async () => {
  const res = await fetch(`${API_BASE_URL}/dishes/most-favorited`);
  if (!res.ok) throw new Error('Failed to fetch most favorited dish');
  return res.json();
};

export const fetchShowMostFavoritedSetting = async () => {
  const res = await fetch(`${API_BASE_URL}/settings/show-most-favorited-dish`);
  if (!res.ok) throw new Error('Failed to fetch setting');
  return res.json();
};

// utils/api.ts

export const fetchCategories = async () => {
  const response = await fetch(`${API_BASE_URL}/categories`);
  if (!response.ok) throw new Error('Failed to fetch categories');
  return response.json();
};
