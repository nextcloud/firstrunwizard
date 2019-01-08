const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;


module.exports = merge(common, {
	mode: 'development',
	devServer: {
		historyApiFallback: true,
		noInfo: true,
		overlay: true
	},
	devtool: 'source-map',
	plugins: [
		//new BundleAnalyzerPlugin()
	]
});
