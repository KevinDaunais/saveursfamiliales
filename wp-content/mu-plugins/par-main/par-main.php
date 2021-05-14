<?php
/**
 * Plugin Name: PAR Design Plugin Template
 * Plugin URI: http://pardesign.net
 * Description: Template and tools for other PAR Design plugins
 * Version: 1.0.0
 * Author: PAR Design
 * Author URI: http://pardesign.net
 * Requires at least: 4.1
 * Tested up to: 4.6
 *
 * @package pardesign
 * @category Core
 * @author PARDesign
 * @version 2.0.0
 */

// change all instances
namespace PAREXT;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( '\\' . __NAMESPACE__ . '\\Plugin' ) ) {

class Plugin
{
	const DEBUG = FALSE;

	/**
	 * Plugin version, match with plugin header
	 * @var string
	 */
	public $version = '1.0.0';

	public $file = __FILE__;

	/**
	 * Holds this class' singleton instance
	 * @internal use plugin() to instantiate and/or get the instance of this class
	 *
	 * @var PAREXT\Plugin
	 */
	protected static $_instance = NULL;

	/**
	 * Holds all the registered internal libraries used by this plugin
	 * @internal
	 *
	 * @see $this->register_lib()
	 * @see $this->get()
	 * @var array
	 */
	private $registered_libs = [];

	/**
	 * Holds all the instantiated internal libraries used by this plugin
	 * @internal
	 *
	 * @see $this->includes()
	 * @see $this->get()
	 * @var array
	 */
	private $libs = [];

	/**
	 * Retrieve this class' singleton instance
	 * @internal You should use plugin() to instantiate and/or get the instance of this class
	 *
	 * @author PARDesign/scyr
	 * @since 1.0.0
	 *
	 * @return PAREXT\Plugin
	 */
	public static function instance() {

		if( is_null( static::$_instance ) ){
			static::$_instance = new static();
		}

		return static::$_instance;
	}

	/**
	 * Use the function not the variable
	 * @var string
	 */
	public $plugin_url;

	/**
	 * Use the function not the variable
	 * @var string
	 */
	public $plugin_path;

	/**
	 * Do we update the rewrite rules for a custom post type?
	 * @var boolean
	 */
	public $flush_rules = FALSE;

	/**
	 * PLUGIN STARTUP
	 */
	public function __construct(){

		if( ! is_subclass_of($this, '\\PAREXT\\Plugin') ){
			spl_autoload_register([ $this, 'autoload' ]);
		}

		$installed = get_option( get_class($this) . '_Version', FALSE );

		if( ! $installed or version_compare($installed, $this->version, '!=') ){
			add_action( 'init', [$this, 'activate'], 2 );
			update_option( get_class($this) . '_Version', $this->version );
		}

		$this->load_modules();
		$this->hooks();
	}

	/**
	 * Autoload non-existant classes
	 *
	 * @author PARDesign/scyr
	 * @since 1.0.0
	 *
	 * @param string $class The name of the class to autoload
	 */
	public function autoload( $class ){

		$class_path_parts = explode( '\\', $class );

		if( $class_path_parts[0] == 'PAREXT' ){

			array_shift( $class_path_parts );
			$file = strtolower( array_pop($class_path_parts) ) . '.php';

			$class_path_parts = array_map( 'strtolower', $class_path_parts );
			$path             = plugin_dir_path( __FILE__ ) . implode( '/', $class_path_parts ) . '/' . $file;

			if( is_readable($path) ){
				include_once $path;
			}
		}
	}

	public function activate(){
		add_action( 'wp', [$this, 'flush_rules'] );
	}

	public function deactivate(){
		add_action( 'wp', [$this, 'flush_rules'] );
	}

	public function flush_rules(){
		flush_rewrite_rules( FALSE );
	}

	/**
	 * Register a library for the get function
	 *
	 * @author PARDesign/scyr
	 * @since 1.0.0
	 *
	 * @param  string $id    The internal id to use to retreive the library
	 * @param  string $class The class name for the library
	 * @param  bool   $load  Instantiate the library after registering it
	 * @return object|null   If $load is true, returns the instantiated library
	 */
	public function register_lib( $id, $class, $load = FALSE, $args = array() ){
		$this->registered_libs[ $id ] = $class;

		if( $load ){
			return $this->get( $id, TRUE, $args );
		}
	}

	/**
	 * Gets the requested library from the registered libraries in the includes() function
	 *
	 * @author PARDesign/scyr
	 * @since 1.0.0
	 *
	 * @param  string $lib The slug of the library to load
	 * @param  bool   $new Force create a new instance
	 * @return object      The requested library
	 */
	public function get( $lib, $new = FALSE, $args = array() ){
		try {
			if( ! array_key_exists($lib, $this->registered_libs) ){
				throw new \Exception( "Error, requested library \"$lib\" is not registered.", 1 );
			}

			if( ! array_key_exists($lib, $this->libs) or $new ){

				if( $args ){
					$r = new \ReflectionClass( $this->registered_libs[$lib] );
					$this->libs[ $lib ] = clone $r->newInstanceArgs( $args );

				}else{
					$this->libs[ $lib ] = new $this->registered_libs[ $lib ]();
				}
			}

			return $this->libs[ $lib ];

		}catch( Exception $e ){
			error_log( $e->getMessage() );
		}
	}

	/**
	 * Manually register an existing object
	 *
	 * @author PARDesign/scyr
	 * @since 1.0.0
	 *
	 * @param string $lib    The slug of the library to register
	 * @param object $object The object to register
	 * @return object        The object passed right through
	 */
	public function set( $lib, $object ){

		if( ! array_key_exists($lib, $this->registered_libs) ){
			$this->registered_libs[ $lib ] = get_class( $object );
		}

		$this->libs[ $lib ] = $object;

		return $object;
	}

	public function __get( $get ){
		if( array_key_exists($get, $this->registered_libs) ){
			return $this->get( $get );
		}
	}

	public function load_modules(){
		$this->register_lib( 'tools', 'PAREXT\App\Modules\Tools', TRUE, [$this] ); // register ajax and load other modules
	}

	public function hooks(){
	}
}

/**
 * Gets a singleton instance of the plugin class
 *
 * @author PARDesign/scyr
 * @since 1.0.0
 *
 * @return PAREXT\Plugin This class' instance
 */
function plugin(){
	return Plugin::instance();
}
plugin();

} // class_exists check
