import { resolve } from 'path';
import react from '@vitejs/plugin-react';
import svgrPlugin from 'vite-plugin-svgr';
import symfonyPlugin from 'vite-plugin-symfony';

const config = {
  plugins: [
    react(),
    symfonyPlugin(),
    svgrPlugin({
      svgrOptions: {
        icon: true,
      },
      include: '**/*.svg?react',
    }),
  ],

  base: '/build/',

  build: {
    outDir: './public/build',
    emptyOutDir: true,

    rollupOptions: {
      input: {
        app: resolve(__dirname, 'assets/main.tsx'),
      },
    },

    manifest: true,
  },

  server: {
    host: 'localhost',
    port: 5173,
    origin: 'http://localhost:5173',
  },

  resolve: {
    alias: {
      '@': resolve(__dirname, 'assets'),
      '@General': resolve(__dirname, 'assets/General'),
      '@Portal': resolve(__dirname, 'assets/Portal'),
    },
  },

  // Указываем Vite использовать node_modules из корня
  cacheDir: './node_modules/.vite',
};

export default config;
