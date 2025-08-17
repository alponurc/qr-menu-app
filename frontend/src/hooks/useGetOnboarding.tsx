import axios from 'axios';
import {useState, useEffect} from 'react';
import debounce from 'lodash/debounce';

import {URLS} from '../config';

type OnboardingItem = {
  id: number;
  title1: string;
  title2: string;
  image: string;
  description1: string;
  description2: string;
};

// Mock data for fallback
const mockOnboarding: OnboardingItem[] = [
  {
    id: 1,
    title1: 'Hoş Geldiniz',
    title2: 'QR Menü',
    image: '/placeholder.jpg',
    description1: 'Dijital menü deneyimine',
    description2: 'hoş geldiniz'
  },
  {
    id: 2,
    title1: 'Kolay Sipariş',
    title2: 'Hızlı Servis',
    image: '/placeholder.jpg',
    description1: 'QR kodu okutun',
    description2: 'siparişinizi verin'
  }
];

export const useGetOnboarding = () => {
  const [onboarding, setOnboarding] = useState<OnboardingItem[]>([]);
  const [onboardingLoading, setOnboardingLoading] = useState(false);

  // Debounce the API call to prevent 429 errors
  const debouncedGetOnboarding = debounce(async () => {
    setOnboardingLoading(true);

    try {
      console.log('Trying to fetch onboarding from:', URLS.GET_ONBOARDING);
      if (!URLS.GET_ONBOARDING) {
        console.log('Onboarding URL is undefined, using mock data');
        setOnboarding(mockOnboarding);
        return;
      }

      const response = await axios.get(URLS.GET_ONBOARDING);
      if (response.data && Array.isArray(response.data.onboarding)) {
        setOnboarding(response.data.onboarding);
      } else {
        console.error('Invalid onboarding data format, using mock data');
        setOnboarding(mockOnboarding);
      }
    } catch (error) {
      console.error('Error fetching onboarding, using mock data:', error);
      setOnboarding(mockOnboarding);
    } finally {
      setOnboardingLoading(false);
    }
  }, 1000); // 1 second delay

  useEffect(() => {
    debouncedGetOnboarding();
    return () => {
      debouncedGetOnboarding.cancel();
    };
  }, []);

  return {onboardingLoading, onboarding};
};
