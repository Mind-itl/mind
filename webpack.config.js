const webpack = require('webpack');
const fs = require('fs');

var entries = {};
fs.readdirSync("./js/entries").forEach(file => {
	var base = file.substr(0, file.length-3);
	entries[base] = "./js/entries/" + file;
})

module.exports = {
	mode: "development",
	entry: entries,
	output: {
		path: __dirname + "/public_html/dist/",
		filename: "[name].js"
	},
	plugins: [
		 new webpack.SourceMapDevToolPlugin({})
	],
	module: {
		rules: [
			{
				test: /\.m?js$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ["@babel/preset-env","@babel/preset-react"],
						plugins: ['@babel/plugin-proposal-object-rest-spread']
					}
				}
			}
		]
	}
}
