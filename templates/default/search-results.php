<?php

use xCORE\Yadore\TemplateLoader;

$layout    = $data->layout;
$col       = $data->col;
$results   = $data->results;
$templates = new TemplateLoader();

?>

<div class="yw-row yw-g-4">
	<?php
	if ( $results['offers'] ) {
		foreach ( $results['offers'] as $offer ) {
			$data = [ 'col' => $col, 'offer' => $offer ];
			$templates->set_template_data( $data )->get_template_part( "default/loop-$layout" );
		}
	} else {
		?>
		<p><?php echo __( 'No products found.', 'yadore-widget' ) ?></p>
		<?php
	}
	?>
</div>
