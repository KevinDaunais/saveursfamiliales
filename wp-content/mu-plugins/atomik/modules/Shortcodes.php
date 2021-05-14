<?php 

namespace ATMK;

class Shortcodes
{
	public static function boot(){

		self::_add_shortcodes([
			'email'        => 'hide_email',
			'custom-field' => 'custom_field',
			'footer-lock'  => 'footer_lock',
			'google-map'   => 'google_map',
		]);

	}

	private static function _add_shortcodes( $codes ){
		foreach( $codes as $code => $method_name ) {
			add_shortcode( $code, [ 'ATMK\Shortcodes', $method_name ] );
		}
	}

	/**
	 * [email]email@example.com[/email]
	 */
	public static function hide_email( $atts , $content = null ){
		if( ! is_email($content) ) return;
		return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
	}

	/**
	 * [custom-field name="fieldname"]
	 */
	public static function custom_field( $atts ){
		global $post;
		return get_post_meta( $post->ID, $atts['name'], TRUE );
	}

	/**
	 * [footer-lock]
	 */
	public static function footer_lock( $atts ){
		ob_start(); ?>
		<a class="footer-lock" id="ptb_footer_lock" href="<?php bloginfo( 'wpurl' ); ?>/wp-admin" rel="nofollow">
			<svg class="fa fa-lock"><use xlink:href="#fa-lock"></use></svg>
		</a>
		<?php return ob_get_clean();
	}

	/**
	* [google-map]
	*/
	public static function google_map( $atts ){
		exit('change key for google maps api call');
		Scripts::enqueue_script( 'googleAPI', 'https://maps.googleapis.com/maps/api/js?key=[CHANGEME]&amp;sensor=false' );
		Scripts::enqueue_script( 'googlemap', 'googlemap.js', ['googleAPI'] );
		$js_deps[] = 'googlemap';
		ob_start(); ?>

		<div class='gmap-wrapper'>
			<div id='map_canvas' style='width: 100%; height: 350px;'></div>
		</div>
		<?php return ob_get_clean();
	}
}