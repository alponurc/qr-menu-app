# QR Menu Project

A modern QR menu system built with Laravel (Backend) and Next.js (Frontend).

## Project Structure

```
qr-menu-project/
├── backend/         # Laravel API
│   ├── app/
│   ├── routes/
│   └── database/
└── frontend/        # Next.js Application
    ├── src/
    │   ├── pages/
    │   ├── components/
    │   └── services/
    └── public/
```

## Features

- 🍽 Dynamic menu management
- 💝 Favorite dishes system
- 📱 Responsive design
- 🔍 Search functionality
- 📊 Admin dashboard
- 📈 Analytics for most favorited items

## Tech Stack

- **Backend**
  - Laravel 10
  - MySQL
  - PHP 8.1+
  - Laravel Sanctum for authentication

- **Frontend**
  - Next.js 13+
  - React 18
  - TypeScript
  - Zustand for state management
  - Axios for API requests

## Getting Started

### Prerequisites

- PHP 8.1+
- Node.js 16+
- MySQL

### Backend Setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend Setup

```bash
cd frontend
npm install
cp .env.example .env.local
npm run dev
```

## API Endpoints

### Dishes
- `GET /api/dishes` - Get all dishes
- `GET /api/dishes/{id}` - Get specific dish
- `POST /api/dishes/{id}/favorite` - Toggle favorite status

### Categories
- `GET /api/categories` - Get all categories
- `GET /api/categories/{id}/dishes` - Get dishes in category

### Settings
- `GET /api/settings` - Get application settings

## Development Notes

For Copilot assistance:

1. **API Service Functions**
```typescript
// src/services/api.ts
import axios from 'axios';

export const getDishes = () => 
  axios.get('/api/dishes').then(res => res.data);

export const toggleFavorite = (dishId: number) => 
  axios.post(`/api/dishes/${dishId}/favorite`);
```

2. **State Management**
```typescript
// src/stores/favorites.ts
import create from 'zustand';

interface FavoriteStore {
  favorites: number[];
  addFavorite: (id: number) => void;
  removeFavorite: (id: number) => void;
}

export const useFavoriteStore = create<FavoriteStore>((set) => ({
  favorites: [],
  addFavorite: (id) => set((state) => ({
    favorites: [...state.favorites, id]
  })),
  removeFavorite: (id) => set((state) => ({
    favorites: state.favorites.filter(fid => fid !== id)
  }))
}));
```

3. **Grid Component Example**
```typescript
// src/components/DishGrid.tsx
export const DishGrid = ({ dishes }) => {
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      {dishes.map(dish => (
        <DishCard key={dish.id} dish={dish} />
      ))}
    </div>
  );
};
```

4. **Most Favorited Display**
```typescript
// src/components/TopDish.tsx
export const TopDish = ({ dish }) => {
  return (
    <div className="featured-dish-card">
      <h3>Most Favorited Dish</h3>
      <img src={dish.image} alt={dish.name} />
      <h4>{dish.name}</h4>
      <p>{dish.favorites_count} favorites</p>
    </div>
  );
};
```

## Environment Variables

### Backend (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qr_menu
DB_USERNAME=root
DB_PASSWORD=

FEATURED_DISH_MIN_FAVORITES=10
```

### Frontend (.env.local)
```
NEXT_PUBLIC_API_URL=http://localhost:8000/api
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## License

MIT License
