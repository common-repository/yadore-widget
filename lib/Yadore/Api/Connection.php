<?php

namespace xCORE\Yadore\Api;

class Connection
{
	var $endpoint_merchant;

	public function __construct()
	{
		$settings = get_option( 'yadore_widget_general' );

		$this->apiKey = esc_html( $settings['apiKey'] ?: '' );
		$this->market = esc_html( $settings['market'] ?: 'de' );

		$this->endpoint_merchant = 'https://api.yadore.com/v2/merchant?market=' . $this->market;
		$this->endpoint_category = 'https://api.yadore.com/v2/category?market=' . $this->market;
		$this->endpoint_offer    = 'https://api.yadore.com/v2/offer?market=' . $this->market;
	}

	public function cURL( $endpoint, $args = array() )
	{
		if ( ! $this->apiKey ) {
			echo new JsonResponse( __( 'There is no API Key.', 'yadore-widget' ) );
			die;
		}

		// build query
		if ( ! empty( $args ) ) {
			$query_args = http_build_query( $args );

			if ( $query_args ) {
				$endpoint .= '&' . $query_args;
			}
		}

		$args = array(
			'headers' => array(
				'api-key'      => $this->apiKey,
				'content-type' => 'application/json'
			)
		);

		$response = wp_remote_get( $endpoint, $args );
		$body     = wp_remote_retrieve_body( $response );

		return json_decode( $body, true );
	}

	public function getMerchantsList()
	{
		try {
			$data = $this->CURL( $this->endpoint_merchant );

			if ( $data ) {
				$merchants = $data['merchants'];

				if ( $merchants ) {
					return $merchants;
				}
			}
		} catch ( \Exception $e ) {
			echo new JsonResponse( $e->getMessage() );
			die;
		}
	}

	public function getCategoriesList()
	{
		try {
			$data = $this->CURL( $this->endpoint_category );

			if ( $data ) {
				$categories = $data['response']['categories'];

				if ( $categories ) {
					return $categories;
				}
			}
		} catch ( \Exception $e ) {
			echo new JsonResponse( $e->getMessage() );
			die;
		}
	}

	public function searchProducts( $keyword = '', $ean = '', $merchantId = '', $categoryId = '', $sort = 'rel_desc', $limit = 25, $page = 1 )
	{
		try {
			$args = array(
				'sort'  => $sort,
				'limit' => $limit,
			);

			if ( $keyword ) {
				$args['keyword'] = $keyword;
			}

			if ( $ean ) {
				$args['ean'] = $ean;
				unset( $args['keyword'] );
			}

			if ( $merchantId ) {
				$args['merchantId'] = $merchantId;
			}

			if ( ! $ean ) {
				$args['precision'] = 'strict';
			}

			if ( $page > 1 ) {
				$args['offset'] = ( ( $page - 1 ) * $limit );
			}

			$data = $this->CURL( $this->endpoint_offer, $args );

			if ( $data ) {
				return $data;
			}
		} catch ( \Exception $e ) {
			echo new JsonResponse( $e->getMessage() );
			die;
		}
	}

	public function lookupProduct( $id )
	{
		try {
			$args = array(
				'offerId' => $id
			);

			$data = $this->CURL( $this->endpoint_offer, $args );

			if ( $data ) {
				if ( $data['offers'] ) {
					return $data['offers'][0];
				}
			}
		} catch ( \Exception $e ) {
			echo new JsonResponse( $e->getMessage() );
			die;
		}
	}
}
