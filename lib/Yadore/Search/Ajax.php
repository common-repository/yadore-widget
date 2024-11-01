<?php

namespace xCORE\Yadore\Search;

use xCORE\Yadore\Api\Connection;
use xCORE\Yadore\TemplateLoader;

class Ajax
{
	public function __construct()
	{
		add_action( 'wp_ajax_yadore_widget_search', [ &$this, 'ajax_request' ] );
		add_action( 'wp_ajax_nopriv_yadore_widget_search', [ &$this, 'ajax_request' ] );
	}

	public function ajax_request()
	{
		check_ajax_referer( 'yadore_widget_search', '_nonce' );

		/** https://www.javascripttutorial.net/javascript-dom/javascript-infinite-scroll/ */

		if ( isset ( $_POST['keyword'] ) ) {
			$keyword   = isset( $_POST['keyword'] ) ? sanitize_text_field( $_POST['keyword'] ) : '';
			$sort      = isset( $_POST['sort'] ) ? sanitize_text_field( $_POST['sort'] ) : '';
			$layout    = isset( $_POST['layout'] ) ? sanitize_text_field( $_POST['layout'] ) : 'grid';
			$col       = isset( $_POST['col'] ) ? (int)sanitize_text_field( $_POST['col'] ) : 3;
			$limit     = isset( $_POST['limit'] ) ? (int)sanitize_text_field( $_POST['limit'] ) : apply_filters( 'yadore_widget_search_limit', 12 );
			$page      = isset( $_POST['page'] ) ? (int)sanitize_text_field( $_POST['page'] ) : 1;
			$settings  = get_option( 'yadore_widget_general' );
			$templates = new TemplateLoader();
			$API       = new Connection();
			$results   = $API->searchProducts( $keyword, '', '', '', $sort, $limit, $page );
			$data      = [ 'layout' => $layout, 'col' => $col, 'results' => $results ];

			ob_start();
			$templates->set_template_data( $data )->get_template_part( $settings['template'] . "/search-results" );
			$output = ob_get_contents();
			ob_end_clean();

			wp_send_json_success( [ 'html' => $output ] );
		} else {
			wp_send_json_error( [ 'html' => '<p>' . __( 'Please enter a keyword', 'yadore-widget' ) . '</p>' ] );
		}

		wp_send_json_error();
	}
}
