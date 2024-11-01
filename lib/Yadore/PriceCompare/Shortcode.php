<?php

namespace xCORE\Yadore\PriceCompare;

use xCORE\Yadore\PriceCompare\Render;
use xCORE\Yadore\TemplateLoader;

class Shortcode
{
	public function __construct()
	{
		add_shortcode( 'yadore_widget_price_compare', [ &$this, 'render_shortcode' ] );
	}

	public function render_shortcode( $atts, $content = null )
	{
		extract( shortcode_atts( array(
				'ean'   => '',
				'limit' => 20
		), $atts ) );

		ob_start();

		?>
		<div class="yw-price-compare yw-shortcode">
			<div class="yw-container-fluid">
				<?php
				if ( $ean ) {
					$PriceCompare = new Render( $ean, $limit );
					$PriceCompare->show();
				} else {
					?>
					<p><?php echo __( 'Error: No ean given', 'xcore' ) ?></p>
					<?php
				}
				?>
			</div>
		</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
