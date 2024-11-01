<?php

namespace xCORE\Yadore;

class TemplateLoader extends \Gamajo_Template_Loader
{
	/**
	 * Prefix for filter names.
	 *
	 * @var string
	 */
	protected $filter_prefix = 'yadore_widget';

	/**
	 * Directory name where templates should be found into the theme.
	 *
	 * @var string
	 */
	protected $theme_template_directory = 'yadore_widget';

	/**
	 * Current plugin's root directory.
	 *
	 * @var string
	 */
	protected $plugin_directory = YADORE_WIDGET_PATH;

	/**
	 * Directory name of where the templates are stored into the plugin.
	 *
	 * @var string
	 */
	protected $plugin_template_directory = 'templates';

}
