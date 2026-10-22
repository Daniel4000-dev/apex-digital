/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./template-parts/**/*.php",
    "./assets/src/js/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        ivory: '#F3F0E8',
        ink: {
          DEFAULT: '#202720',
          50: '#f6f7f6',
          100: '#e7eae7',
          200: '#d1d8d1',
          300: '#b0bcb0',
          400: '#899989',
          500: '#687768',
          600: '#505d50',
          700: '#404a40',
          800: '#202720',
          900: '#171c17',
        },
        cobalt: {
          DEFAULT: '#2649E7',
          50: '#eef2ff',
          100: '#e0e7ff',
          200: '#c7d2fe',
          300: '#a5b4fc',
          400: '#818cf8',
          500: '#2649E7',
          600: '#1d3bc2',
          700: '#172fa0',
          800: '#13247c',
          900: '#101c5f',
        },
        coral: {
          DEFAULT: '#FF7848',
          50: '#fff5f2',
          100: '#ffe8e1',
          200: '#ffd0c3',
          300: '#ffad99',
          400: '#ff7848',
          500: '#e85c2c',
          600: '#cb4115',
          700: '#a8300d',
        },
        lime: {
          DEFAULT: '#E0EF9E',
          50: '#fbfdf5',
          100: '#f5fae6',
          200: '#ecf6cc',
          300: '#e0ef9e',
          400: '#cfe56e',
          500: '#b4d13e',
          600: '#91ab2b',
        },
        agency: {
          50: '#eef2ff',
          100: '#e0e7ff',
          200: '#c7d2fe',
          300: '#a5b4fc',
          400: '#818cf8',
          500: '#2649E7',
          600: '#1d3bc2',
          700: '#172fa0',
          800: '#13247c',
          900: '#101c5f',
          950: '#0a1033',
        },
        accent: {
          50: '#fff5f2',
          100: '#ffe8e1',
          200: '#ffd0c3',
          300: '#ffad99',
          400: '#ff7848',
          500: '#e85c2c',
          600: '#cb4115',
          700: '#a8300d',
        },
        dark: {
          900: '#171c17',
          800: '#202720',
          700: '#313b31',
          600: '#4b574b',
        }
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', '-apple-system', 'sans-serif'],
        serif: ['Georgia', 'Cambria', '"Times New Roman"', 'serif'],
        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
      },
      boxShadow: {
        'soft': '0 4px 20px -2px rgba(32, 39, 32, 0.05)',
        'poster': '0 20px 40px -15px rgba(32, 39, 32, 0.12)',
        'card': '0 2px 10px 0 rgba(32, 39, 32, 0.04)',
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

