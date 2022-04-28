const _ = require("lodash");
const theme = require('./theme.json');
const tailpress = require("@jeffreyvr/tailwindcss-tailpress");
const parent_theme = require('../wp-coop-theme/theme.json');
const parent_tailwind_config = require('../wp-coop-theme/tailwind.config.js');

function get_variable_value(variable){
  value = tailpress.theme(variable, theme);
  if(value){
    return value;
  }else{
    value = tailpress.theme(variable, parent_theme);
    if(value){
      return value;
    }
  }
  return false;
}

module.exports = {
  content: [
    '../wp-coop-theme/*/*.html',
    '../wp-coop-theme/**/*.html',
    './*/*.html',
    './**/*.html',
    './resources/css/*.css',
    './resources/js/*.js',
    './safelist.txt'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    tailpress.tailwind
  ]
};
