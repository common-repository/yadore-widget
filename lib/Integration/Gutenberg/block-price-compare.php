<?php

add_action( 'init', function () {
	register_block_type( 'yadore-widget/price-compare', array(
		'render_callback' => function ( $atts ) {
			$ean = $atts['ean'] ?: '';

			if ( ! $ean ) {
				return __( 'Please set a valid ean', 'yadore-widget' );
			}

			return do_shortcode( '[yadore_widget_price_compare ean="' . esc_attr( $ean ) . '"/]' );
		},
		'attributes'      => [
			'ean' => [
				'type'    => 'string',
				'default' => ''
			]
		]
	) );
} );
