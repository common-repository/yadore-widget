<?php
/**
 * Plugin Name:       Yadore Widget
 * Description:       Beste E-Commerce-Daten aus einer Quelle – vereinfacht und optimiert für Publisher und Advertiser
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Version:           1.3
 * Author:            Yadore GmbH
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       yadore-widget
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( !defined( 'YADORE_WIDGET_VERSION' ) ) {
	define( 'YADORE_WIDGET_VERSION', '1.3' );
}
if ( !defined( 'YADORE_WIDGET_PATH' ) ) {
	define( 'YADORE_WIDGET_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'YADORE_WIDGET_URL' ) ) {
	define( 'YADORE_WIDGET_URL', plugin_dir_url( __FILE__ ) );
}

require YADORE_WIDGET_PATH . 'vendor/autoload.php';
require YADORE_WIDGET_PATH . 'lib/helper.php';
require YADORE_WIDGET_PATH . 'lib/Integration/Gutenberg/_load.php';

new \xCORE\Yadore\Register();
