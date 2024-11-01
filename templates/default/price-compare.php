<?php

use xCORE\Yadore\TemplateLoader;

$ean       = $data->ean;
$results   = $data->results;
$templates = new TemplateLoader();

?>


<div class="yw-price-compare-inner" data-ean="<?php echo esc_attr( $ean ) ?>">
	<div class="yw-row">
		<div class="yw-card yw-compare-card">
			<ul class="yw-list-group">
				<?php
				if ( $results['offers'] ) {
					foreach ( $results['offers'] as $offer ) {
						$data = [ 'offer' => $offer ];
						$templates->set_template_data( $data )->get_template_part( "default/price-compare-item" );
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
