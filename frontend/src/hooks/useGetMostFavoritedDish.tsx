import { useQuery } from '@tanstack/react-query';
import { fetchMostFavoritedDish } from '@/utils/api';
import { DishType } from '@/types/DishType';

export const useGetMostFavoritedDish = () => {
  return useQuery<DishType | null>({
    queryKey: ['most-favorited-dish'],
    queryFn: fetchMostFavoritedDish,
  });
};
