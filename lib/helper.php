<?php

/**
 * Generate feed item col class
 *
 * @param $num
 * @param $prefix
 *
 * @return mixed
 */
function yw_generate_feedItem_colClass( $num = 3, $prefix = '' )
{
	switch ( $num ) {
		case 2:
			$classes = $prefix . 'col-12 ' . esc_attr( $prefix ) . 'col-sm-12 ' . esc_attr( $prefix ) . 'col-md-6 ' . esc_attr( $prefix ) . 'col-lg-6 ' . esc_attr( $prefix ) . 'col-xl-6 ' . esc_attr( $prefix ) . 'col-xxl-6';
			break;

		case 3:
			$classes = $prefix . 'col-12 ' . esc_attr( $prefix ) . 'col-sm-12 ' . esc_attr( $prefix ) . 'col-md-6 ' . esc_attr( $prefix ) . 'col-lg-6 ' . esc_attr( $prefix ) . 'col-xl-4 ' . esc_attr( $prefix ) . 'col-xxl-4';
			break;

		case 4:
			$classes = $prefix . 'col-12 ' . esc_attr( $prefix ) . 'col-sm-12 ' . esc_attr( $prefix ) . 'col-md-6 ' . esc_attr( $prefix ) . 'col-lg-6 ' . esc_attr( $prefix ) . 'col-xl-3 ' . esc_attr( $prefix ) . 'col-xxl-3';
			break;

		case 6:
			$classes = $prefix . 'col-12 ' . esc_attr( $prefix ) . 'col-sm-12 ' . esc_attr( $prefix ) . 'col-md-6 ' . esc_attr( $prefix ) . 'col-lg-4 ' . esc_attr( $prefix ) . 'col-xl-3 ' . esc_attr( $prefix ) . 'col-xxl-2';
			break;

		default:
			$classes = $prefix . 'col-12 ' . esc_attr( $prefix ) . 'col-sm-12 ' . esc_attr( $prefix ) . 'col-md-6 ' . esc_attr( $prefix ) . 'col-lg-6 ' . esc_attr( $prefix ) . 'col-xl-4 ' . esc_attr( $prefix ) . 'col-xxl-4 ';
			break;
	}

	return apply_filters( 'yw_feed_item_col_class', $classes, $num, $prefix );
}
