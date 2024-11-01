<?php

namespace xCORE\Yadore\Feed;

class Shortcode
{
	public function __construct()
	{
		add_shortcode( 'yadore_widget_feed', [ &$this, 'render_shortcode' ] );
	}

	public function render_shortcode( $atts, $content = null )
	{
		extract( shortcode_atts( array(
				'id'     => '',
				'layout' => 'grid',
				'col'    => '3',
		), $atts ) );

		ob_start();

		?>
		<div class="yw-feed yw-shortcode" data-feed-id="<?php echo esc_attr( $id ) ?>" data-col="<?php echo esc_attr( $col ) ?>">
			<div class="yw-container-fluid">
				<?php
				if ( $id ) {
					$Feed = new Render( $id, $layout, $col );
					$Feed->show();
				} else {
					?>
					<p><?php echo __( 'Error: No feed id given', 'xcore' ) ?></p>
					<?php
				}
				?>
			</div>
		</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
