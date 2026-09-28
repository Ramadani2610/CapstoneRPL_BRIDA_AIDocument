/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      colors: {
        maroon: {
          DEFAULT: '#7A161A',
          hover: '#611114',
        }
      }
    },
  },
  plugins: [],
}