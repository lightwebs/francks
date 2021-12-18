/* eslint-disable */
const webpack = require('webpack');
const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const fs = require('fs');

// Make sure any symlinks in the project folder are resolved:
// https://github.com/facebookincubator/create-react-app/issues/637
const appDirectory = fs.realpathSync(process.cwd());

function resolveApp(relativePath) {
	return path.resolve(appDirectory, relativePath);
}

const paths = {
	appSrc: resolveApp(''),
    appBuild: resolveApp('dist'),
    appBuildChunk: resolveApp('dist/js/'),
    appIndexJs: resolveApp('src/js/index.js'),
    appNodeModules: resolveApp('node_modules')
};

module.exports = {
    // watch: true,
    // mode: 'development',
    entry: [paths.appIndexJs],
	output: {
    path: path.resolve(__dirname, 'dist'),
    filename: '[name].[contenthash].js'
  },
  externals: {
    jquery: 'jQuery'
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
            MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              importLoaders: 1
            }
          },
          'postcss-loader'
        ]
      },
      {
        test: /\.js$/,
        use: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'sass-loader'
        ]
      },
      {
        test: /\.(png|jpg|gif|ttf|eot|woff|woff2|svg)$/i,
        type: 'asset'
      },
    ]
  },
  plugins: [
    new BrowserSyncPlugin({
        notify: false,
        host: 'localhost',
        port: 4000,
        logLevel: 'debug',
        // files: ['./**/*.php'],
        proxy: 'http://localhost/francks'
    },
    {
        reload: false
    }),
    new MiniCssExtractPlugin(),
    new CleanWebpackPlugin(),
  ],
  optimization: {
    // runtimeChunk: 'single',
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /[\\/]node_modules[\\/]/,
          name: 'vendors',
          chunks: 'all'
        }
      }
    }
  }
};