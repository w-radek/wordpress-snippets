const path = require('path'),
    webpack = require('webpack'),
    MiniCssExtractPlugin = require("mini-css-extract-plugin"),
    // BrowserSyncPlugin = require('browser-sync-webpack-plugin'),
    VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = (env, argv) => {
    return {
        mode: 'development',
        entry: {
            app: ['babel-polyfill', './src/js/app.js'],
        },
        output: {
            filename: '[name].min.js',
            path: path.resolve(__dirname, 'public/js')
        },
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                        loaders: {
                            js: 'babel-loader'
                        }
                    }
                },
                {
                    test: /\.svg$/,
                    loader: 'svg-inline-loader'
                },
                {
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
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
                                url: false,
                            }
                        },
                        {
                            loader: "sass-loader",
                        }
                    ]
                },
                {
                    test: /\.css$/,
                    use: [
                    'vue-style-loader',
                    {
                        loader: 'css-loader',
                        options: {
                            // enable CSS Modules
                            modules: true,
                            // customize generated class names
                            localIdentName: '[local]_[hash:base64:8]'
                        }
                    }
                    ]
                }
            ]
        },
        plugins: [
            new VueLoaderPlugin(),
            new MiniCssExtractPlugin({
                filename: "../css/[name].min.css",
            }),
            // new BrowserSyncPlugin({
            //     // browse to http://localhost:3000/ during development
            //     host: 'localhost',
            //     port: 3000,
            //     // proxy the Webpack Dev Server endpoint
            //     // (which should be serving on http://localhost:3100/)
            //     // through BrowserSync
            //     proxy: 'dra.localhost',
            //     files: ["*"],
            //     reloadDelay: 1000
            // }),
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery'
            }),
        ],
        resolve: {
            alias: {
                vue: 'vue/dist/vue.js'
            }
        }
    }
}