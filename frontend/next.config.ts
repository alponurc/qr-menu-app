// import type {NextConfig} from 'next';

// const withPWA = require('@ducanh2912/next-pwa').default({
//   dest: 'public',
// });

// const nextConfig: NextConfig = {
//   reactStrictMode: true,

//   images: {
//     domains: ['george-fx.github.io'],
//   },
// };

// module.exports = withPWA(nextConfig);
import type { NextConfig } from 'next';

const withPWA = require('@ducanh2912/next-pwa').default({
  dest: 'public',
});

const nextConfig: NextConfig = {
  reactStrictMode: true,
  images: {
    domains: ['127.0.0.1'], // Laravel API'den resim yükleyebilmek için bu eklendi
  },
};

module.exports = withPWA(nextConfig);
