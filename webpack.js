const webpackConfig = require('@nextcloud/webpack-vue-config')
const webpackRules = require('@nextcloud/webpack-vue-config/rules')

// Don't inline scss urls
const cssLoaderIndex = webpackRules.RULE_SCSS.use.findIndex(rule => rule === 'css-loader')
webpackRules.RULE_SCSS.use[cssLoaderIndex] = {
	loader: 'css-loader',
	options: {
		url: false,
	},
}

webpackConfig.module.rules = Object.values(webpackRules)
webpackConfig.output.clean = false

module.exports = webpackConfig
