<?php
/**
 * Plugin Name: PAR Design backend client
 * Plugin URI: https://pardesign.net
 * Description: Backend épuré pour les clients
 * Version: 1.0.0
 * Author: (PAR Design)
 * Author URI: https://pardesign.net
 * Requires at least: 4.1
 * Tested up to: 4.1
 *
 * @package PAR_client_backend
 * @category Core
 * @author PARDesign
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'PAR_Client_Backend' ) ) {

class PAR_Client_Backend
{
	const DEBUG = FALSE;

	/**
	 * Plugin version, match with plugin header
	 * @var string
	 */
	public $version = '1.0.2';

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
		// do something when we activate/deactivate the plugin
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		$installed = get_option( 'PAR_Client_Backend_Version', FALSE );

		if( ! $installed or version_compare($installed, $this->version, '!=') ){
			$this->flush_rules = TRUE;
			update_option( 'PAR_Client_Backend_Version', $this->version );
			$this->runonce();
		}

		$this->hooks();
	}

	/**
	 * Runs only if plugin version changed
	 */
	public function runonce(){

		#add_filter( 'admin_client_capabilities', array($this, 'admin_client_woocommerce') );
		#add_filter( 'admin_client_capabilities', array($this, 'admin_client_aec_calendar') );
		#add_filter( 'admin_client_capabilities', array($this, 'admin_client_tribe_calendar') );

		add_filter( 'editable_roles', array($this, 'editable_roles') );
		add_filter( 'map_meta_cap', array($this, 'map_meta_cap'), 10, 4 );

		$this->add_roles();
	}

	public function admin_client_woocommerce( $capabilities ){

		$new_caps = array(
			'manage_woocommerce'			=> TRUE,
			'view_woocommerce_reports'		=> TRUE
		);

		$capability_types = array( 'product', 'shop_order', 'shop_coupon', 'shop_webhook' );

		foreach ( $capability_types as $capability_type ) {
			$new_caps["edit_{$capability_type}"] 				= TRUE;
			$new_caps["read_{$capability_type}"] 				= TRUE;
			$new_caps["delete_{$capability_type}"] 				= TRUE;
			$new_caps["edit_{$capability_type}s"] 				= TRUE;
			$new_caps["edit_others_{$capability_type}s"] 		= TRUE;
			$new_caps["publish_{$capability_type}s"] 			= TRUE;
			$new_caps["read_private_{$capability_type}s"] 		= TRUE;
			$new_caps["delete_{$capability_type}s"] 			= TRUE;
			$new_caps["delete_private_{$capability_type}s"] 	= TRUE;
			$new_caps["delete_published_{$capability_type}s"]	= TRUE;
			$new_caps["delete_others_{$capability_type}s"] 		= TRUE;
			$new_caps["edit_private_{$capability_type}s"] 		= TRUE;
			$new_caps["edit_published_{$capability_type}s"]		= TRUE;
			$new_caps["manage_{$capability_type}_terms"] 		= TRUE;
			$new_caps["edit_{$capability_type}_terms"] 			= TRUE;
			$new_caps["delete_{$capability_type}_terms"] 		= TRUE;
			$new_caps["assign_{$capability_type}_terms"] 		= TRUE;
		}

		$capabilities += $new_caps;

		return $capabilities;
	}

	public function admin_client_aec_calendar( $capabilities ){

		$new_caps = array(
			'aec_add_events'			=> TRUE,
			'aec_manage_calendar'		=> TRUE,
			'aec_manage_events'			=> TRUE,
		);

		$capabilities += $new_caps;

		return $capabilities;
	}

	public function admin_client_tribe_calendar( $capabilities ){

		$new_caps = array(
			'delete_others_tribe_events'			=> TRUE,
			'delete_others_tribe_organizers'		=> TRUE,
			'delete_others_tribe_venues'			=> TRUE,
			'delete_private_tribe_events'			=> TRUE,
			'delete_private_tribe_organizers'		=> TRUE,
			'delete_private_tribe_venues'			=> TRUE,
			'delete_published_tribe_events'			=> TRUE,
			'delete_published_tribe_organizers'		=> TRUE,
			'delete_published_tribe_venues'			=> TRUE,
			'delete_tribe_events'					=> TRUE,
			'delete_tribe_organizers'				=> TRUE,
			'delete_tribe_venues'					=> TRUE,
			'edit_others_tribe_events'				=> TRUE,
			'edit_others_tribe_organizers'			=> TRUE,
			'edit_others_tribe_venues'				=> TRUE,
			'edit_private_tribe_events'				=> TRUE,
			'edit_private_tribe_organizers'			=> TRUE,
			'edit_private_tribe_venues'				=> TRUE,
			'edit_published_tribe_events'			=> TRUE,
			'edit_published_tribe_organizers'		=> TRUE,
			'edit_published_tribe_venues'			=> TRUE,
			'edit_tribe_events'						=> TRUE,
			'edit_tribe_organizers'					=> TRUE,
			'edit_tribe_venues'						=> TRUE,
			'publish_tribe_events'					=> TRUE,
			'publish_tribe_organizers'				=> TRUE,
			'publish_tribe_venues'					=> TRUE,
			'read_private_tribe_events'				=> TRUE,
			'read_private_tribe_organizers'			=> TRUE,
			'read_private_tribe_venues'				=> TRUE,
		);

		$capabilities += $new_caps;

		return $capabilities;
	}

	public function add_roles(){
		$capabilities = array(
			'level_1' 					=> TRUE,
			'activate_plugins'			=> FALSE,
			'create_users'				=> TRUE,
			'delete_others_pages'		=> TRUE,
			'delete_others_posts'		=> TRUE,
			'delete_pages'				=> TRUE,
			'delete_plugins'			=> FALSE,
			'delete_posts'				=> TRUE,
			'delete_private_pages'		=> TRUE,
			'delete_private_posts'		=> TRUE,
			'delete_published_pages'	=> TRUE,
			'delete_published_posts'	=> TRUE,
			'delete_themes'				=> FALSE,
			'delete_users'				=> TRUE,
			'edit_dashboard'			=> TRUE,
			'edit_files'				=> FALSE,
			'edit_others_pages'			=> TRUE,
			'edit_others_posts'			=> TRUE,
			'edit_pages'				=> TRUE,
			'edit_plugins'				=> FALSE,
			'edit_posts'				=> TRUE,
			'edit_private_pages'		=> TRUE,
			'edit_private_posts'		=> TRUE,
			'edit_published_pages'		=> TRUE,
			'edit_published_posts'		=> TRUE,
			'edit_theme_options'		=> TRUE,
			'edit_themes'				=> FALSE,
			'edit_users'				=> TRUE,
			'export'					=> TRUE,
			'import'					=> FALSE,
			'install_plugins'			=> FALSE,
			'install_themes'			=> FALSE,
			'list_users'				=> TRUE,
			'manage_categories'			=> TRUE,
			'manage_links'				=> TRUE,
			'manage_options'			=> TRUE,
			'moderate_comments'			=> FALSE,
			'promote_users'				=> TRUE,
			'publish_pages'				=> TRUE,
			'publish_posts'				=> TRUE,
			'read'						=> TRUE,
			'read_private_pages'		=> TRUE,
			'read_private_posts'		=> TRUE,
			'remove_users'				=> TRUE,
			'switch_themes'				=> FALSE,
			'unfiltered_html'			=> TRUE,
			'update_core'				=> FALSE,
			'update_plugins'			=> FALSE,
			'update_themes'				=> FALSE,
			'upload_files'				=> TRUE,
			'gform_full_access'			=> TRUE,
			'wpml_manage_languages'		=> TRUE,
		);

		remove_role( 'admin_client' );
		add_role( 'admin_client', 'Admin client', apply_filters('admin_client_capabilities', $capabilities) );
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
		$this->flush();

		$current_user = wp_get_current_user();

		if ( in_array( 'admin_client', $current_user->roles ) ) {

			// Clean admin menu and admin bar
			add_action( 'admin_menu', array($this, 'edit_menus'), 999 );
			add_action( 'wp_before_admin_bar_render', array($this, 'remove_admin_bar_links') );

			// Hide update notices
			add_filter('pre_site_transient_update_core', array($this, 'remove_core_updates') );
			add_filter('pre_site_transient_update_plugins', array($this, 'remove_core_updates') );
			add_filter('pre_site_transient_update_themes', array($this, 'remove_core_updates') );

			// Clean dashboard
			add_action( 'wp_dashboard_setup', array($this, 'edit_dashboard_widgets') );
			add_filter( 'screen_layout_columns', array($this, 'screen_layout_columns') );
			add_filter( 'get_user_option_screen_layout_dashboard', array($this, 'screen_layout_dashboard') );
			add_filter( 'contextual_help', array($this, 'remove_dashboard_help_tab'), 999, 3 );
			add_filter( 'screen_options_show_screen', array($this, 'remove_help_tab') );
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
			add_filter('editable_roles', array($this, 'remove_higher_levels'));
		}

		$this->customize_login();

		$this->customize_theme();

		add_filter( 'login_headertext', [$this, 'login_headertext'] );

		add_action( 'login_message', [$this, 'login_message'] );
	}

	/**
	 * Refresh rewrite rules
	 */
	public function flush(){
		if( $this->flush_rules )
			flush_rewrite_rules();
	}

	public function activate(){
		$this->flush_rules = TRUE; // we will need to refresh the rewrite rules for the custom post types
	}

	public function deactivate(){
		$this->flush_rules = TRUE; // refresh the rewrite rules for the custom post types which are no longuer loaded
	}

	public function edit_menus(){
		remove_menu_page( 'edit-comments.php' );										// Remove the comments menu
		remove_menu_page( 'tools.php' );												// Remove the tools menu
		remove_menu_page( 'themes.php' );												// Remove the themes menu
		remove_menu_page( 'options-general.php' );										// Remove the settings menu
		remove_menu_page( 'vc-general' );												// Remove the Visual Composer menu
		remove_menu_page( 'wpseo_dashboard' );											// Remove the SEO menu
		remove_menu_page( 'edit.php?post_type=acf' );									// Remove the ACF menu
		remove_menu_page( 'themepunch-google-fonts' );									// Remove the Punch Fonts menu
		remove_menu_page( 'sucuriscan' );												// Remove the Sucuri menu
		remove_menu_page( 'itsec' );													// Remove the iThemes menu
		remove_menu_page( 'edit.php?post_type=acf-field-group' );						// Remove the ACF menu
		remove_menu_page( 'wpml-translation-management/menu/translations-queue.php' );	// Remove the WPML menu

		global $menu;

	    add_menu_page( 'Menus', 'Menus', 'edit_theme_options', 'nav-menus.php', '', 'dashicons-menu', 99);	// Add Menus menu
	}

	public function remove_admin_bar_links(){
		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('wp-logo');          			// Remove the WordPress logo
		$wp_admin_bar->remove_menu('about');            			// Remove the about WordPress link
		$wp_admin_bar->remove_menu('wporg');            			// Remove the WordPress.org link
		$wp_admin_bar->remove_menu('documentation');    			// Remove the WordPress documentation link
		$wp_admin_bar->remove_menu('support-forums');   			// Remove the support forums link
		$wp_admin_bar->remove_menu('feedback');         			// Remove the feedback link
		$wp_admin_bar->remove_menu('updates');          			// Remove the updates link
		$wp_admin_bar->remove_menu('comments');         			// Remove the comments link
		$wp_admin_bar->remove_menu('wpseo-menu');					// Remove the SEO link
		$wp_admin_bar->remove_menu('vc_inline-admin-bar-link');		// Remove the Visual Composer link
		$wp_admin_bar->remove_menu('itsec_admin_bar_menu');			// Remove the iThemes security link
	}

	public function remove_core_updates(){
		global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
	}

	public function edit_dashboard_widgets(){
		global $wp_meta_boxes;

		$wp_meta_boxes['dashboard']['normal']['core'] = array();
   		$wp_meta_boxes['dashboard']['side']['core'] = array();

   		wp_add_dashboard_widget('dashboard_widget', 'Bienvenue dans le tableau de bord de votre site !', array( $this, 'par_design_dashboard_widget' ) );
	}

	public function par_design_dashboard_widget( $post, $callback_args ){
		?>

		<h2>Les KPI de votre site</h2>

		<ul>
			<li>[Mettre les KPI ici!]</li>
		</ul>

		<br />----------------------------------------------------

		<h2>Voici quelques trucs et astuces à savoir :</h2>

		<p>
			<strong>Indexation de votre site</strong>
			<br />----------------------------
			<br />Nous avons soumis votre site aux principaux moteurs de recherche. Normalement dans un délais de +/- 10 jours votre site devrait être indexé dans les répertoires de ces engins de recherche.
		</p>

		<p>
			<strong>Répandez la bonne nouvelle</strong>
			<br />----------------------------
			<br />Plus vous aller parler de votre site, mieux il se portera. Il est important de créer des liens avec d'autres sites pour augementer votre crédibilité avec les engins de recherche. Publiez votre adresse sur vos outils de communications et dans vos sites de médias sociaux également tel que Facebook.
		</p>

		<p>
			<strong>Statistiques</strong>
			<br />----------------------------
			<br />Vous recevrez les statistiques de votre site internet par courriel à chaque 1er du mois. (<a href="mailto:support@pardesign.net">Contactez-nous</a> si vous ne recevez pas votre rapport de statistique mensuel) Si vous désirez en savoir plus, vous pouvez nous envoyer une adresse GMAIL et nous allons vous donner accès à votre compte.
		</p>

		<p>
			<strong>Mises à jour</strong>
			<br />----------------------------
			<br />La clef du succès de votre site web est sans aucun doute la mise à jour de votre contenu. Les engins de recherche adorent le contenu frais et nouveau. Prenez le temps de nous envoyer vos modifications de textes, photos, promotions, etc. Pour vos demandes de modifications et de mises à jour, utilisez notre système de support en envoyant vos demandes à l'adressse : <a href="mailto:support@pardesign.net">support@pardesign.net</a>
		</p>

		<p>
			<strong>Assurance qualité</strong>
			<br />----------------------------
			<br />Nous avons mis en place un système d'assurance qualité pour votre site web. Voici une énumération des vérifications effectuées par notre équipe lors de la mise en ligne:

		</p>

		<ul style="list-style-type: disc; padding-left: 15px;">
			<li>Nous avons mise à jour Wordpress et ses extensions au moment de cet envoi</li>
			<li>Nous avons mise à jour et configuré adéquatement les extensions de sécurités au moment de cet envoi</li>
			<li>Nous avons configuré un système de "cache" pour accélérer votre site</li>
			<li>Nous avons créé un utilisateur et un mot de passe temporaire pour vous</li>
			<li>Nous avons simplifié l'interface du panneau d'administration pour vous</li>
			<li>Nous avons configuré un système de backup et de versionnage de votre site.</li>
			<li>Nous avons créé une page introuvable 404</li>
			<li>Nous avons ajouté une icone de favoris (favicon)</li>
			<li>Nous avons créé des redirections si vous aviez un ancien site web</li>
			<li>Nous avons configuré l'envois des statistiques de votre site à votre courriel (Google Analytics)</li>
			<li>Nous avons relié votre site à Google Search Console pour des statistiques plus poussées si nécessaire</li>
			<li>Nous avons ajouté votre site à notre système de "monitoring" et ainsi être averti si votre site n'est plus en ligne</li>
			<li>Nous avons testé chaque page avec un mot clefs principal pour s'assurer d'un bon référencement (SEO Yoast)</li>
			<li>Nous avons testé chaque page pour être sur que les contenus et les liens soient adéquats</li>
			<li>Nous avons testé les différents formulaires présents sur votre site web</li>
			<li>Nous avons testé l'optimisation du site web pour une meilleure vitesse de chargement</li>
			<li>Nous avons testé le site dans les navigateurs les plus populaires (IE, Firefox, Chrome, Safari)</li>
			<li>Nous avons testé le site sur tablettes et mobiles les plus populaires (iOS et Android)</li>
		</ul>

		----------------------------
		<br /><br /><img src="https://pardesign.net/login-logo.png" alt="PAR Design" />

		<?php
	}

	public function screen_layout_columns($columns){
		$columns['dashboard'] = 1;
		return $columns;
	}

	public function screen_layout_dashboard() { return 1; }

	public function remove_dashboard_help_tab( $old_help, $screen_id, $screen ){
	    if( 'dashboard' != $screen->base )
	        return $old_help;

	    $screen->remove_help_tabs();
	    return $old_help;
	}

	public function remove_help_tab( $visible ){
	    global $current_screen;
	    if( 'dashboard' == $current_screen->base )
	        return false;
	    return $visible;
	}

	public function login_headertext(){
		return 'PAR Design - Agence Web';
	}

	public function login_message( $msg ){
		
		if( $this->is_lab() ){
			return '<p class="message" style="border-left-color: #c00;">SITE DE DÉVELOPPEMENT</p>';
		
		}elseif( $this->is_local() ){
			return '<p class="message" style="border-left-color: #0c0;">SITE LOCAL</p>';
		}

		return $msg;
	}

	/**
	 * Change login logo and logo link and maybe design aswell
	 */
	public function customize_login(){
		add_action( 'login_head', array($this, 'login_logo') );
		add_filter( 'login_headerurl', array($this, 'login_url') );
	}

	public function login_logo(){ ?>
		<style>
		    body.login>#login a:hover { color: #00a7ca; }
			body.login>#login p.message {  border-left: 4px solid #00a7ca; }
			body.login { background-image: url('<?php echo $this->imgURL('par-bg.jpg'); ?>'); background-repeat: no-repeat; background-size: cover;  }
	    	.login h1 a { background-image: url('<?php echo $this->imgURL('logo.png'); ?>'); width: 186px; height: 200px; background-size: cover; margin-bottom: 20px; }

			@media (max-width: 968px) { body.login .left-text, body.login .right-text { visibility: hidden;} }

			@font-face {
			  font-family: 'Gotham-Bold';
			  src: url('<?php echo $this->fontsPATH('gotham/Gotham-Bold.eot?#iefix'); ?>') format('embedded-opentype'),
			  	   url('<?php echo $this->fontsPATH('gotham/Gotham-Bold.otf'); ?>')  format('opentype'),
				   url('<?php echo $this->fontsPATH('gotham/Gotham-Bold.woff'); ?>') format('woff'),
				   url('<?php echo $this->fontsPATH('gotham/Gotham-Bold.ttf'); ?>')  format('truetype'),
				   url('<?php echo $this->fontsPATH('gotham/Gotham-Bold.svg#Gotham-Bold'); ?>') format('svg');
			  font-weight: normal;
			  font-style: normal;
			}
			@font-face {
			  font-family: 'Gotham-Book';
			  src: url('<?php echo $this->fontsPATH('gotham/Gotham-Book.eot?#iefix'); ?>') format('embedded-opentype'),
				   url('<?php echo $this->fontsPATH('gotham/Gotham-Book.otf'); ?>')  format('opentype'),
				   url('<?php echo $this->fontsPATH('gotham/Gotham-Book.woff'); ?>') format('woff'),
				   url('<?php echo $this->fontsPATH('gotham/Gotham-Book.ttf'); ?>')  format('truetype'),
				   url('<?php echo $this->fontsPATH('gotham/Gotham-Book.svg#Gotham-Book'); ?>') format('svg');
			  font-weight: normal;
			  font-style: normal;
			}

			#login form p.submit .button-primary {
				width: 100%; background-color: #00a7ca; border-color: #00a7ca;
				color: #fff; font-family: 'Gotham-Bold'; text-transform: uppercase;
				font-size: 13px; letter-spacing: 0em; transition: all 0.3s ease; box-shadow: none;
				padding:5px 0 5px 0; text-shadow: none;
				box-sizing: content-box;
			}
			#login { padding-top: 200px; }
			#loginform { padding: 26px 24px; }
			#login form p.submit .button-primary:hover { background-color: #221F1F; color: #fff;  border-color: #221F1F; }
			#login form p.submit .button-primary:focus { outline: none;  }
			#login .forgetmenot { margin: 0 0 15px 0; }
			#login #nav, #login #backtoblog { margin: 0; }
			#login #nav a, #login #backtoblog a { font-size: 12px; color: #fff; }
			#login #nav { margin: 10px 0 0 0; }
		</style>
	<?php }

	/**
	 * Helper function get getting roles that the user is allowed to create/edit/delete.
	 *
	 * @param   WP_User $user
	 * @return  array
	 */
	public function get_allowed_roles( $user ) {
	    $allowed = array();

	    if ( in_array( 'administrator', $user->roles ) ) { // Admin can edit all roles
	        $allowed = array_keys( $GLOBALS['wp_roles']->roles );
	    } elseif ( in_array( 'admin_client', $user->roles ) ) {
	        $allowed[] = 'admin_client';
	        $allowed[] = 'editor';
	    }

	    return $allowed;
	}

	/**
	 * Remove roles that are not allowed for the current user role.
	 */
	public function editable_roles( $roles ) {
	    if ( $user = wp_get_current_user() ) {
	        $allowed = $this->get_allowed_roles( $user );

	        foreach ( $roles as $role => $caps ) {
	            if ( ! in_array( $role, $allowed ) )
	                unset( $roles[ $role ] );
	        }
	    }

	    return $roles;
	}

	/**
	 * Prevent users deleting/editing users with a role outside their allowance.
	 */
	public function map_meta_cap( $caps, $cap, $user_ID, $args ) {
	    if ( ( $cap === 'edit_user' || $cap === 'delete_user' ) && $args ) {
	        $the_user = get_userdata( $user_ID ); // The user performing the task
	        $user     = get_userdata( $args[0] ); // The user being edited/deleted

	        if ( $the_user && $user && $the_user->ID != $user->ID /* User can always edit self */ ) {
	            $allowed = $this->get_allowed_roles( $the_user );

	            if ( array_diff( $user->roles, $allowed ) ) {
	                // Target user has roles outside of our limits
	                $caps[] = 'not_allowed';
	            }
	        }
	    }

	    return $caps;
	}
	
	/*
	*	Filters out roles with better permissions than current user
	*/
	function remove_higher_levels($all_roles) {
		$user = wp_get_current_user();
		$next_level = 'level_' . ($user->user_level + 1);

		foreach ( $all_roles as $name => $role ) {
			if (isset($role['capabilities'][$next_level])) {
				unset($all_roles[$name]);
			}
		}

		return $all_roles;
	}

	public function login_url(){
		return 'https://pardesign.net';
	}

	public function customize_theme(){
		add_action( 'admin_enqueue_scripts', [$this, 'customize_theme_css'] );
	}

	public function customize_theme_css(){
		wp_enqueue_style( 'admin-theme-css', $this->cssURL('admin-theme.css'), [], $this->version, 'screen' );
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

	public function fontsPATH( $file ){
		return $this->plugin_url() . "/assets/fonts/{$file}";
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
	 * Checks if current host is a local test server
	 *
	 * @uses site_url()
	 *
	 * @return boolean is this a local server?
	 */
	public function is_local(){
		return ( stripos(site_url(), 'localhost') !== FALSE );
	}
}

// Init Class and register in global scope
$GLOBALS['par_client_backend'] = new PAR_Client_Backend();

} // class_exists check
