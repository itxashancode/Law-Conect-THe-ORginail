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
    // shadcn/ui custom colors
    'bg-onyx-50', 'bg-onyx-100', 'bg-onyx-200', 'bg-onyx-300', 'bg-onyx-400', 'bg-onyx-500', 'bg-onyx-600', 'bg-onyx-700', 'bg-onyx-800', 'bg-onyx-900',
    'border-onyx-50', 'border-onyx-100', 'border-onyx-200', 'border-onyx-300', 'border-onyx-400', 'border-onyx-500', 'border-onyx-600', 'border-onyx-700', 'border-onyx-800', 'border-onyx-900',
    'text-onyx-50', 'text-onyx-100', 'text-onyx-200', 'text-onyx-300', 'text-onyx-400', 'text-onyx-500', 'text-onyx-600', 'text-onyx-700', 'text-onyx-800', 'text-onyx-900',
    'bg-gold-50', 'bg-gold-100', 'bg-gold-200', 'bg-gold-300', 'bg-gold-400', 'bg-gold-500', 'bg-gold-600', 'bg-gold-700', 'bg-gold-800', 'bg-gold-900',
    'border-gold-50', 'border-gold-100', 'border-gold-200', 'border-gold-300', 'border-gold-400', 'border-gold-500', 'border-gold-600', 'border-gold-700', 'border-gold-800', 'border-gold-900',
    'text-gold-50', 'text-gold-100', 'text-gold-200', 'text-gold-300', 'text-gold-400', 'text-gold-500', 'text-gold-600', 'text-gold-700', 'text-gold-800', 'text-gold-900',
    'bg-linen-50', 'bg-linen-100', 'bg-linen-200', 'bg-linen-300', 'bg-linen-400', 'bg-linen-500', 'bg-linen-600', 'bg-linen-700', 'bg-linen-800', 'bg-linen-900',
    'border-linen-50', 'border-linen-100', 'border-linen-200', 'border-linen-300', 'border-linen-400', 'border-linen-500', 'border-linen-600', 'border-linen-700', 'border-linen-800', 'border-linen-900',
    'text-linen-50', 'text-linen-100', 'text-linen-200', 'text-linen-300', 'text-linen-400', 'text-linen-500', 'text-linen-600', 'text-linen-700', 'text-linen-800', 'text-linen-900',
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
