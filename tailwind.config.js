module.exports = {
  darkMode: 'class',
  content: [
    './**/*.php',
    './assets/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        background: '#0F172A',
        foreground: '#F1F5F9',
        card: '#1E293B',
        'card-foreground': '#F1F5F9',
        primary: '#3B82F6',
        'primary-foreground': '#FFFFFF',
        secondary: '#334155',
        'secondary-foreground': '#E2E8F0',
        muted: '#334155',
        'muted-foreground': '#94A3B8',
        border: '#334155',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        mono: ['JetBrains Mono', 'monospace'],
      },
    },
  },
  plugins: [],
};