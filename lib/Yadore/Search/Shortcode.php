<?php

namespace xCORE\Yadore\Search;

use xCORE\Yadore\TemplateLoader;

class Shortcode
{
	public function __construct()
	{
		add_shortcode( 'yadore_widget_search', [ &$this, 'render_shortcode' ] );
	}

	public function render_shortcode( $atts, $content = null )
	{
		extract(
			shortcode_atts( array(
				'placeholder' => __( 'Search by keyword', 'yadore-widget' ),
				'submit'      => __( 'Search', 'yadore-widget' ),
				'layout'      => 'grid',
				'col'         => '3',
				'limit'       => apply_filters( 'yadore_widget_search_limit', 12 )
			), $atts )
		);

		ob_start();
		$templates = new TemplateLoader();
		$settings  = get_option( 'yadore_widget_general' );

		?>
		<div class="yw-search yw-shortcode">
			<div class="yw-container-fluid">
				<?php
				$data = [ 'placeholder' => $placeholder, 'submit' => $submit, 'layout' => $layout, 'col' => $col, 'limit' => $limit ];
				$templates->set_template_data( $data )->get_template_part( $settings['template'] . "/search-form" );
				?>
			</div>
		</div>
		<?php

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
