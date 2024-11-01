<?php

add_action( 'init', function () {
	/**
	 * Load scripts
	 */
	wp_enqueue_script(
		'yadore-widget-yadore-block-editor', YADORE_WIDGET_URL . 'lib/Integration/Gutenberg/assets/js/dist/editor.min.js', [ 'wp-blocks', 'wp-dom', 'wp-dom-ready', 'wp-edit-post' ], YADORE_WIDGET_VERSION
	);

	wp_enqueue_style(
		'yadore-widget-yadore-block-editor', YADORE_WIDGET_URL . 'lib/Integration/Gutenberg/assets/css/editor.css', array(), YADORE_WIDGET_VERSION
	);
} );

/**
 * Add block category
 */
add_filter( 'block_categories_all', function ( $categories ) {
	$categories[] = array(
		'slug'  => 'yadore-widget',
		'title' => 'Yadore Widget'
	);

	return $categories;
} );

/**
 * Load assets
 */
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_style(
		'yadore-block-editor-css',
		YADORE_WIDGET_URL . 'assets/css/styles.min.css',
		array( 'wp-edit-blocks' ),
		time()
	);
} );
