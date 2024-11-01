<?php

$offerData      = $data->offer;
$offer          = new \xCORE\Yadore\Offer( $offerData );
$layoutSettings = get_option( 'yadore_widget_layout' ) ?: [];
$buy_now_text   = isset( $layoutSettings['buy_now_text'] ) ? $layoutSettings['buy_now_text'] : __( 'Buy now', 'yadore-widget' );
?>

<li class="yw-list-group-item" data-id="<?php echo esc_attr( $offer->get_id() ) ?>">
	<div class="yw-row">
		<div class="yw-col-auto">
			<?php echo wp_kses_post( $offer->get_shop_logo() ) ?>
		</div>

		<div class="yw-col">
			<?php echo wp_kses_post( $offer->get_price_html() ) ?>
		</div>

		<div class="yw-col-auto">
			<a href="<?php echo esc_url( $offer->get_link() ) ?>" class="yw-stretched-link" target="_blank" rel="nofollow sponsored">
				<?php echo $buy_now_text ?>
			</a>
		</div>
	</div>
</li>
