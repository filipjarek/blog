/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/**/*.html.twig',
    './node_modules/tw-elements/dist/js/**/*.js'
  ],
  darkMode: 'class',
  theme: {
    extend: {},
  },
  plugins: [
    require(
      'tw-elements/dist/plugin',
    ),
  ],
}