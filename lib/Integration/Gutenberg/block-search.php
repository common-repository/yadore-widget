<?php

add_action( 'init', function() {
	register_block_type( 'yadore-widget/search', array(
		'render_callback' => function( $atts ) {
			$layout = $atts['layout'] ?: 'grid';
			$col    = $atts['col'] ?: 3;
			$limit  = $atts['limit'] ?: 12;

			return do_shortcode( '[yadore_widget_search layout="' . esc_attr( $layout ) . '" col="' . esc_attr( $col ) . '" limit="' . esc_attr( $limit ) . '"/]' );
		},
		'attributes'      => [
			'layout' => [
				'type'    => 'string',
				'default' => 'grid'
			],
			'col'    => [
				'type'    => 'number',
				'default' => '3'
			],
			'limit'  => [
				'type'    => 'string',
				'default' => '12'
			]
		]
	) );
} );
