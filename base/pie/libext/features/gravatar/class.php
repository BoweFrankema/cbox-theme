<?php
/**
 * PIE API: feature extensions, gravatar feature class file
 *
 * @author Marshall Sorenson <marshall@presscrew.com>
 * @link http://infinity.presscrew.com/
 * @copyright Copyright (C) 2010-2011 Marshall Sorenson
 * @license http://www.gnu.org/licenses/gpl.html GPLv2 or later
 * @package PIE-extensions
 * @subpackage features
 * @since 1.0
 */

/**
 * Gravatar feature
 *
 * @package PIE-extensions
 * @subpackage features
 */
class Pie_Easy_Exts_Features_Gravatar
	extends Pie_Easy_Features_Feature
{
	/**
	 */
	protected function init()
	{
		// run parent
		parent::init();

		// init directives
		$this->image_class = null;
	}
	
	/**
	 */
	public function configure()
	{
		// RUN PARENT FIRST!
		parent::configure();

		// get config
		$config = $this->config();

		// css title class
		if ( isset( $config->image_class ) ) {
			$this->image_class = (string) $config->image_class;
		}
	}

	/**
	 */
	public function init_styles_dynamic()
	{
		// call parent FIRST
		parent::init_styles_dynamic();

		// options
		$opt_border_width = $this->get_suboption('border_width')->get();
		$opt_border_color = $this->get_suboption('border_color')->get();
		$opt_padding = $this->get_suboption('padding')->get();
		$opt_bg_color = $this->get_suboption('bg_color')->get();

		// add rules
		$img = $this->style()->rule( 'img.' . $this->image_class );

		if ( $opt_border_width ) {
			$img->ad( 'border-width', $opt_border_width . 'px' );
		}
		if ( $opt_border_color ) {
			$img->ad( 'border-color', $opt_border_color );
		}
		if ( $opt_padding ) {
			$img->ad( 'padding', $opt_padding . 'px' );
		}
		if ( $opt_bg_color ) {
			$img->ad( 'background-color', $opt_bg_color );
		}
	}

	/**
	 * Format the gravatar URL
	 * 
	 * @return string
	 */
	public function url()
	{
		// options
		$opt_size = $this->get_suboption('size')->get();
		$opt_default_set = $this->get_suboption('default_set')->get();
		$opt_default_img = $this->get_suboption('default_img')->get_image_url();
		$opt_default_force = $this->get_suboption('default_force')->get();
		$opt_rating = $this->get_suboption('option_rating')->get();

		// the hash
		$hash = md5( strtolower( trim( get_the_author_meta( 'user_email' ) ) ) );

		// the options
		$params = array();

		// size
		if ( $opt_size ) {
			$params['s'] = $opt_size;
		}

		// default
		if ( $opt_default_img ) {
			$params['d'] = $opt_default_img;
		} elseif ( $opt_default_set ) {
			$params['d'] = $opt_default_set;
		}

		// force default
		if ( $opt_default_force ) {
			$params['f'] = 'y';
		}

		// rating
		if ( $opt_rating ) {
			$params['r'] = $opt_rating;
		}

		return sprintf( 'http://www.gravatar.com/avatar/%s.jpg?%s', $hash, http_build_query( $params ) );
	}
}

?>
