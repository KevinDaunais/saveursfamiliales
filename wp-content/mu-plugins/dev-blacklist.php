<?php
/**
 * Plugin Name: Development Plugins Blacklist
 * Plugin URI: http://pardesign.net
 * Description: Extension pour la prévention de l'activation de certaines extensions sur les serveurs de dévelopment.
 * Version: 2.0.1
 * Author: PAR Design
 * Author URI: http://pardesign.net
 * Requires at least: 4.1
 * Tested up to: 4.6
 *
 * @package PARDesignMU
 * @category Core
 * @author PARDesign
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'PAR_DEVBlacklist' ) ) {

class PAR_DEVBlacklist
{
	const DEBUG = FALSE;

	/**
	 * Plugin version, match with plugin header
	 * @var string
	 */
	public $version = '1.0.0';

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

	private $blacklist = array(
		'lab' => array(
			'wpmandrill/wpmandrill.php',
			'mailchimp-for-wp/mailchimp-for-wp.php',
			'mailchimp-sync/mailchimp-sync.php',
			'cimy-swift-smtp/cimy_swift_smtp.php',
		),
		'loc' => array(
			'better-wp-security/better-wp-security.php',
			'ithemes-security-pro/ithemes-security-pro.php',
			'wpmandrill/wpmandrill.php',
			'mailchimp-for-wp/mailchimp-for-wp.php',
			'mailchimp-sync/mailchimp-sync.php',
			'cimy-swift-smtp/cimy_swift_smtp.php',
			'updraftplus/updraftplus.php',
			'w3-total-cache/w3-total-cache.php',
		)
	);

	private $forced_options = array(
		'live' => array(
			'blog_public' => '1',
			'itsec_active_modules' => array(
				'ban-users'           => 1,
				'brute-force'         => 1,
				'backup'              => 0,
				'network-brute-force' => 1,
				'strong-passwords'    => 1,
				'wordpress-tweaks'    => 1,
				'file-change'         => 1,
				'system-tweaks'       => 1,
				'404-detection'       => 1,
			),
		),
		'lab' => array(
			'blog_public' => '0',
		),
		'loc' => array(
			'blog_public' => '0',
		),
	);

	private $active = array();

	/**
	 * PLUGIN STARTUP
	 */
	public function __construct(){

		add_filter( 'option_active_plugins', array($this, 'filter_active_plugins'), 1 );

		/*$forced_options = $this->get_forced_options();
		foreach( $forced_options as $fo => $value ){
			add_filter( "option_{$fo}", array($this, 'filter_forced_option') );
		}*/
	}

	/**
	 * @todo http://php.net/manual/en/function.array-replace-recursive.php
	 */
	public function filter_forced_option(){
		$current_filter = current_filter();
		$current_filter = str_replace( 'option_', '', $current_filter );

		$forced_options = $this->get_forced_options();
		$current_option = $forced_options[ $current_filter ];

		return $current_option;
	}

	public function get_forced_options(){
		if( $this->is_lab() ){
			return $this->forced_options['lab'];
			
		}elseif( $this->is_local() ){
			return $this->forced_options['loc'];

		}else{
			return $this->forced_options['live'];
		}
	}

	public function filter_active_plugins(){
		global $wpdb;

		$active = $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} WHERE option_name = 'active_plugins'" );
		$active = maybe_unserialize( $active );

		if( $this->is_lab() ){
			return array_diff( $active, $this->blacklist['lab'] );
			
		}elseif( $this->is_local() ){
			return array_diff( $active, $this->blacklist['loc'] );

		}else{
			return $active;
		}
	}

	/**
	 * Checks if current host is PAR Design DEV server
	 *
	 * @uses site_url()
	 *
	 * @return boolean is this the dev server?
	 */
	public function is_lab(){
		return ( stripos(site_url(), 'pardesignlab') !== FALSE or stripos(site_url(), 'partest') !== FALSE or stripos(site_url(), 'parfab') !== FALSE );
	}

	/**
	 * Checks if current host is local server
	 *
	 * @uses site_url()
	 *
	 * @return boolean is this the dev server?
	 */
	public function is_local(){
		return ( stripos(site_url(), 'localhost') !== FALSE );
	}

	/**
	 * Register the plugin's hooks
	 */
	public function hooks(){
		add_action( 'init', array($this, 'init'), 0 );
	}

	/**
	 * Runs on WordPress init hook
	 */
	public function init(){

	}

	public function imgURL( $file ){
		return $this->plugin_url() . "/assets/images/{$file}";
	}

	public function jsURL( $file ){
		return $this->plugin_url() . "/assets/js/{$file}";
	}
	public function jsPATH( $file ){
		return $this->plugin_path() . "/assets/js/{$file}";
	}

	public function cssURL( $file ){
		return $this->plugin_url() . "/assets/css/{$file}";
	}
	public function cssPATH( $file ){
		return $this->plugin_path() . "/assets/css/{$file}";
	}

	/**
	 * Get the plugin url.
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_url() {
		if ( $this->plugin_url ) return $this->plugin_url;
		return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;
		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
}

// Init Class and register in global scope
$GLOBALS['PAR_DEVBlacklist'] = new PAR_DEVBlacklist();

} // class_exists check
