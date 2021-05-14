<?php 

namespace PAREXT\App\Modules;

class Tools{

	private $parent;
	private $url;
	private $path;

	public function __construct( $parent ){
		$this->parent = $parent;
		$this->url    = plugin_dir_url( $this->parent->file );
		$this->path   = plugin_dir_path( $this->parent->file );
	}

	public function plugin_path(){
		return untrailingslashit( $this->path );
	}

	public function plugin_url(){
		return untrailingslashit( $this->url );
	}

	/**
	 * Get the url for an image file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the image
	 */
	public function img_url( $file ){
		echo $this->get_img_url( $file );
	}
	/**
	 * Get the url for an image file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the image
	 */
	public function get_img_url( $file ){
		return $this->url . "assets/images/{$file}";
	}
	/**
	 * Get the path for an image file
	 *
	 * @param  string $file file name for which to get the path
	 *
	 * @return string       path for the image
	 */
	public function get_img_path( $file ){
		return $this->path . "assets/images/{$file}";
	}

	/**
	 * Get the url for a JS file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the js file
	 */
	public function get_js_url( $file ){
		return $this->url . "assets/js/{$file}";
	}
	/**
	 * Get the path for a JS file
	 *
	 * @param  string $file file name for which to get the path
	 *
	 * @return string       path for the js file
	 *
	 */
	public function get_js_path( $file ){
		return $this->path . "assets/js/{$file}";
	}

	/**
	 * Get the url for a CSS file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the css file
	 */
	public function get_css_url( $file ){
		return $this->url . "assets/css/{$file}";
	}
	/**
	 * Get the path for a CSS file
	 *
	 * @param  string $file file name for which to get the path
	 *
	 * @return string       path for the css file
	 */
	public function get_css_path( $file ){
		return $this->path . "assets/css/{$file}";
	}

	/**
	 * Wrapper for registering ajax calls
	 * @param  string $action the action name for the ajax
	 */
	public function register_ajax( $action, $object = NULL ){

		if( is_null($object) ){
			$object = $this->parent;
		}

		add_action( "wp_ajax_$action", array($object, 'ajax_' . $action) );
		add_action( "wp_ajax_nopriv_$action", array($object, 'ajax_' . $action) );
	}

	/**
	 * Wrapper for add_action, links to current object or the specified one
	 *
	 * @param string $tag
	 * @param string $function_to_add
	 * @param integer $priority
	 * @param integer $accepted_args
	 */
	public function add_action( $tag, $function_to_add = '', $priority = 10, $accepted_args = 1, $object = NULL ){

		if( is_null($object) ){
			$object = $this->parent;
		}

		if( empty($function_to_add) ){
			$function_to_add = $tag;
		}

		add_action( $tag, [$object, $function_to_add], $priority, $accepted_args );
	}

	/**
	 * Wrapper for add_filter, links to current object or the specified one
	 *
	 * @param string $tag
	 * @param string $function_to_add
	 * @param integer $priority
	 * @param integer $accepted_args
	 */
	public function add_filter( $tag, $function_to_add = '', $priority = 10, $accepted_args = 1, $object = NULL ){
		if( is_null($object) ){
			$object = $this->parent;
		}

		if( empty($function_to_add) ){
			$function_to_add = $tag;
		}

		add_filter( $tag, [$object, $function_to_add], $priority, $accepted_args );
	}

	public function get( $key, $default = NULL ){
		if( array_key_exists($key, $_GET) ){
			return $_GET[$key];
		}

		return $default;
	}

	public function post( $key, $default = NULL ){
		if( array_key_exists($key, $_POST) ){
			return $_POST[$key];
		}

		return $default;
	}
}
