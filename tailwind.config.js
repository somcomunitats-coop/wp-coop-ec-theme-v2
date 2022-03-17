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
    '../wp-coop-theme/*/*.php',
    '../wp-coop-theme/**/*.php',
    './*/*.php',
    './**/*.php',
    './resources/css/*.css',
    './resources/js/*.js',
    './safelist.txt'
  ],
  theme: {
    container: {
      padding: {
        DEFAULT: '1rem',
        sm: '2rem',
        lg: '0rem'
      },
    },
    extend: {
      colors: tailpress.colorMapper(get_variable_value('settings.color.palette')),
      fontSize: tailpress.fontSizeMapper(get_variable_value('settings.typography.fontSizes'))
    },
    screens: {
      'xs': '480px',
      'sm': '600px',
      'md': '782px',
      'lg': get_variable_value('settings.layout.contentSize'),
      'xl': get_variable_value('settings.layout.wideSize'),
      '2xl': '1440px'
    }
  },
  plugins: [
    tailpress.tailwind
  ]
};
