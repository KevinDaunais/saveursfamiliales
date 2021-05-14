<?php 

namespace ATMK;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( '\\' . __NAMESPACE__ . '\\Core' ) ) {

class Core
{
	const VERSION = '1.0.1';

	public static $parent = FALSE;
	public static $child  = FALSE;

	public static function boot(){
		spl_autoload_register(__NAMESPACE__ .'\Core::autoload');

		self::add_action( 'atmk/register_theme', ['Core', 'register_theme'] );

		self::load_modules();
		self::load_fields();
	}

	/**
	 * add_filter for use by modules. Removes the need to specify the ATMK namespace.
	 *
	 * @param [type] $tag
	 * @param [type] $callback
	 * @param integer $priority
	 * @param integer $accepted_args
	 *
	 * @return void
	 */
	public static function add_filter( $tag, $callback, $priority = 10, $accepted_args = 1 ){
		$callback[0] = __NAMESPACE__ . '\\' . $callback[0];
		add_filter( $tag, $callback, $priority, $accepted_args );
	}

	/**
	 * add_action for use by modules. Removes the need to specify the ATMK namespace.
	 *
	 * @param [type] $tag
	 * @param [type] $callback
	 * @param integer $priority
	 * @param integer $accepted_args
	 *
	 * @return void
	 */
	public static function add_action( $tag, $callback, $priority = 10, $accepted_args = 1 ){
		$callback[0] = __NAMESPACE__ . '\\' . $callback[0];
		add_action( $tag, $callback, $priority, $accepted_args );
	}

	public static function load_modules(){
		ACF::boot();
		Admin::boot();
		Files::boot();
		Gravityforms::boot();
		Lang::boot();
		Scripts::boot();
		SEO::boot();
		Shortcodes::boot();
		Template::boot();
	}

	public static function load_fields(){

		if( ! function_exists('acf_add_local_field_group') ){
			return;
		}

		$groups = [
			'main'   => [],
			'parent' => [],
			'child'  => [],
		];

		$path  = plugin_dir_path( __FILE__ ) . 'fields/group_*.php';
		$files = glob( $path );

		foreach( $files as $group_file ){
			$config = include $group_file;
			$groups['main'][ $config['key'] ] = $config;
		}

		$path  = get_template_directory() . '/fields/group_*.php';
		$files = glob( $path );

		foreach( $files as $group_file ){
			$config = include $group_file;
			$groups['parent'][ $config['key'] ] = $config;
		}

		if( Core::$parent != Core::$child ){
			$path  = get_stylesheet_directory() . '/fields/group_*.php';
			$files = glob( $path );

			foreach( $files as $group_file ){
				$config = include $group_file;
				$groups['child'][ $config['key'] ] = $config;
			}
		}

		$merged_groups = self::merge_groups( $groups );

		foreach( $merged_groups as $group ){
			acf_add_local_field_group( $group );
		}
	}

	public static function merge_groups( $groups ){
		$merged_groups = [];

		foreach( $groups['main'] as $key => $main_group ){
			
			$merge = [];

			if( $main_group['active'] ){
				$merge[] = $main_group;
			}

			if( array_key_exists($key, $groups['parent']) ){
				if( $groups['parent'][$key]['active'] ){
					$merge[] = $groups['parent'][$key];
				}

				unset( $groups['parent'][$key] );
			}

			if( array_key_exists($key, $groups['child']) ){
				if( $groups['child'][$key]['active'] ){
					$merge[] = $groups['child'][$key];
				}

				unset( $groups['child'][$key] );
			}

			if( sizeof($merge) > 1 ){
				$merged_groups[] = call_user_func_array( 'array_replace_recursive', $merge );
				
			}else{
				$merged_groups[] = $main_group;
			}
		}

		foreach( $groups['parent'] as $key => $parent ){

			$merge = [];

			if( $parent['active'] ){
				$merge[] = $parent;
			}

			if( array_key_exists($key, $groups['child']) ){
				if( $groups['child'][$key]['active'] ){
					$merge[] = $groups['child'][$key];
				}

				unset( $groups['child'][$key] );
			}

			if( sizeof($merge) > 1 ){
				$merged_groups[] = call_user_func_array( 'array_replace_recursive', $merge );
				
			}else{
				$merged_groups[] = $parent;
			}
			
		}

		if( sizeof($groups['child']) ){
			$merged_groups = array_merge( $merged_groups, $groups['child'] );
		}

		return $merged_groups;
	}

	public static function register_theme( $class ){
		if( ! self::$child ){
			self::$child = $class;
		}
		self::$parent = $class;
	}

	public static function get_theme_version(){
		return self::call_theme_method( 'version' );
	}

	/**
	 * Find a method in either child or parent theme.
	 *
	 * @param string $method_name
	 *
	 * @return string The Theme Class containing the method.
	 */
	public static function locate_theme_method( string $method_name ){
		if( method_exists( self::$child, $method_name ) ){
			return self::$child;

		}else if ( method_exists( self::$parent, $method_name ) ) {
			return self::$parent;
		}

		return FALSE;
	}

	/**
	 * Call a method in the child theme or parent theme if it doesn't exist in the child theme.-acf
	 *
	 * @param string $method_name
	 * @param array $args
	 *
	 * @return mixed The function result or NULL if the method does not exist.
	 */
	public static function call_theme_method( string $method_name, $args = [] ){
		if( method_exists( self::$child, $method_name ) ){
			return call_user_func_array( [self::$child, $method_name], $args );

		} else if ( method_exists( self::$parent, $method_name ) ) {
			return call_user_func_array( [self::$parent, $method_name], $args );
		}

		return NULL;
	}

	public static function autoload( $class ){
		$class_path_parts = explode( '\\', $class );

		if( $class_path_parts[0] == 'ATMK' ){

			array_shift( $class_path_parts );
			$path = plugin_dir_path( __FILE__ ) . 'modules/' . implode( '/', $class_path_parts ) . '.php';

			if( is_readable($path) ){
				include_once $path;
			}
		}
	}
}

add_action( 'plugins_loaded', ['ATMK\Core', 'boot'] );

} // ! class_exists