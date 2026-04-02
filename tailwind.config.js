/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  safelist: [
    // Onyx opacity variants
    'bg-onyx/5', 'bg-onyx/10', 'bg-onyx/20', 'bg-onyx/30', 'bg-onyx/40', 'bg-onyx/50', 'bg-onyx/60',
    'text-onyx/30', 'text-onyx/40', 'text-onyx/50', 'text-onyx/60', 'text-onyx/70',
    'border-onyx/5', 'border-onyx/10', 'border-onyx/20',
    // Gold opacity variants
    'bg-gold-500/30', 'bg-gold-500/50',
    // Group hover variants
    'group-hover:bg-onyx/20',
    // Also ensure base colors are generated
    'bg-linen', 'text-onyx', 'bg-onyx', 'bg-gold-500', 'text-gold-500', 'border-gold-500',
  ],
  theme: {
    extend: {
      colors: {
        'onyx': '#0D0D0D', // Deep, rich black
        'obsidian': '#1A1A1A', // Slightly lighter black
        'gold': {
          50: '#FDFCF6',
          100: '#FAF8ED',
          200: '#F1EACE',
          300: '#E7D9A1',
          400: '#DCC36A',
          500: '#D4AF37', // Classic Gold
          600: '#B8860B', // Dark Gold
          700: '#916A09',
          800: '#6E5107',
          900: '#4A3705',
          glow: 'rgba(212, 175, 55, 0.4)',
        },
        'linen': '#F9F7F2', // Warm paper-like background
        'ash': '#4F4F4F',
        'clay': '#8E8E8E',
        'silver': '#E0E0E0',
      },
      fontFamily: {
        'serif': ['"Instrument Serif"', '"Playfair Display"', 'serif'],
        'sans': ['"Outfit"', '"Inter"', 'sans-serif'],
        'display': ['"Cormorant Garamond"', 'serif'],
      },
      borderRadius: {
        'super': '2rem',
        'bespoke': '1.25rem',
      },
      boxShadow: {
        'premium': '0 25px 50px -12px rgba(0, 0, 0, 0.5)',
        'luxury': '0 10px 30px -5px rgba(212, 175, 55, 0.15), 0 0 0 1px rgba(212, 175, 55, 0.05)',
        'inner-light': 'inset 0 1px 1px 0 rgba(255, 255, 255, 0.1)',
      },
      letterSpacing: {
        'ultra': '0.15em',
        'tightest': '-0.04em',
      },
      transitionTimingFunction: {
        'expo': 'cubic-bezier(0.87, 0, 0.13, 1)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
