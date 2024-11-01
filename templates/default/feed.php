<?php

use xCORE\Yadore\TemplateLoader;

$keyword   = get_post_meta( get_the_ID(), 'yadore_widget_feed_keyword', true );
$limit     = get_post_meta( get_the_ID(), 'yadore_widget_feed_limit', true );
$results   = $data->results;
$layout    = $data->layout;
$col       = $data->col;
$templates = new TemplateLoader();
?>

<div class="yw-feed-inner yw-feed-inner-<?php echo esc_attr( get_the_ID() ) ?>">
	<div class="yw-row yw-g-4">
		<?php
		if ( $results['offers'] ) {
			foreach ( $results['offers'] as $offer ) {
				$data = [ 'offer' => $offer, 'col' => $col ];
				$templates->set_template_data( $data )->get_template_part( "default/loop-$layout" );
			}
		}
		?>
	</div>
</div>
