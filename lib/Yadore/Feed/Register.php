<?php

namespace xCORE\Yadore\Feed;

class Register
{
	public function __construct()
	{
		add_action( 'init', [ &$this, 'post_type' ] );
		add_action( 'admin_enqueue_scripts', [ &$this, 'backend_scripts' ] );

		add_filter( 'manage_edit-yadore_widget_feed_columns', [ &$this, 'columns_def' ] );
		add_action( 'manage_yadore_widget_feed_posts_custom_column', [ &$this, 'columns_content' ], 10, 2 );

		new CustomFields();
		new Shortcode();
	}

	public function post_type()
	{
		$menuIcon = '<svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="m12.9908 0-4.893 8.3792L5.896 4.7095 4 8.0734l2.1407 3.6086V20h3.4862v-8.3792L16.7217 0h-3.7309Z" /></svg>';

		$labels = array(
			'name'          => __( 'Feeds', 'yadore-widget' ),
			'singular_name' => __( 'Feed', 'yadore-widget' ),
			'all_items'     => __( 'Feeds', 'yadore-widget' ),
			'menu_name'     => __( 'Yadore', 'yadore-widget' ),
			'add_new'       => __( 'Add new Feed', 'yadore-widget' )
		);

		$args = array(
			'labels'       => $labels,
			'public'       => false,
			'show_ui'      => true,
			'hierarchical' => false,
			'has_archive'  => false,
			'menu_icon'    => 'data:image/svg+xml;base64,' . base64_encode( $menuIcon ),
			'show_in_rest' => true,
			'supports'     => array( 'title' ),
		);

		register_post_type( 'yadore_widget_feed', $args );
	}

	public function backend_scripts()
	{
		global $post_type;
		$current_screen = get_current_screen();

		if ( 'yadore_widget_feed' == $post_type || $current_screen->base == 'yadore_widget_feed_page_yadore_widget' ) {
			wp_enqueue_style( 'yadore-styles', YADORE_WIDGET_URL . 'assets/css/backend.css', [], YADORE_WIDGET_VERSION );
		}
	}

	public function columns_def( $columns )
	{
		$columns = array(
			'cb'             => '<input type="checkbox" />',
			'title'          => __( 'Feed Name', 'yadore-widget' ),
			'feed_keyword'   => __( 'Keyword', 'yadore-widget' ),
			'feed_ean'       => __( 'EAN/GTIN', 'yadore-widget' ),
			'feed_limit'     => __( 'Limit', 'yadore-widget' ),
			'feed_sort'      => __( 'Sort by', 'yadore-widget' ),
			'feed_shortcode' => __( 'Shortcode', 'xcore' )
		);

		return $columns;
	}

	public function columns_content( $column, $post_id )
	{
		switch ( $column ) {
			case 'feed_keyword':
				$keyword = get_post_meta( $post_id, 'yadore_widget_feed_keyword', true );
				if ( $keyword ) {
					echo esc_html( $keyword );
				} else {
					echo '-';
				}
				break;

			case 'feed_ean':
				$ean = get_post_meta( $post_id, 'yadore_widget_feed_ean', true );
				if ( $ean ) {
					echo esc_html( $ean );
				} else {
					echo '-';
				}
				break;

			case 'feed_limit':
				$limit = get_post_meta( $post_id, 'yadore_widget_feed_limit', true );
				if ( $limit ) {
					echo esc_html( $limit );
				} else {
					echo '-';
				}
				break;

			case 'feed_sort':
				$sort = get_post_meta( $post_id, 'yadore_widget_feed_sort', true );
				switch ( $sort ) {
					case 'rel_desc':
						echo 'Relevance';
						break;

					case 'price_asc':
						echo 'Price (Ascending)';
						break;

					case 'price_desc':
						echo 'Price (Descending)';
						break;

					default:
						echo '-';
						break;
				}
				break;

			case 'feed_shortcode':
				echo '<span class="yw-shortcode-preview" style="background: #f5f5f5; border: 1px solid #000; padding: 5px; display: inline-block;">[yadore_widget_feed id="' . esc_attr( $post_id ) . '" /]</span>';
				break;

			default :
				break;
		}
	}
}
