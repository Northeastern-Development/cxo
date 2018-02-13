const path = require('path');
const webpack = require('webpack');

module.exports = {
  entry: {
    main : ['babel-polyfill', path.resolve(__dirname, 'static/js/entry.js')]
  },
  resolve: {
    extensions: ['.js'],
    modules: [path.resolve(__dirname, 'static/js/modules'), path.resolve('node_modules')],
  },
  output: {
    path: path.resolve(__dirname, 'static/build/js'),
    publicPath: '/wp-content/themes/cxo-magazine-wp/static/build/js/',
    filename: '[name].js',
    chunkFilename: '[id].[chunkhash].js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        include: path.resolve( __dirname, 'static/js' )
      }
    ]
  },
  node: {
    fs: "empty" // avoids error messages
  },
  stats: {
    colors: true
  },
  devtool: 'source-map',
  plugins: [
    new webpack.EnvironmentPlugin({NODE_ENV: 'development'}),
    new webpack.optimize.UglifyJsPlugin({
    compress: {
      warnings: false
    },
    mangle: false
    }),
    new webpack.ProvidePlugin({
      jQuery: 'jquery',
      $: 'jquery',
      'window.jQuery': 'jquery',
      'window.$': 'jquery'
    })
  ]
};
