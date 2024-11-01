<?php

namespace xCORE\Yadore\Feed;

class CustomFields
{
	public function __construct()
	{
		add_action( 'admin_init', [ &$this, 'meta_box' ] );
		add_action( 'save_post', [ &$this, 'save' ] );
	}

	public function meta_box()
	{
		add_meta_box( "Feed Settings", "Feed Settings", [ &$this, 'render_fields' ], "yadore_widget_feed", "normal", "high" );
		add_meta_box( "Feed Shortcode", "Feed Shortcode", [ &$this, 'render_shortcode_box' ], "yadore_widget_feed", "side", "default" );
	}

	public function render_fields()
	{
		$sort = get_post_meta( get_the_ID(), 'yadore_widget_feed_sort', true ) ?: 'rel_desc';
		?>

		<div class="yadore-feed-form">
			<h4><?php echo __( 'Feed Settings', 'yadore-widget' ) ?></h4>

			<div class="field-group">
				<label for="yadore_widget_feed_keyword"><?php echo __( 'Keyword', 'yadore-widget' ) ?></label>
				<input class="regular-text" type="text" name="yadore_widget_feed_keyword" id="yadore_widget_feed_keyword" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'yadore_widget_feed_keyword', true ) ) ?>">
			</div>

			<div class="field-group">
				<label for="yadore_widget_feed_keyword"><?php echo __( 'EAN/GTIN', 'yadore-widget' ) ?></label>
				<input class="regular-text" type="text" name="yadore_widget_feed_ean" id="yadore_widget_feed_ean" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'yadore_widget_feed_ean', true ) ) ?>">
			</div>

			<div class="field-group">
				<label for="yadore_widget_feed_limit"><?php echo __( 'Number of items', 'yadore-widget' ) ?></label>
				<input class="regular-text" type="number" name="yadore_widget_feed_limit" id="yadore_widget_feed_limit" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'yadore_widget_feed_limit', true ) ) ?>">
			</div>

			<div class="field-group">
				<label for="yadore_widget_feed_sort"><?php echo __( 'Sort by', 'yadore-widget' ) ?></label>
				<select name="yadore_widget_feed_sort" id="yadore_widget_feed_sort">
					<option value="rel_desc" <?php echo $sort == 'rel_desc' ? 'selected' : '' ?>><?php echo __( 'Relevance', 'yadore-widget' ) ?></option>
					<option value="price_asc" <?php echo $sort == 'price_asc' ? 'selected' : '' ?>><?php echo __( 'Price (Ascending)', 'yadore-widget' ) ?></option>
					<option value="price_desc" <?php echo $sort == 'price_desc' ? 'selected' : '' ?>><?php echo __( 'Price (Descending)', 'yadore-widget' ) ?></option>
				</select>
			</div>
		</div>

		<div class="yadore-feed-form">
			<h4><?php echo __( 'Caching', 'yadore-widget' ) ?></h4>

			<div class="field-group">
				<label for="yadore_widget_feed_cache_lifetime"><?php echo __( 'Cache lifetime (in hours)', 'yadore-widget' ) ?></label>
				<input class="regular-text" type="number" name="yadore_widget_feed_cache_lifetime" id="yadore_widget_feed_cache_lifetime" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'yadore_widget_feed_cache_lifetime', true ) ) ?: 6 ?>">
			</div>
		</div>

		<div class="yadore-feed-preview">
			<h4><?php echo __( 'Preview', 'yadore-widget' ) ?></h4>

			<div class="field-group">
				<div class="feed-preview">
					<?php
					$Feed = new Render( get_the_ID() );
					$Feed->show();
					?>
				</div>
			</div>
		</div>

		<?php
	}

	public function render_shortcode_box()
	{
		?>
		<p><?php echo __( 'Output this feed by using the following shortcode:', 'yadore-widget' ) ?></p>
		<span class="yw-shortcode-preview">[yadore_widget_feed id="<?php echo esc_attr( get_the_ID() ) ?>" /]</span>
		<p><?php echo __( 'Available parameters:', 'yadore-widget' ) ?></p>
		<ul class="yw-shortcode-docs">
			<li><strong>id</strong> <span><?php echo __( 'The id of the feed', 'yadore-widget' ) ?></span></li>
			<li><strong>layout</strong> <span><?php echo __( 'Layout of the items (grid (default), list)', 'yadore-widget' ) ?></span></li>
			<li><strong>col</strong> <span><?php echo __( 'Number of items per row (2, 3 (default), 4, 5, 6)', 'yadore-widget' ) ?></span></li>
		</ul>
		<?php
	}

	public function save( $post_id )
	{
		// validate post type
		if ( get_post_type( $post_id ) != 'yadore_widget_feed' ) {
			return;
		}

		// autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// AJAX
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		// Post revision
		if ( false !== wp_is_post_revision( $post_id ) ) {
			return;
		}

		// delete cache
		delete_transient( 'yadore_widget_feed_' . $post_id );

		// save custom fields
		if ( isset( $_POST['yadore_widget_feed_keyword'] ) ) {
			update_post_meta( $post_id, 'yadore_widget_feed_keyword', sanitize_text_field( $_POST['yadore_widget_feed_keyword'] ) );
		}
		if ( isset( $_POST['yadore_widget_feed_ean'] ) ) {
			update_post_meta( $post_id, 'yadore_widget_feed_ean', sanitize_text_field( $_POST['yadore_widget_feed_ean'] ) );
		}
		if ( isset( $_POST['yadore_widget_feed_limit'] ) ) {
			update_post_meta( $post_id, 'yadore_widget_feed_limit', sanitize_text_field( $_POST['yadore_widget_feed_limit'] ) );
		}
		if ( isset( $_POST['yadore_widget_feed_sort'] ) ) {
			update_post_meta( $post_id, 'yadore_widget_feed_sort', sanitize_text_field( $_POST['yadore_widget_feed_sort'] ) );
		}
		if ( isset( $_POST['yadore_widget_feed_cache_lifetime'] ) ) {
			update_post_meta( $post_id, 'yadore_widget_feed_cache_lifetime', sanitize_text_field( $_POST['yadore_widget_feed_cache_lifetime'] ) );
		}
	}
}
