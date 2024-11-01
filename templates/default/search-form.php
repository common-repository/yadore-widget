<?php

$layout      = $data->layout;
$col         = $data->col;
$limit       = $data->limit;
$placeholder = $data->placeholder;
$submit      = $data->submit;
?>


<form method="post" class="yw-search-form">
	<div class="yw-row yw-g-4">
		<div class="yw-col">
			<input type="search" name="keyword" class="yw-form-control" placeholder="<?php echo esc_attr( $placeholder ) ?>"/>
		</div>
		<div class="yw-col-auto">
			<select name="sort" class="yw-form-select">
				<option value="rel_desc"><?php echo __( 'Relevance', 'yadore-widget' ) ?></option>
				<option value="price_asc"><?php echo __( 'Price (Ascending)', 'yadore-widget' ) ?></option>
				<option value="price_desc"><?php echo __( 'Price (Descending)', 'yadore-widget' ) ?></option>
			</select>
		</div>
		<div class="yw-col-auto">
			<button type="submit" class="yw-btn yw-btn-primary"><?php echo esc_html( $submit ) ?></button>
		</div>
	</div>

	<input type="hidden" name="layout" value="<?php echo esc_attr( $layout ) ?>"/>
	<input type="hidden" name="col" value="<?php echo esc_attr( $col ) ?>"/>
	<input type="hidden" name="limit" value="<?php echo esc_attr( $limit ) ?>"/>
	<input type="hidden" name="_nonce" value="<?php echo wp_create_nonce( 'yadore_widget_search' ) ?>"/>
	<input type="hidden" name="action" value="yadore_widget_search"/>
</form>

<div class="yw-search-results" style="display: none"></div>
