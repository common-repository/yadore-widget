<?php

namespace xCORE\Yadore\PriceCompare;

use xCORE\Yadore\Api\Connection;
use xCORE\Yadore\TemplateLoader;

class Render
{
	public function __construct( $ean = '', $limit = 20 )
	{
		$this->ean   = $ean;
		$this->limit = $limit;
	}

	public function show()
	{
		if ( ! $this->ean ) {
			return __( 'No ean given.', 'yadore-widget' );
		}

		$ean           = esc_html( $this->ean );
		$limit         = esc_html( $this->limit );
		$settings      = get_option( 'yadore_widget_general' );
		$cacheLifetime = apply_filters( 'yadore_widget_price_compare_cache_lifetime', 6, $ean );
		$templates     = new TemplateLoader();
		$results       = get_transient( 'yadore_widget_price_compare_' . $this->ean . '_' . $limit );

		if ( ! $results ) {
			$API     = new Connection();
			$results = $API->searchProducts( '', $this->ean, '', '', 'price_asc', $limit );
			set_transient( 'yadore_widget_price_compare_' . $this->ean . '_' . $limit, $results, HOUR_IN_SECONDS * $cacheLifetime );
		}

		if ( $results['offers'] ) {
			$data = [ 'ean' => $ean, 'results' => $results ];
			$templates->set_template_data( $data )->get_template_part( $settings['template'] . "/price-compare" );
		} else {
			return __( 'No Products found in Feed.', 'yadore-widget' );
		}
	}
}
