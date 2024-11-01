<?php

$offerData = $data->offer;
$offer     = new \xCORE\Yadore\Offer( $offerData );
?>

<div class="col-12" data-id="<?php echo esc_attr( $offer->get_id() ) ?>">
	<div class="card card-yw card-yw-list card-yw-feed h-100">
		<div class="card-header">
			<?php echo wp_kses_post( $offer->get_image() ) ?>
		</div>

		<div class="card-body">
			<h5 class="card-title">
				<a class="stretched-link" href="<?php echo esc_url( $offer->get_link() ) ?>" target="_blank" rel="nofollow sponsored">
					<?php echo esc_html( $offer->get_title() ) ?>
				</a>
			</h5>

		</div>

		<div class="card-footer">
			<?php
			echo wp_kses_post( $offer->get_price_html() );
			echo wp_kses_post( $offer->get_shop_html() );
			?>
		</div>
	</div>
</div>
