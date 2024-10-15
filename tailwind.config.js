module.exports = {
  content: [
    './app/**/*.php',
    './public/**/*.html',
    './public/**/*.js',
    './public/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  purge: {
    enabled: true,
    content: [
      './app/**/*.php',
      './public/**/*.html',
      './public/**/*.js',
      './public/**/*.php',
    ],
  },
}