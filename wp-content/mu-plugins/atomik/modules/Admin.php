<?php 

namespace ATMK;

class Admin
{
	public static function boot(){
		// Fixes issue with autocomplete in login form with Chrome by removing the code which clears the password field
		Core::add_action( 'login_form', ['Admin', 'kill_wp_attempt_focus_start'] );
		Core::add_action( 'login_footer', ['Admin', 'kill_wp_attempt_focus_end'] );
		
		Core::add_action( 'load-tools_page_wp-migrate-db-pro', ['Admin', 'remove_sanitize_migratedb'], 1 );
		
		add_filter( 'deprecated_constructor_trigger_error', '__return_false' );

		Core::add_action( 'admin_enqueue_scripts', ['Admin', 'admin_enqueue_scripts'] );
		Core::add_action( 'admin_body_class', ['Admin', 'admin_body_class'] );
		Core::add_action( 'init', ['Admin', 'admin_init'] );

		Core::add_action( 'admin_notices', ['Admin', 'par_info'] );
		
		Core::add_action( 'wp_before_admin_bar_render', ['Admin', 'admin_bar_render'] );
		Core::add_action( 'admin_head', ['Admin', 'style_tool_bar'] );
		Core::add_action( 'wp_head', ['Admin', 'style_tool_bar'] );

		Core::add_filter( 'acf/prepare_field', ['Admin', 'block_direct_link'] );
		Core::add_filter( 'acf/fields/flexible_content/layout_title', ['Admin', 'custom_flex_title'], 10, 4 );

		Core::add_action( 'acf/input/admin_footer', ['Admin', 'custom_acf_colorpicker'] );

		Core::add_action('wp_dashboard_setup', ['Admin', 'edit_dashboard_widgets']);

		Core::add_filter( 'mce_buttons_2', ['Admin', 'enable_more_buttons'] );
	}

	public static function kill_wp_attempt_focus_start(){
		ob_start( [ 'ATMK\Admin', 'kill_wp_attempt_focus_replace' ] );
	}

	public static function kill_wp_attempt_focus_replace( $html ){
		return preg_replace( "/d.value = '';/", "", $html );
	}

	public static function kill_wp_attempt_focus_end(){
		ob_end_flush();
	}

	public static function remove_sanitize_migratedb(){
		remove_filter( 'sanitize_file_name', array('ATMK\Files', 'sanitize_filename_on_upload'), 10 );
	}


	
	public static function admin_enqueue_scripts(){
		Scripts::enqueue_style( 'admin-dev', 'theme/modules/admin.css' );

		if( apply_filters('atmk/admin/gutenberg_admin', FALSE) ){

			Scripts::enqueue_style( 'admin-gutenberg', 'gutenberg.css' );
			Scripts::enqueue_script( 'lazysize', 'lazysizes-all.min.js' );
		}
		wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', '', '5.8.1', 'all' );
	}

