<?php 

namespace ATMK;

class Scripts
{

	public static function boot(){
		Core::add_action( 'wp_enqueue_scripts', ['Scripts', 'wp_enqueue_scripts'] );
		Core::add_filter( 'script_loader_tag', ['Scripts', 'add_async_defer_attribute'], 10, 2 );
		Core::add_filter( 'wp_default_scripts', ['scripts', 'remove_jquery_migrate'] );

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}

	public static function add_async_defer_attribute( $tag, $handle ) {
		if ( 'googleapis' !== $handle ){
			return $tag;
		}
		return str_replace( ' src', ' async defer src', $tag );
	}

	public static function wp_enqueue_scripts(){
		self::enqueue_styles();
		self::enqueue_scripts();
	}

	private static function enqueue_scripts(){

		$i18n = [
			'ajaxurl'    => admin_url('admin-ajax.php'),
			'theme_path' => get_stylesheet_directory_uri(),
		];

		$deps = [ 'jquery' ];

		do_action( 'atmk/enqueue_scripts' );

		if( is_singular() && get_option( 'thread_comments' ) ){
			wp_enqueue_script( 'comment-reply' );
		}

		self::enqueue_script( 'main-script', 'dist/app.js', apply_filters('atmk/scripts/main/deps', $deps) );
		wp_localize_script( 'main-script', 'ATMK', apply_filters('atmk/scripts/main/i18n', $i18n) );
	}

	private static function enqueue_styles(){
		wp_enqueue_style('js_composer_front');

		do_action( 'atmk/enqueue_styles' );

		self::enqueue_style( 'main-css', 'style.css' );
	}

	/**
	 * Get the url for a JS file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the js file
	 */
	public static function get_js_url( $file, $mode = Files::LOCATE_BOTH ){
		return Files::locate_file_url( "js/{$file}", $mode );
	}
	/**
	 * Get the path for a JS file
	 *
	 * @param  string $file file name for which to get the path
	 *
	 * @return string       path for the js file
	 *
	 */
	public static function get_js_path( $file, $mode = Files::LOCATE_BOTH ){
		return Files::locate_file_path( "js/{$file}", $mode );
	}

	/**
	 * Get the url for a CSS file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the css file
	 */
	public static function get_css_url( $file, $mode = Files::LOCATE_BOTH ){
		return Files::locate_file_url( "css/{$file}", $mode );
	}
	/**
	 * Get the path for a CSS file
	 *
	 * @param  string $file file name for which to get the path
	 *
	 * @return string       path for the css file
	 */
	public static function get_css_path( $file, $mode = Files::LOCATE_BOTH ){
		return Files::locate_file_path( "css/{$file}", $mode );
	}

	/**
	 * Enqueue a JS file
	 *
	 * @param  string  $handle    a unique identifier for the script
	 * @param  string  $file      url for the file
	 * @param  array   $deps      unique identifiers for scripts to load before this one
	 * @param  string  $ver       version of the file
	 * @param  boolean $in_footer do we load this file in the footer
	 *
	 * @uses wp_enqueue_script()
	 */
	public static function enqueue_script( $handle, $file, $deps = [], $ver = '', $in_footer = TRUE, $is_template = FALSE ){

		$mode = $is_template ? Files::LOCATE_PARENT : Files::LOCATE_BOTH;

		// if no version is used, use the last modified time of the file
		if( ! $ver ){
			$ver = @filemtime( self::get_js_path($file, $mode) );
		}

		$src = self::get_js_url($file, $mode);
		if( ! file_exists(self::get_js_path( $file, $mode )) ){
			$src = $file;
		}

		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
	}

	/**
	 * Enqueue a CSS file
	 *
	 * @param  string $handle a unique identifier for the script
	 * @param  string $file   url for the file
	 * @param  array  $deps   unique identifiers for css files to load before this one
	 * @param  string $ver    version of the file
	 * @param  string $media  media attribute for the css file
	 *
	 * @uses wp_enqueue_style()
	 */
	public static function enqueue_style( $handle, $file, $deps = array(), $ver = '', $media = 'all', $is_template = FALSE ){

		$mode = $is_template ? Files::LOCATE_PARENT : Files::LOCATE_BOTH;

		// if no version is used, use the last modified time of the file
		if( ! $ver ){
			$ver = @filemtime( self::get_css_path($file, $mode) );
		}

		$src = self::get_css_url($file, $mode);
		if( ! file_exists(self::get_css_path( $file, $mode )) ){
			$src = $file;
		}

		wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	}

	/**
	 * Wrapper for registering ajax calls
	 * @param  string $action the action name for the ajax
	 */
	public static function register_ajax( $action, $_object = NULL, $secure = FALSE ){

		$method_name = "ajax_$action";

		if( ! is_null($_object) ) {
			$object = $_object;
			
		} else if ( method_exists(Core::$child, $method_name) ) {
			$object = Core::$child;
		
		} else if ( method_exists(Core::$parent, $method_name) ) {
			$object = Core::$parent;
		}

		if( $object ){
			add_action( "wp_ajax_$action", [$object, 'ajax_' . $action] );
			
			if( ! $secure ){
				add_action( "wp_ajax_nopriv_$action", [$object, 'ajax_' . $action] );
			}
		}
	}

	/**
	 * Wrapper to enqueue typekit font
	 * @param  string $key the alphanumeric key for the js file
	 */
	public static function enqueue_typekit( $key ){
		Core::add_action( 'wp_head', ['Scripts', 'theme_typekit_inline'] );
		return self::enqueue_script( "theme_typekit", "//use.typekit.net/{$key}.js", [], Core::get_theme_version(), FALSE );
	}

	/**
	 * Start the enqueued typekit file
	 */
	public static function theme_typekit_inline(){
		if( wp_script_is('theme_typekit', 'done') ){
			?><script type="text/javascript">try{Typekit.load();}catch(e){}</script><?php
		}
	}

	public static function remove_jquery_migrate( $scripts ){
		if( ! is_admin() ){
			$scripts->remove( 'jquery');
			$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
		}
	}
}
