const Webpack = require('webpack');
const Path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');
const PATHS = {
  MODULES: Path.resolve('node_modules'),
  FILES_PATH: '../',
  ROOT: Path.resolve(),
  SRC: Path.resolve('client/src'),
  DIST: Path.resolve('client/dist')
};

module.exports = {
    entry: {
      bundlejs: [
        `${PATHS.MODULES}/tingle.js/src/tingle.js`,
        `${PATHS.SRC}/js/systemmessages.js`
      ],
      bundlecss: [
          `${PATHS.SRC}/styles/systemmessages.css`
      ],
    },
    output: {
      path: PATHS.DIST,
      filename: 'js/[name].js',
      publicPath: PATHS.DIST
    },
    target: ['web', 'es5'],
    module: {
        rules: [
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin(
            {
                filename: `styles/[name].css`,
                chunkFilename: `styles/[id].css`,
            }
        ),
        new ESLintPlugin({
            files: ['dist/js/*.js'],
        })
    ]
};