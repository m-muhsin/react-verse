var ExtractTextPlugin = require("extract-text-webpack-plugin");
var path = require('path');

module.exports = {
    entry: {
        app: './src/index.jsx'
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: '[name].js'
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: ExtractTextPlugin.extract({
                    fallback: 'style-loader',
                    use: ['css-loader','sass-loader'],
                    publicPath: 'build'
                })
            },
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                use: 'babel-loader'
            }
        ]
    },
    resolve: {
        extensions: ['.js', '.jsx']
    },
    plugins: [
        new ExtractTextPlugin({
            filename: "style.css",
            allChunks: true
        })
    ]
}