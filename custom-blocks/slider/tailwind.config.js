const _ = require("lodash");
const tailpress = require("@jeffreyvr/tailwindcss-tailpress");

module.exports = {
  content: [
    '../wp-coop-theme/*/*.html',
    '../wp-coop-theme/**/*.html',
    './*/*.html',
    './**/*.html',
    './assets/css/*.css',
    './assets/js/*.js',
    './safelist.txt'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    tailpress.tailwind
  ]
}