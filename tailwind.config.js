/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        parchment: '#F5F2EB',
        gold: {
          DEFAULT: '#B8860B',
          dark: '#9A6F00',
        },
        ink: {
          DEFAULT: '#1A1A1A',
          mid: '#4A4A4A',
          muted: '#8A8A8A',
        },
        warm: {
          border: '#E0D9CC',
          surface: '#FFFFFF',
        },
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'serif'],
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        none: '0px',
        DEFAULT: '0px',
      },
      transitionTimingFunction: {
        'out-cubic': 'cubic-bezier(0.33, 1, 0.68, 1)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
