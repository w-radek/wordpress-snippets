const   path = require('path'),
        webpack = require('webpack'),
        MiniCssExtractPlugin = require("mini-css-extract-plugin"),
        OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin'),
        BrowserSyncPlugin = require('browser-sync-webpack-plugin'),
        VueLoaderPlugin = require('vue-loader/lib/plugin'),
        UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    mode: 'development',
    
    entry: {
        app: ['babel-polyfill', './src/js/app.js'],
    },
    
    output: {
        path: path.resolve( __dirname, 'public/js' ),
        filename: '[name].min.js',
    },
    
    devtool: 'inline-source-map',
    
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: "css-loader",
                        options: {
                            url: false
                        }
                    },
                    {
                        loader: "sass-loader",
                    }
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {
                        js: 'babel-loader',
                    },
                }
            }
        ]
    },
    
    plugins: [
        new VueLoaderPlugin(),
        new OptimizeCssAssetsPlugin(),
        new UglifyJsPlugin(),
        new MiniCssExtractPlugin({
            filename: "../css/app.min.css",
        }),
        new BrowserSyncPlugin({
            // browse to http://localhost:3000/ during development
            host: 'localhost',
            port: 8080,
            // proxy the Webpack Dev Server endpoint
            // (which should be serving on http://localhost:3100/)
            // through BrowserSync
            proxy: 'http://dra.localhost/',
            files: ["*"],
            reloadDelay: 1000  
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.js'
        }
    }
}