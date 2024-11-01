<?php

namespace xCORE\Yadore;

class Offer
{
	public function __construct( $data = [] )
	{
		$this->data = $data;
	}

	public function get_id()
	{
		return $this->data['id'];
	}

	public function get_title()
	{
		return $this->data['title'];
	}

	public function get_image()
	{
		/**
		 * @TODO add placeholder
		 */
		if ( $this->data['image']['url'] ) {
			?>
			<div class="yw-img-holder">
				<img src="<?php echo esc_url( $this->data['image']['url'] ) ?>" alt="<?php echo esc_attr( $this->data['title'] ) ?>"/>
			</div>
			<?php
		}
	}

	public function get_link()
	{
		return $this->data['clickUrl'];
	}

	public function get_price()
	{
		return $this->data['price']['amount'];
	}

	public function get_price_html()
	{
		$price    = number_format( $this->get_price(), 2, ',', '.' ); // @todo number format based on market? setting?
		$currency = $this->data['price']['currency']; // @todo currency position based on market? setting?

		return apply_filters( 'yadore_widget_offer_price_html', '<p class="yw-price"><strong class="yw-price-value">' . $price . '</strong> <span class="yw-price-currency">' . $currency . '</span></p>', $this->data );
	}

	public function get_shop()
	{
		return $this->data['merchant'];
	}

	public function get_shop_html()
	{
		$shop = $this->get_shop();

		return apply_filters( 'yadore_widget_offer_shop_html', '<p class="yw-meta"><small class="yw-meta-shop-name">' . esc_html( $shop['name'] ) . '</small></p>', $this->data );
	}

	public function get_shop_logo()
	{
		$shop = $this->get_shop();

		if ( $shop['logo']['url'] ) {
			return '<p class="yw-meta"><img src="' . esc_attr( $shop['logo']['url'] ) . '" class="yw-meta-shop-logo" alt="' . esc_attr( $shop['name'] ) . '" /></p>';
		}

		return $shop['name'];
	}
}
