const { VueLoaderPlugin } = require('vue-loader')
const path = require('path')

module.exports = {
  entry: './src/main.js',
  output: {
    path: path.resolve(__dirname, './js'),
    filename: 'main.js',
  },
  module: {
    rules: [
      { test: /\.vue$/, loader: 'vue-loader' },
      { test: /\.js$/, loader: 'babel-loader', exclude: /node_modules/ },
      { test: /\.css$/, use: ['style-loader', 'css-loader'] }
    ]
  },
  plugins: [new VueLoaderPlugin()],
  resolve: {
    alias: { vue$: 'vue/dist/vue.esm.js' },
    extensions: ['*', '.js', '.vue', '.json']
  }
}