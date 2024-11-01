<?php

add_action( 'init', function() {
	register_block_type( 'yadore-widget/feed', array(
		'render_callback' => function( $atts ) {
			$id     = $atts['id'];
			$layout = $atts['layout'] ?: 'grid';
			$col    = $atts['col'] ?: 3;

			if ( ! $id ) {
				return __( 'Please select a feed in the block settings', 'yadore-widget' );
			}

			return do_shortcode( '[yadore_widget_feed id="' . esc_attr( $id ) . '" layout="' . esc_attr( $layout ) . '" col="' . esc_attr( $col ) . '"/]' );
		},
		'attributes'      => [
			'id'     => [
				'type'    => 'string',
				'default' => ''
			],
			'layout' => [
				'type'    => 'string',
				'default' => 'grid'
			],
			'col'    => [
				'type'    => 'number',
				'default' => '3'
			]
		]
	) );
} );
