/** @type {import('tailwindcss').Config} */

export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        'main-gray-light': '#f3f4f6',
        'main-gray-dark': '#111827',
      }
    },
  },
  // darkMode: 'selector'
}