	public static function admin_init(){

		if( function_exists('acf_add_options_page') ) {

			acf_add_options_page( apply_filters('atmk/options_page', [
				'page_title' 	=> 'Options',
				'menu_title'	=> 'Options',
				'menu_slug' 	=> 'atmk-options',
				'redirect'		=> FALSE
			]));
		}

		if( function_exists('acf_update_setting') ){
			acf_update_setting( 'remove_wp_meta_box', TRUE );
		}

		// Disable support for comments and trackbacks in post types
		foreach (get_post_types() as $post_type) {
			if (post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}
	
	public static function skip_comment_count_query( $count, $post_id ) {

		if ( 0 === $post_id ) {
			$stats = array(
				'approved'       => 0,
				'moderated'      => 0,
				'spam'           => 0,
				'trash'          => 0,
				'post-trashed'   => 0,
				'total_comments' => 0,
				'all'            => 0,
			);

			return (object) $stats;
		}
	}

	public static function admin_body_class( $classes ){

		if( Tools::is_local() ){
			$classes .= ' is-localhost';

		}elseif( Tools::is_lab() ){
			$classes .= ' is-lab';
		}

		return $classes;
	}

	public static function block_direct_link( $field ){

		if( $field['key'] == 'field_5d4332b17489f' )
			$field['instructions'] = '<br/>';

		if( $field['key'] == 'field_5d4332b174c64' && $field['value'] )
			$field['instructions'] = get_permalink() .'#'. sanitize_title($field['value']);

		elseif( $field['key'] == 'field_5d4332b174c64' && ! $field['value'] )
			$field['instructions'] = '<br/>';

		return $field;
	}

		/**
	 * Writes the robots.txt file on the lab
	 *
	 * @see init()
	 * @see is_lab()
	 */
	public static function admin_bar_render() {		
		global $wp_admin_bar;

		$site_type = '';

		if( Tools::is_lab() )
			$site_type = __('SITE DE DÉVELOPPEMENT');

		elseif( Tools::is_local() )
			$site_type = __('SITE LOCAL');

		$site_type = apply_filters( 'atmk/admin_bar/site_type', $site_type );

		if( $site_type ){
			$wp_admin_bar->add_node( array(
				'id'    => 'par_dev', // link ID, defaults to a sanitized title value
				'title' => $site_type,
			));
		}

	}

	public static function edit_dashboard_widgets() {
   		wp_add_dashboard_widget( 'dashboard_widget', 'Les KPI de votre site', array( 'ATMK\Admin', 'kpi_dashboard_widget_display' ) );
	}
		
	public static function kpi_dashboard_widget_display(){
		do_action( 'atmk/dashboard/kpi' );
	}

	public static function custom_flex_title( $title, $field, $layout, $i ){

		$block_class = $layout;
		$layouts     = $block_class['name'] . '_';
		$options     = get_sub_field( $layouts . 'options' );

		$block_layout = $title;
		
		if( $options ){

			if( Tools::array($options, 'block_anchor') ){
	
				$url = get_permalink() . '#' . sanitize_title( $options['block_anchor'] );
	
				$title  = '<span>' . $options['block_anchor'] . ' <small><em>(' . $block_layout . ') </em></small></span>';
				$title .= "<a href='{$url}' target='_blank'><span class='dashicons dashicons-external'></span></a>";
			}
		}

		
		// return
		return $title;
	}

	public static function output_the_colors() {

		$color_palette = get_field('options_colorpicker', 'options');

		if ( ! $color_palette ) return;

		ob_start();

		echo '[';
			foreach ( $color_palette as $color ) {
				echo "'" . $color['color'] . "', ";
			}
		echo ']';

		return ob_get_clean();
	}

	public static function custom_acf_colorpicker(){

		echo Files::read_file( 'images/admin-icons.svg' );

		$color_palette = self::output_the_colors();

		if ( ! $color_palette ) return;

		?>

		<script type="text/javascript">
		(function( $ ) {
			acf.add_filter( 'color_picker_args', function( args, $field ){
				args.palettes = <?php echo $color_palette; ?>;
				return args;
			});
		})(jQuery);
		</script>

		<?php
	}

	public static function style_tool_bar() {	

		$site_color = '';

		if( Tools::is_lab() )
			$site_color = '#9e0000';

		elseif( Tools::is_local() )
			$site_color = '#066411';

		$site_color = apply_filters( 'atmk/admin_bar_color', $site_color );

		ob_start();
		
		?>
		<style type="text/css">
			#wpadminbar {
				background: <?php echo $site_color; ?>;
			}
			#wp-admin-bar-par_dev .ab-item {
				font-size: 1.5em;
				font-weight: bold;
			}
		</style>
		<?php
		
		echo ob_get_clean();
	}

	public static function par_info(){
		?>
		<div class="notice notice-info">
			<p><?php echo apply_filters( 'atmk/kpi_notice', 'Les KPI du site!' ); ?></p>
		</div>
		<?php 
	}
	
	public static function enable_more_buttons( $buttons ){
		$buttons[] = 'superscript';
		$buttons[] = 'subscript';
		return $buttons;
	}
}