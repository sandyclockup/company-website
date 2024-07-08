const { defineConfig } = require('@vue/cli-service')
const Dotenv = require('dotenv-webpack')

module.exports = defineConfig({
  transpileDependencies: true,
  configureWebpack: {
    plugins: [
      new Dotenv()
    ]
  }
})

module.exports = {
  chainWebpack: config => {
    config.plugin("define").tap(args => {
      let _base = args[0]["process.env"];
      args[0]["process.env"] = {
        ..._base,
        'process.env.NODE_ENV' : JSON.stringify('production')
      };
      return args;
    });
  }
}