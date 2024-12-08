/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.{php,html,js,jsx,ts,tsx,vue}",
    "./public/**/*.{php,html}",
    "./**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#da963e',
        'secondary': '#040404',
      },
    },
  },
  plugins: [],
  safelist: [
    'flag-icon',
    'flag-icon-tr',
    'flag-icon-gb',
    'flag-icon-de',
    'flag-icon-fr',
    'flag-icon-it',
    'flag-icon-es',
    'rotate-180',
    'scale-95',
    'scale-100',
    '[x-cloak]',
    'hidden',
    'opacity-0',
    'opacity-100',
    'translate-y-0',
    '-translate-y-2',
    'overflow-hidden',
    'backdrop-blur-sm',
    'translate-x-full',
    '-translate-x-full',
  ]
}