<?php

namespace xCORE\Yadore\Panels;

class Settings
{
	public function __construct()
	{
		add_action( 'admin_menu', [ &$this, 'register' ] );
		add_action( 'admin_enqueue_scripts', [ &$this, 'scripts' ] );
		add_action( 'admin_init', [ &$this, 'settings_init' ] );

		add_action( 'yadore_widget_section_nav_after', [ &$this, 'documentation_nav' ] );
		add_action( 'yadore_widget_section_content_after', [ &$this, 'documentation_content' ] );
	}

	public function register()
	{
		add_submenu_page( 'edit.php?post_type=yadore_widget_feed', __( 'Settings', 'yadore-widget' ), __( 'Settings', 'yadore-widget' ), 'edit_pages', 'yadore_widget', [ &$this, 'render' ] );
	}

	public function scripts()
	{
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	public function settings_init()
	{
		# General #
		register_setting( 'yadore_widget', 'yadore_widget_general' );
		add_settings_section( 'yadore_widget_general', __( 'General <span>settings</span>', 'yadore-widget' ), '', 'yadore_widget' );
		add_settings_field( 'yadore_widget_general_apiKey', __( 'API Key', 'yadore-widget' ), [ &$this, 'render_text_field' ], 'yadore_widget', 'yadore_widget_general', [ 'label_for' => 'apiKey', 'description' => '<a href="https://www.yadore.com/en/register/" target="_blank">Where can I get an API key?</a>' ] );
		add_settings_field( 'yadore_widget_general_market', __( 'Market', 'yadore-widget' ), [ &$this, 'render_select_field' ], 'yadore_widget', 'yadore_widget_general', [ 'label_for' => 'market' ] );
		add_settings_field( 'yadore_widget_general_template', __( 'Template', 'yadore-widget' ), [ &$this, 'render_select_field' ], 'yadore_widget', 'yadore_widget_general', [ 'label_for' => 'template' ] );

		# Colors #
		register_setting( 'yadore_widget', 'yadore_widget_colors' );
		add_settings_section( 'yadore_widget_colors', __( 'Color <span>settings</span>', 'yadore-widget' ), '', 'yadore_widget' );
		add_settings_field( 'yadore_widget_colors_headline', __( 'Headline', 'yadore-widget' ), [ &$this, 'render_colorpicker_field' ], 'yadore_widget', 'yadore_widget_colors', [ 'parent_settings' => 'yadore_widget_colors', 'label_for' => 'headline', 'default_value' => '#212529' ] );
		add_settings_field( 'yadore_widget_colors_text', __( 'Text', 'yadore-widget' ), [ &$this, 'render_colorpicker_field' ], 'yadore_widget', 'yadore_widget_colors', [ 'parent_settings' => 'yadore_widget_colors', 'label_for' => 'text', 'default_value' => '#495057' ] );
		add_settings_field( 'yadore_widget_colors_text_muted', __( 'Text (muted)', 'yadore-widget' ), [ &$this, 'render_colorpicker_field' ], 'yadore_widget', 'yadore_widget_colors', [ 'parent_settings' => 'yadore_widget_colors', 'label_for' => 'text_muted', 'default_value' => '#6c757d' ] );
		add_settings_field( 'yadore_widget_colors_primary', __( 'Primary', 'yadore-widget' ), [ &$this, 'render_colorpicker_field' ], 'yadore_widget', 'yadore_widget_colors', [ 'parent_settings' => 'yadore_widget_colors', 'label_for' => 'primary', 'default_value' => '#0d6efd' ] );

		# Layout #
		register_setting( 'yadore_widget', 'yadore_widget_layout' );
		add_settings_section( 'yadore_widget_layout', __( 'Layout <span>settings</span>', 'yadore-widget' ), '', 'yadore_widget' );
		add_settings_field( 'yadore_widget_layout_card_style', __( 'Card style', 'yadore-widget' ), [ &$this, 'render_select_field' ], 'yadore_widget', 'yadore_widget_layout', [ 'parent_settings' => 'yadore_widget_layout', 'label_for' => 'card_style' ] );
		add_settings_field( 'yadore_widget_layout_card_hover', __( 'Card hover effect', 'yadore-widget' ), [ &$this, 'render_checkbox_field' ], 'yadore_widget', 'yadore_widget_layout', [ 'parent_settings' => 'yadore_widget_layout', 'label_for' => 'card_hover', 'default_value' => 'on', 'description' => 'Activate the card hover effect' ] );
		add_settings_field( 'yadore_widget_layout_border_radius', __( 'Border radius', 'yadore-widget' ), [ &$this, 'render_checkbox_field' ], 'yadore_widget', 'yadore_widget_layout', [ 'parent_settings' => 'yadore_widget_layout', 'label_for' => 'border_radius', 'default_value' => 'on', 'description' => 'Activate the border radius' ] );
		add_settings_field( 'yadore_widget_layout_buy_now_text', __( 'Buy now text', 'yadore-widget' ), [ &$this, 'render_text_field' ], 'yadore_widget', 'yadore_widget_layout', [ 'parent_settings' => 'yadore_widget_layout', 'label_for' => 'buy_now_text', 'default_value' => 'Buy now', 'description' => '' ] );
	}

	public function render_text_field( $args )
	{
		$parentSettings = $args['parent_settings'] ?? 'yadore_widget_general';
		$options        = get_option( $parentSettings ) ?: [];
		$fieldName      = $args['label_for'];
		$value 			= isset( $options[$fieldName] ) ? $options[$fieldName] : $args['default_value'];
		?>
		<input class="regular-text" type="text" name="<?php echo esc_attr( $parentSettings ) ?>[<?php echo esc_attr( $fieldName ); ?>]" id="<?php echo esc_attr( $fieldName ); ?>" value="<?php echo esc_attr( $value ) ?>"/>

		<?php
		if ( $args['description'] ) {
			?>
			<p class="description"><?php echo $args['description'] ?></p>
			<?php
		}
	}

	public function render_colorpicker_field( $args )
	{
		$parentSettings = $args['parent_settings'] ?? 'yadore_widget_general';
		$options        = get_option( $parentSettings ) ?: [];
		$fieldName      = $args['label_for'];
		$value 			= isset( $options[$fieldName] ) ? $options[$fieldName] : $args['default_value'];
		?>
		<input class="wp-color-picker" type="text" name="<?php echo esc_attr( $parentSettings ) ?>[<?php echo esc_attr( $fieldName ); ?>]" id="<?php echo esc_attr( $fieldName ); ?>" data-default-color="<?php echo esc_attr( $args['default_value'] ) ?>" value="<?php echo esc_attr( $value ) ?>"/>

		<?php
		if ( isset( $args['description'] ) &&  $args['description'] ) {
			?>
			<p class="description"><?php echo esc_html( $args['description'] ) ?></p>
			<?php
		}
	}

	public function render_checkbox_field( $args )
	{
		$parentSettings = $args['parent_settings'] ?: 'yadore_widget_general';
		$options        = get_option( $parentSettings ) ?: [];
		$fieldName      = $args['label_for'];
		$value          = isset( $options[$fieldName] ) ? esc_attr( $options[$fieldName] ) : '';

		if ( $args['default_value'] == 'on' && get_option( $parentSettings ) === false ) {
			$value = 'on';
		}

		if ( isset( $args['description'] ) &&  $args['description'] ) {
			?>
			<label for="<?php echo esc_attr( $fieldName ); ?>">
				<input type="checkbox" name="<?php echo esc_attr( $parentSettings ) ?>[<?php echo esc_attr( $fieldName ); ?>]" id="<?php echo esc_attr( $fieldName ); ?>" value="on" <?php echo $value == 'on' ? 'checked' : '' ?>/>
				<?php echo $args['description'] ?>
			</label>
			<?php
		} else {
			?>
			<input type="checkbox" name="<?php echo esc_attr( $parentSettings ) ?>[<?php echo esc_attr( $fieldName ); ?>]" id="<?php echo esc_attr( $fieldName ); ?>" value="on" <?php echo $value == 'on' ? 'checked' : '' ?>/>
			<?php
		}
	}

	public function render_select_field( $args )
	{
		$parentSettings = $args['parent_settings'] ?? 'yadore_widget_general';
		$options        = get_option( $parentSettings ) ?? [];
		$fieldName      = $args['label_for'];
		$selectValues   = $this->selectValues( $fieldName );
		?>
		<select id="<?php echo esc_attr( $fieldName ) ?>" name="<?php echo esc_attr( $parentSettings ) ?>[<?php echo esc_attr( $fieldName ) ?>]">
			<?php
			if ( $selectValues ) {
				foreach ( $selectValues as $k => $v ) {
					?>
					<option value="<?php echo esc_attr( $k ) ?>" <?php echo isset( $options[$fieldName] ) ? ( selected( $options[$fieldName], $k, false ) ) : '' ?>>
						<?php echo esc_html( $v ) ?>
					</option>
					<?php
				}
			}
			?>
		</select>

		<?php
		if ( isset( $args['description'] ) &&  $args['description'] ) {
			?>
			<p class="description"><?php echo $args['description'] ?></p>
			<?php
		}
	}


	public function render_sections_nav( $page )
	{
		global $wp_settings_sections, $wp_settings_fields;

		if ( ! isset( $wp_settings_sections[$page] ) ) {
			return;
		}

		echo '<ul class="yadore-nav">';
		$i = 0;
		do_action( 'yadore_widget_section_nav_before' );
		foreach ( (array)$wp_settings_sections[$page] as $k => $section ) {
			do_action( 'yadore_widget_section_nav', $k, $section );
			echo '<li><a href="#" data-action="yadore-tab" data-target="' . esc_attr( $section['id'] ) . '" class="' . ( $i == 0 ? 'active' : '' ) . '">' . $section['title'] . '</a></li>';

			$i ++;
		}
		do_action( 'yadore_widget_section_nav_after' );
		echo '</ul>';
	}

	public function render_sections( $page )
	{
		global $wp_settings_sections, $wp_settings_fields;

		if ( ! isset( $wp_settings_sections[$page] ) ) {
			return;
		}

		do_action( 'yadore_widget_section_content_before' );

		$i = 0;
		foreach ( (array)$wp_settings_sections[$page] as $k => $section ) {
			do_action( 'yadore_widget_section_content', $k, $section );

			echo '<div class="settings-section section-' . esc_attr( $section['id'] ) . ' yadore-tab" id="' . esc_attr( $section['id'] ) . '" style="' . esc_attr( ( $i != 0 ? 'display: none' : '' ) ) . '">';

			if ( $section['title'] ) {
				echo "<h2>" . $section['title'] . "</h2>\n";
			}

			if ( $section['callback'] ) {
				call_user_func( $section['callback'], $section );
			}

			if ( $section['id'] == 'yadore_widget_colors' ) {
				echo '<p>' . __( 'The color settings works only for the default theme.', 'yadore_widget' ) . '</p>';
			}

			if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[$page] ) || ! isset( $wp_settings_fields[$page][$section['id']] ) ) {
				continue;
			}
			echo '<table class="form-table" role="presentation">';
			do_settings_fields( $page, $section['id'] );
			echo '</table>';
			echo '</div>';

			$i ++;
		}

