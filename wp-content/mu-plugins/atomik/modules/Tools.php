<?php 

namespace ATMK;

class Tools
{

	/**
	 * Get a meta value
	 *
	 * @param string $key
	 * @param int|object $post_id
	 * @param boolean $acf
	 *
	 * @return mixed
	 *
	 * @uses ATMK\Tools::get_meta('data');
	 */
	public static function get_meta( $key, $post_id = NULL, $acf = FALSE ){
		if( is_null($post_id) ){
			$post_id = get_the_ID();

		}elseif( is_object($post_id) ){
			$post_id = $post_id->ID;
		}

		if( ! $post_id ){
			return FALSE;
		}

		if( $acf && function_exists('get_field') ){
			$val = get_field( $key, $post_id );

		}else{
			$val = get_post_meta( $post_id, $key, TRUE );
		}

		return $val;
	}

	/**
	 * Echo a meta value
	 *
	 * @param string $key
	 * @param int|object $post_id
	 * @param boolean $acf
	 *
	 * @return mixed
	 *
	 * @uses PARDESIGN\tools->the_meta('data');
	 */
	public static function the_meta( $key, $post_id = NULL, $acf = FALSE ){
		echo self::get_meta( $key, $post_id, $acf );
	}

	/**
	 * Checks if current host is PAR Design DEV server
	 *
	 * @uses site_url()
	 *
	 * @return boolean is this the dev server?
	 */
	public static function is_lab(){
		return ( stripos(site_url(), 'pardesignlab') !== FALSE or stripos(site_url(), 'partest') !== FALSE or stripos(site_url(), 'parfab') !== FALSE );
	}

	/**
	 * Checks if current host is a local test server
	 *
	 * @uses site_url()
	 *
	 * @return boolean is this a local server?
	 */
	public static function is_local(){
		return ( stripos(site_url(), 'localhost') !== FALSE );
    }
    
    public static function array( $array, $key, $default = NULL ){
		if( array_key_exists($key, $array) ){
			return $array[$key];
		}

		return $default;
	}

	public static function get( $key, $default = NULL ){
		if( array_key_exists($key, $_GET) ){
			return $_GET[$key];
		}

		return $default;
	}

	public static function post( $key, $default = NULL ){
		if( array_key_exists($key, $_POST) ){
			return $_POST[$key];
		}

		return $default;
	}
}