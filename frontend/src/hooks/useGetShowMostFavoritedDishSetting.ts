// src/hooks/useGetShowMostFavoritedDishSetting.ts
import { useQuery } from '@tanstack/react-query';

const fetchSetting = async (): Promise<{ show_most_favorited_dish: boolean }> => {
  const response = await fetch('http://127.0.0.1:8000/api/settings/show-most-favorited-dish');
  if (!response.ok) throw new Error('Failed to fetch setting');
  return response.json();
};

export const useGetShowMostFavoritedDishSetting = () => {
  return useQuery({
    queryKey: ['show-most-favorited-dish-setting'],
    queryFn: fetchSetting,
  });
};
