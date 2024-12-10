/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.{php,html,js,jsx,ts,tsx,vue}",
    "./public/**/*.{php,html}",
    "./**/*.php",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#da963e',
        'secondary': '#040404',
      },
      animation: {
        'fade-in': 'fadeIn 0.2s ease-out',
        'fade-out': 'fadeOut 0.2s ease-in',
        'slide-down': 'slideDown 0.2s ease-out',
        'slide-up': 'slideUp 0.2s ease-in',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        fadeOut: {
          '0%': { opacity: '1' },
          '100%': { opacity: '0' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(0)', opacity: '1' },
          '100%': { transform: 'translateY(-10px)', opacity: '0' },
        },
      },
      boxShadow: {
        'dropdown': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
        'dropdown-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      },
      blur: {
        '4xl': '100px',
      },
      scale: {
        '102': '1.02',
      },
      transitionDuration: {
        '400': '400ms',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
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
    'animate-fade-in',
    'animate-fade-out',
    'animate-slide-down',
    'animate-slide-up',
    'shadow-dropdown',
    'shadow-dropdown-lg',
    'backdrop-blur-md',
    'backdrop-saturate-150',
    'ring-1',
    'ring-white/10',
  ]
}