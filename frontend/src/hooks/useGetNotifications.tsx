import axios from 'axios';
import {useState, useEffect} from 'react';

import {URLS} from '../config';
interface NotificationType {
  id: number;
  title: string;
  message: string;
  date: string;
  read: boolean;
}

// Mock data for fallback
const mockNotifications: NotificationType[] = [
  {
    id: 1,
    title: "Special Offer",
    message: "20% off on all main dishes today!",
    date: "2025-08-16",
    read: false
  },
  {
    id: 2,
    title: "New Menu Items",
    message: "Check out our new seasonal dishes",
    date: "2025-08-15",
    read: true
  }
];

export const useGetNotifications = () => {
  const [notifications, setNotifications] = useState<NotificationType[]>([]);
  const [notificationsLoading, setNotificationsLoading] =
    useState<boolean>(false);

  const getNotifications = async () => {
    setNotificationsLoading(true);

    try {
      console.log('Trying to fetch notifications from:', URLS.GET_NOTIFICATIONS);
      if (!URLS.GET_NOTIFICATIONS) {
        console.log('Notifications URL is undefined, using mock data');
        setNotifications(mockNotifications);
        return;
      }

      const response = await axios.get(URLS.GET_NOTIFICATIONS);
      setNotifications(response.data.notifications);
    } catch (error) {
      console.log('Error fetching notifications, using mock data:', error);
      setNotifications(mockNotifications);
    } finally {
      setNotificationsLoading(false);
    }
  };

  useEffect(() => {
    getNotifications();
  }, []);

  return {notificationsLoading, notifications};
};
