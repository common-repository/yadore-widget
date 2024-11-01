<?php

namespace xCORE\Yadore;

use xCORE\Yadore\Panels\Settings;

class Register
{
	public function __construct()
	{
		new \xCORE\Yadore\Feed\Register();
		new \xCORE\Yadore\Search\Register();
		new \xCORE\Yadore\PriceCompare\Register();
		new Settings();

		add_action( 'wp_head', [ &$this, 'define_ajaxurl' ] );
		add_action( 'wp_enqueue_scripts', [ &$this, 'load_scripts' ] );
		add_filter( 'body_class', [ &$this, 'body_classes' ] );
		add_action( 'wp_head', [ &$this, 'css_variables' ], 999 );
	}

	public function define_ajaxurl()
	{
		?>
		<script type="text/javascript">
			var yw_ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
		</script>
		<?php
	}

	public function load_scripts()
	{
		wp_enqueue_script( 'yadore-widget-js', YADORE_WIDGET_URL . 'assets/js/scripts.min.js', [ 'jquery' ], YADORE_WIDGET_VERSION );
		wp_enqueue_style( 'yadore-widget-css', YADORE_WIDGET_URL . 'assets/css/styles.min.css', '', YADORE_WIDGET_VERSION );
	}

	public function body_classes( $classes )
	{
		$settings = get_option( 'yadore_widget_general' );
		$template = $settings['template'];

		if ( $template ) {
			$classes[] = 'yw-theme-' . sanitize_html_class( $template );
		}

		return $classes;
	}

	public function css_variables()
	{
		$colorSettings  = get_option( 'yadore_widget_colors' ) ?: [];
		$layoutSettings = get_option( 'yadore_widget_layout' ) ?: [];

		$vars         = [];
		$text         = isset( $colorSettings['text'] ) ? $colorSettings['text'] : '';
		$textMuted    = isset( $colorSettings['text_muted'] ) ? $colorSettings['text_muted'] : '';
		$headline     = isset( $colorSettings['headline'] ) ? $colorSettings['headline'] : '';
		$primary      = isset( $colorSettings['primary'] ) ? $colorSettings['primary'] : '';
		$borderRadius = isset( $layoutSettings['border_radius'] ) ? $layoutSettings['border_radius'] : '';
		$cardStyle    = isset( $layoutSettings['card_style'] ) ? $layoutSettings['card_style'] : 'shadow';
		$cardHover    = isset( $layoutSettings['card_hover'] ) ? $layoutSettings['card_hover'] : '';

		if ( $text ) {
			$vars['--yw-text-color'] = $text;
			$vars['--yw-card-color'] = $text;
		}

		if ( $textMuted ) {
			$vars['--yw-text-muted-color']                  = $textMuted;
			$vars['--yw-color-secondary']                   = $textMuted;
			$vars['--yw-button-background-secondary']       = $textMuted;
			$vars['--yw-button-background-secondary-hover'] = $this->scss_colors_adjust( $textMuted, -0.15 );
		}

		if ( $headline ) {
			$vars['--yw-headings-color'] = $headline;
		}

		if ( $primary ) {
			$vars['--yw-color-primary']                   = $primary;
			$vars['--yw-link-color']                      = $primary;
			$vars['--yw-button-background-primary']       = $primary;
			$vars['--yw-link-hover-color']                = $this->scss_colors_adjust( $primary, -0.15 );
			$vars['--yw-button-background-primary-hover'] = $this->scss_colors_adjust( $primary, -0.15 );
		}

		$vars['--yw-border-radius']         = $borderRadius == 'on' ? '0.25rem' : '0';
		$vars['--yw-card-border']           = $cardStyle == 'shadow' ? 'null' : '1px solid var(--yw-color-border)';
		$vars['--yw-card-box-shadow']       = $cardStyle == 'shadow' ? '0 0.5rem 1.5rem -0.25rem rgba(0, 0, 0, 0.15)' : 'null';
		$vars['--yw-card-box-shadow-hover'] = $cardStyle == 'shadow' ? '0 1rem 3rem -0.5rem rgba(0, 0, 0, 0.25)' : 'null';
		$vars['--yw-card-top-hover']        = $cardHover == 'on' ? '-0.25rem' : 'null';

		if ( $cardStyle == 'shadow' && $cardHover != 'on' ) {
			$vars['--yw-card-box-shadow-hover'] = '0 0.5rem 1.5rem -0.25rem rgba(0, 0, 0, 0.15);';
		}

		if ( ! empty ( $vars ) ) {
			ob_start();
			foreach ( $vars as $k => $v ) {
				echo wp_kses_post( $k . ':' . $v . ';' );
			}
			$varsOutput = ob_get_contents();
			ob_end_clean();

			echo '<style>:root {' . wp_kses_post( $varsOutput ) . '}</style>';
		}
	}

	public function scss_colors_adjust( $hexCode, $adjustPercent )
	{
		$hexCode = ltrim( $hexCode, '#' );

		if ( strlen( $hexCode ) == 3 ) {
			$hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
		}

		$hexCode = array_map( 'hexdec', str_split( $hexCode, 2 ) );

		foreach ( $hexCode as & $color ) {
			$adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
			$adjustAmount    = ceil( $adjustableLimit * $adjustPercent );

			$color = str_pad( dechex( $color + $adjustAmount ), 2, '0', STR_PAD_LEFT );
		}

		return '#' . implode( $hexCode );
	}
}
