<?php

$offerData = $data->offer;
$offer     = new \xCORE\Yadore\Offer( $offerData );
?>

<div class="yw-col-12" data-id="<?php echo esc_attr( $offer->get_id() ) ?>">
	<div class="yw-card yw-card-list yw-feed-card">
		<div class="yw-card-header">
			<?php echo wp_kses_post( $offer->get_image() ) ?>
		</div>

		<div class="yw-card-body">
			<h5 class="yw-card-title">
				<a class="yw-stretched-link" href="<?php echo esc_url( $offer->get_link() ) ?>" target="_blank" rel="nofollow sponsored">
					<?php echo esc_html( $offer->get_title() ) ?>
				</a>
			</h5>
		</div>

		<div class="yw-card-footer">
			<?php
			echo wp_kses_post( $offer->get_price_html() );
			echo wp_kses_post( $offer->get_shop_html() );
			?>
		</div>
	</div>
</div>
