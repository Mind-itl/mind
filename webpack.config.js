var webpack = require('webpack');

module.exports = {
	mode: "development",
	entry: {
		profile: "./js/entries/profile.js"
	},
	output: {
		path: __dirname + "/public_html/dist/",
		filename: "[name].js"
	},
	plugins: [
		 new webpack.SourceMapDevToolPlugin({})
	]
}