		do_action( 'yadore_widget_section_content_after' );
	}

	public function render()
	{
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>

		<div class="wrap yadore-wrap">
			<div class="yadore-header">
				<div class="yadore-brand">
					<img src="<?php echo esc_attr( YADORE_WIDGET_URL . 'assets/images/yadore-logo.svg' ) ?>" alt="Yadore Logo" class="yadore-logo"/>
				</div>
				<?php echo esc_html( $this->render_sections_nav( 'yadore_widget' ) ) ?>
			</div>

			<form action="options.php" method="post">
				<?php
				settings_fields( 'yadore_widget' );
				$this->render_sections( 'yadore_widget' );
				submit_button( __( 'Save Settings', 'yadore-widget' ) );
				?>
			</form>

			<script>
				jQuery(document).ready(function ($) {
					jQuery('.wp-color-picker').wpColorPicker();

					jQuery('[data-action="yadore-tab"]').on('click', function (e) {
						var target = jQuery(this).attr('data-target');
						var nav = jQuery(this).closest('.yadore-nav');
						var form = jQuery(this).closest('.yadore-wrap').find('form[action="options.php"]');

						// toggle active class on navigation
						nav.find('a').removeClass('active');
						jQuery(this).addClass('active');

						// toggle tab active state
						form.find('.yadore-tab').hide();
						form.find('.yadore-tab[id="' + target + '"]').show();

						e.preventDefault();
					});
				});
			</script>
		</div>
		<?php
	}

	public function selectValues( $fieldName )
	{
		switch ( $fieldName ) {
			case 'card_style':
				$values = [
					'shadow' => 'Shadow',
					'border' => 'Border'
				];
				break;

			case 'market':
				$values = [
					'de' => __( 'Germany', 'yadore-widget' ),
					'at' => __( 'Austria', 'yadore-widget' ),
					'be' => __( 'Belgium', 'yadore-widget' ),
					'br' => __( 'Brasil', 'yadore-widget' ),
					'ch' => __( 'Switzerland', 'yadore-widget' ),
					'cz' => __( 'Czech Republic', 'yadore-widget' ),
					'dk' => __( 'Denmark', 'yadore-widget' ),
					'es' => __( 'Spain', 'yadore-widget' ),
					'fi' => __( 'Finland', 'yadore-widget' ),
					'fr' => __( 'France', 'yadore-widget' ),
					'gr' => __( 'Greece', 'yadore-widget' ),
					'hu' => __( 'Hungary', 'yadore-widget' ),
					'it' => __( 'Italy', 'yadore-widget' ),
					'mx' => __( 'Mexico', 'yadore-widget' ),
					'nl' => __( 'Netherlands', 'yadore-widget' ),
					'no' => __( 'Norway', 'yadore-widget' ),
					'pl' => __( 'Poland', 'yadore-widget' ),
					'pt' => __( 'Portugal', 'yadore-widget' ),
					'ro' => __( 'Romania', 'yadore-widget' ),
					'ru' => __( 'Russia', 'yadore-widget' ),
					'se' => __( 'Sweden', 'yadore-widget' ),
					'sk' => __( 'Slovakia', 'yador e-widget' ),
					'uk' => __( 'Great Britain', 'yadore-widget' ),
					'us' => __( 'USA', 'yadore-widget' ),
					'ae' => __( 'United Arab Emirates' ),
					'au' => __( 'Australia', 'yadore-widget' ),
					'ca' => __( 'Canada', 'yadore-widget' ),
					'hk' => __( 'Hong Kong', 'yadore-widget' ),
					'id' => __( 'Indonesia', 'yadore-widget' ),
					'ie' => __( 'Ireland', 'yadore-widget' ),
					'in' => __( 'India', 'yadore-widget' ),
					'jp' => __( 'Japan', 'yadore-widget' ),
					'kr' => __( 'South Korea', 'yadore-widget' ),
					'my' => __( 'Malaysia', 'yadore-widget' ),
					'nz' => __( 'New Zealand', 'xore' ),
					'ph' => __( 'Philippines', 'yadore-widget' ),
					'sg' => __( 'Singapore', 'yadore-widget' ),
					'tr' => __( 'Turkey', 'yadore-widget' ),
					'vn' => __( 'Vietnam', 'yadore-widget' ),
					'za' => __( 'South Africa', 'xore' )
				];
				break;

			case 'template':
				$values = [
					'default'    => 'Default',
					'bootstrap5' => 'Bootstrap 5'
				];
				break;

			default:
				$values = [];
				break;
		}

		return apply_filters( 'yadore_widget_select_values_' . $fieldName, $values );
	}

	public function documentation_nav()
	{
		echo '<li><a href="#" data-action="yadore-tab" data-target="yadore_widget_documentation" class="">' . esc_html( __( 'Help', 'yadore-widget' ) ) . '</a></li>';
	}

	public function documentation_content()
	{
		?>
		<div class="settings-section section-yadore_widget_documentation yadore-tab" id="yadore_widget_documentation" style="display: none">
			<h2><?php echo __( 'Help', 'yadore-widget' ) ?></h2>

			<table class="wp-list-table widefat fixed striped">
				<thead>
				<tr>
					<th><?php echo __( 'Shortcode', 'yadore-widget' ) ?></th>
					<th><?php echo __( 'Description', 'yadore-widget' ) ?></th>
					<th><?php echo __( 'Attributes', 'yadore-widget' ) ?></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<input type="text" readonly="" value="[yadore_widget_feed]" onfocus="this.select()" style="width: 50%">
					</td>
					<td>
						<?php echo sprintf( __( 'Display a feed previously generated under <a href="%s" target="_blank">Feeds</a>.', 'yadore-widget' ), esc_url( admin_url( 'edit.php?post_type=yadore_widget_feed' ) ) ) ?>
					</td>
					<td>
						<ul style="list-style: square">
							<li><strong>id:</strong> <?php echo __( 'ID of the feed you want to display', 'xcore' ) ?></li>
							<li><strong>layout:</strong> grid/list</li>
							<li><strong>col</strong>: <?php echo __( 'Number of posts in a row, default: <strong>3</strong>', 'xcore' ) ?></li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" readonly="" value="[yadore_widget_price_compare]" onfocus="this.select()" style="width: 50%">
					</td>
					<td>
						<?php echo sprintf( __( 'Display a price comparison of a given product.', 'yadore-widget' ), esc_url( admin_url( 'edit.php?post_type=yadore_widget_feed' ) ) ) ?>
					</td>
					<td>
						<ul style="list-style: square">
							<li><strong>ean:</strong> <?php echo __( 'EAN of the product', 'xcore' ) ?></li>
							<li><strong>limit</strong>: <?php echo __( 'Maximum number of prices, default: <strong>20</strong>', 'xcore' ) ?></li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" readonly="" value="[yadore_widget_search]" onfocus="this.select()" style="width: 50%">
					</td>
					<td>
						<?php echo sprintf( __( 'Display a search form', 'yadore-widget' ), esc_url( admin_url( 'edit.php?post_type=yadore_widget_feed' ) ) ) ?>
					</td>
					<td>
						<ul style="list-style: square">
							<li><strong>placeholder:</strong> <?php echo __( 'Placeholder text of search input', 'xcore' ) ?></li>
							<li><strong>submit</strong>: <?php echo __( 'Text of form submit button', 'xcore' ) ?></li>
							<li><strong>layout:</strong> grid/list</li>
							<li><strong>col</strong>: <?php echo __( 'Number of results in a row, default: <strong>3</strong>', 'xcore' ) ?></li>
							<li><strong>limit</strong>: <?php echo __( 'Maximum number of results, default: <strong>12</strong>', 'xcore' ) ?></li>
						</ul>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
		<?php
	}
}
