<?php

use xCORE\Yadore\TemplateLoader;

$ean       = $data->ean;
$results   = $data->results;
$templates = new TemplateLoader();

?>

<div class="yw-price-compare-inner" data-ean="<?php echo esc_attr( $ean ) ?>">
	<div class="row">
		<div class="card card-yw card-yw-compare">
			<ul class="list-group list-group-flush">
				<?php
				if ( $results['offers'] ) {
					foreach ( $results['offers'] as $offer ) {
						$data = [ 'offer' => $offer ];
						$templates->set_template_data( $data )->get_template_part( "bootstrap5/price-compare-item" );
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
