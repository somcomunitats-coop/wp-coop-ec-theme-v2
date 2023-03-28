module.exports = {
  plugins: [
    require("postcss-import"),
    require("postcss-url")({
      url: 'inline'
    }),
    require("postcss-nested-ancestors"),
    require("postcss-nested"),
    require("tailwindcss"),
  ],
};

