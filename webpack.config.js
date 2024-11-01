const defaultConfig = require('./node_modules/@wordpress/scripts/config/webpack.config');
const path = require('path');
const IgnoreEmitPlugin = require('ignore-emit-webpack-plugin');
const MiniCSSExtractPlugin = require('mini-css-extract-plugin');
const isProduction = true;
const mode = isProduction ? 'production' : 'development';

const gutenbergFiles = {
	'scripts': path.resolve(process.cwd(), 'lib/Integration/Gutenberg/assets/js', 'editor.js'),
};
const jsFiles = {
	'scripts': path.resolve(process.cwd(), 'src/js', 'scripts.js'),
};
const scssFiles = {
	'styles': path.resolve(process.cwd(), 'src/scss', 'styles.scss'),
};

module.exports = [
	// Gutenberg JavaScript minification
	{
		...defaultConfig,
		mode: mode,
		entry: gutenbergFiles,
		output: {
			filename: 'editor.min.js',
			path: path.resolve(process.cwd(), 'lib/Integration/Gutenberg/assets/js/dist'),
		}
	},

	// Default JavaScript minification
	{
		mode: mode,
		devtool: !isProduction ? 'source-map' : 'hidden-source-map',
		entry: jsFiles,
		output: {
			filename: '[name].min.js',
			path: path.resolve(process.cwd(), 'assets/js'),
		},
		optimization: {
			minimize: true,
			minimizer: defaultConfig.optimization.minimizer,
		},
	},

	// compiled + minified CSS file
	{
		mode: mode,
		devtool: !isProduction ? 'source-map' : 'hidden-source-map',
		entry: scssFiles,
		output: {
			path: path.resolve(process.cwd(), 'assets/css'),
		},
		module: {
			rules: [
				{
					test: /\.(sc|sa)ss$/,
					use: [
						MiniCSSExtractPlugin.loader,
						{
							loader: 'css-loader',
							options: {
								sourceMap: !isProduction,
								url: false,
							}
						},
						{
							loader: 'sass-loader',
							options: {
								sourceMap: !isProduction,
								sassOptions: {
									minimize: true,
									outputStyle: 'compressed',
								}
							}
						},
					],
				},
			],
		},
		plugins: [
			new MiniCSSExtractPlugin({filename: '[name].min.css'}),
			new IgnoreEmitPlugin(['.js']),
		],
	},
];
