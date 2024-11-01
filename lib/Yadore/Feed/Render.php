<?php

namespace xCORE\Yadore\Feed;

use xCORE\Yadore\Api\Connection;
use xCORE\Yadore\TemplateLoader;

class Render
{
	public function __construct( $id = 0, $layout = 'grid', $col = 3 )
	{
		$this->id     = $id;
		$this->layout = $layout;
		$this->col    = $col;
	}

	public function show()
	{
		if ( ! $this->id ) {
			return __( 'No Feed id given.', 'yadore-widget' );
		}

		$id            = esc_html( $this->id );
		$col           = esc_html( $this->col );
		$layout        = esc_html( $this->layout );
		$keyword       = get_post_meta( $this->id, 'yadore_widget_feed_keyword', true );
		$ean           = get_post_meta( $this->id, 'yadore_widget_feed_ean', true );
		$limit         = get_post_meta( $this->id, 'yadore_widget_feed_limit', true ) ?: 10;
		$sort          = get_post_meta( $this->id, 'yadore_widget_feed_sort', true ) ?: 'rel_desc';
		$cacheLifetime = get_post_meta( $this->id, 'yadore_widget_feed_cache_lifetime', true ) ?: 6;
		$settings      = get_option( 'yadore_widget_general' );

		$templates = new TemplateLoader();
		$results   = get_transient( 'yadore_widget_feed_' . $id );

		if ( ! $results ) {
			$API     = new Connection();
			$results = $API->searchProducts( $keyword, $ean, '', '', $sort, $limit );
			set_transient( 'yadore_widget_feed_' . $id, $results, HOUR_IN_SECONDS * $cacheLifetime );
		}

		if ( $results['offers'] ) {
			$data = [ 'id' => $id, 'results' => $results, 'layout' => $layout, 'col' => $col ];
			$templates->set_template_data( $data )->get_template_part( $settings['template'] . "/feed" );
		} else {
			return __( 'No Products found in Feed.', 'yadore-widget' );
		}
	}
}
