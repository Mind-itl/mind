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
	]
}
