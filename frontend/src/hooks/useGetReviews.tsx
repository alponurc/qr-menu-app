import axios from 'axios';
import {useState, useEffect} from 'react';

import {URLS} from '../config';
import {ReviewType} from '../types';

// Mock data for fallback
const mockReviews: ReviewType[] = [
  {
    id: 1,
    user_name: "John Doe",
    rating: 5,
    comment: "Great food and service!",
    date: "2025-08-16",
    user_image: "/assets/other/01.png"
  },
  {
    id: 2,
    user_name: "Jane Smith",
    rating: 4,
    comment: "Really enjoyed the atmosphere",
    date: "2025-08-15",
    user_image: "/assets/other/02.png"
  }
];

export const useGetReviews = (): {
  reviewsLoading: boolean;
  reviews: ReviewType[];
} => {
  const [reviews, setReviews] = useState<ReviewType[]>([]);
  const [reviewsLoading, setReviewsLoading] = useState<boolean>(false);

  const getReviews = async () => {
    setReviewsLoading(true);

    try {
      console.log('Trying to fetch reviews from:', URLS.GET_REVIEWS);
      if (!URLS.GET_REVIEWS) {
        console.log('Reviews URL is undefined, using mock data');
        setReviews(mockReviews);
        return;
      }

      const response = await axios.get(URLS.GET_REVIEWS);
      setReviews(response.data.reviews);
    } catch (error) {
      console.log('Error fetching reviews, using mock data:', error);
      setReviews(mockReviews);
    } finally {
      setReviewsLoading(false);
    }
  };

  useEffect(() => {
    getReviews();
  }, []);

  return {reviewsLoading, reviews};
};
