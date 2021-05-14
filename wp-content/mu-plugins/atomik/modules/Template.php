<?php 

namespace ATMK;

class Template
{

	/**
	 * Adds an action but for templates only. Makes it possible to override actions in child theme.
	 *
	 * @param string $tag
	 * @param string $method_name
	 * @param integer $priority
	 * @param integer $accepted_args
	 *
	 * @return void
	 */
	public static function add_action( $tag, $method_name, $priority = 10, $accepted_args = 1 ){
		$class = Core::locate_theme_method( $method_name );

		if( $class ){
			add_action( $tag, [$class, $method_name], $priority, $accepted_args );
		}
	}

	/**
	 * Adds a filter but for templates only. Makes it possible to override filters in child theme.
	 *
	 * @param string $tag
	 * @param string $method_name
	 * @param integer $priority
	 * @param integer $accepted_args
	 *
	 * @return void
	 */
	public static function add_filter( $tag, $method_name, $priority = 10, $accepted_args = 1 ){
		$class = Core::locate_theme_method( $method_name );

		if( $class ){
			add_filter( $tag, [$class, $method_name], $priority, $accepted_args );
		}
	}

	public static function boot(){
		Core::add_action( 'init', ['Template', 'init'] );
		Core::add_action( 'after_setup_theme', ['Template', 'after_setup_theme'] );

		Core::add_action( 'wp_head', ['Template', 'wp_head'], 1 );
		Core::add_action( 'wp_footer', ['Template', 'wp_footer'] );

		Core::add_filter( 'body_class', ['Template', 'custom_taxonomy_in_body_class'] );
		Core::add_filter( 'body_class', ['Template', 'server_body_class'] );
		Core::add_filter( 'body_class', ['Template', 'browser_body_class'] );
		Core::add_filter( 'post_class', ['Template', 'post_class'] );

		Core::add_filter( 'intermediate_image_sizes_advanced', ['Template', 'remove_default_image_sizes'] );

		if( apply_filters('atmk/the_content/remove_easy_image_gallery', TRUE) ){
			remove_filter( 'the_content', 'easy_image_gallery_append_to_content' );
		}

		Core::add_action( 'widgets_init', ['Template', 'prevent_js_composer_update_check'] );

		Core::add_action( 'admin_menu', ['Template', 'custom_menu_page_removing'], 999 );
		Core::add_action( 'pre_current_active_plugins', ['Template', 'hide_plugin_list'], 998 );
	}

	public static function init(){
		self::sidebars();
		self::menus();
	}

	public static function after_setup_theme(){
		add_theme_support( 'post-thumbnails' );
	}

	public static function sidebars(){
		$sidebars = apply_filters( 'atmk/sidebars', [
			'blog-sidebar' => [
				'id' 			=> 'blog-sidebar',
				'name' 			=> 'Sidebar blogue',
				'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h3>',
				'after_title' 	=> '</h3>',
			],
		]);

		foreach( $sidebars as $sidebar ){
			register_sidebar( $sidebar );
		}
	}

	public static function menus(){
		register_nav_menus( apply_filters( 'atmk/menus', array(
			'main-nav'   => __( 'Navigation principale', 'atmk-core' ),
			'mobile-nav' => __( 'Navigation mobile', 'atmk-core' ),
			'footer-nav' => __( 'Navigation footer', 'atmk-core' ),
		)));
	}

	public static function wp_head(){
		global $is_IE;

		if( $is_IE ){ ?>
			<!--[if lt IE 9]>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
			<![endif]-->
		<?php } ?>

		<link rel="profile" href="https://gmpg.org/xfn/11" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<?php

		self::favicons();
	}

	/**
	 * Output favicon html in html's head
	 *
	 * @see wp_head()
	 */
	public static function favicons(){

		$colors = apply_filters( 'atmk/template_favicons_colors', [
			'theme' => '#ffffff',
			'title'	=> '#e4022e',
		]);

		ob_start();

		?>
		<link rel="apple-touch-icon" sizes="180x180" href="<?php Media::img_url( 'favicons/apple-touch-icon.png' ) ?>">
		<link rel="icon" type="image/png" href="<?php Media::img_url( 'favicons/favicon-32x32.png' ) ?>" sizes="32x32">
		<link rel="icon" type="image/png" href="<?php Media::img_url( 'favicons/favicon-16x16.png' ) ?>" sizes="16x16">
		<link rel="manifest" href="<?php Media::img_url( 'favicons/site.webmanifest' ) ?>">
		<link rel="mask-icon" href="<?php Media::img_url( 'favicons/safari-pinned-tab.svg' ) ?>" color="<?php echo $colors['title'] ?>">
		<meta name="msapplication-TileColor" content="<?php echo $colors['title'] ?>">
		<meta name="theme-color" content="<?php echo $colors['theme'] ?>">
		<?php

		$favicons = ob_get_clean();

		echo apply_filters( 'atmk/favicons', $favicons );
	}

	/**
	 * Add some classes to the post wrapper
	 *
	 * @param  string $classes original classes for the post wrapper
	 *
	 * @return string          modified classes for the post wrapper
	 */
	public static function post_class( $classes ){
		$classes[] = 'cf'; // add float clearing class
		return $classes;
	}

	public static function wp_footer(){
		echo Files::read_file( 'images/icons.svg' );
	}

	public static function get_terms_page_id(){
		return Core::call_theme_method( 'get_terms_page_id' );
	}

	public static function pagination_prefix( $format ){

		$number = intval( $format );

		if( intval( $number / 10 ) > 0 ) {
			return $format;
		}

		return '0' . $format;
	}

	/**
	 * Output theme pagination for archives
	 */
	public static function archive_pagination(){
		global $wp_query, $wp_rewrite;

		$current = ( $wp_query->query_vars['paged'] > 1 )? $wp_query->query_vars['paged'] : 1;

		Core::add_filter( 'number_format_i18n', ['Template', 'pagination_prefix'] );

		$pagination = array(
			'base'    => @add_query_arg( 'page','%#%' ),
			'format'  => '',
			'total'   => $wp_query->max_num_pages,
			'current' => $current,
			'show_all' => FALSE,
			'end_size' => 1,
			'mid_size' => 2,
			'type'      => 'list',
			'next_text' => __('Voir d’autres articles', 'par-design-theme'),
			'prev_text' => '&lt;',
			'add_args'  => [],
		);

		if( $wp_rewrite->using_permalinks() ){
			$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

			$base   = remove_query_arg( 's', get_pagenum_link( 1, FALSE ) );
			$parsed = parse_url( $base );

			if( ! empty($parsed['query']) ){
				$clean = str_replace( '/?' . $parsed['query'], '', $base );
				$pagination['base'] = user_trailingslashit( trailingslashit( $clean ) . 'page/%#%/', 'paged' ) . '?' . $parsed['query'];
			}
		}

		if( !empty($wp_query->query_vars['s']) )
			$pagination['add_args']['s'] = get_query_var('s');

		$pagination = apply_filters( 'atmk/pagination', $pagination );

		echo paginate_links( $pagination );

		remove_filter( 'number_format_i18n', 'pagination_prefix' );
	}

	public static function get_archive_button( $type ){
		error_log('Warning: This function needs to be defined.');
		return '';
	}

	public static function get_post_date(){
		$date = Core::call_theme_method( 'get_post_date' );

		if( $date ){
			return $date;
		}

		return get_the_date();
	}
	
	/**
	 * Add taxonomy classes to body tag
	 *
	 * @param  string $classes original classes
	 *
	 * @return string          modified classes
	 */
	public static function custom_taxonomy_in_body_class( $classes ){
		if( is_singular('product') or is_tax('category_product') ){
			$custom_terms = get_the_terms(0, 'category_product');

			if( $custom_terms && ! is_wp_error($custom_terms) ){
				foreach( $custom_terms as $custom_term ){
					if( $custom_term->parent ){
						$custom_term = get_term( $custom_term->parent, 'category_product' );
					}

					$classes[] = 'term-' . $custom_term->slug;
				}
			}
		}

		return $classes;
	}

	public static function server_body_class( $classes ){
		if( Tools::is_local() ){
			$classes[] = ' is-localhost';

		}elseif( Tools::is_lab() ){
			$classes[] = ' is-lab';
		}

		return $classes;
	}

	public static function browser_body_class( $classes ){
		// the list of WordPress global browser checks
		// https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans
		$browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];

		$classes[] = join(' ', array_filter($browsers, function ($browser) {
			return $GLOBALS[$browser];
		}));

		return $classes;
	}

	/**
	 * Remove unused default Wordpress image size
	 * 
	 * thumbnail, medium, medium_large, large
	 */
	public static function remove_default_image_sizes( $sizes ){
		return apply_filters( 'atmk/image_sizes', $sizes );
	}

	public static function prevent_js_composer_update_check(){
		wp_clear_scheduled_hook('wpb_check_for_update');
	}

	public static function custom_menu_page_removing(){
		$user = wp_get_current_user();

		if( ! strpos($user->user_email, '@pardesign.net') ){
			remove_menu_page( 'activity_log_page' );
		}
	}

	public static function hide_plugin_list(){
		global $wp_list_table;
		$user = wp_get_current_user();

		if( ! strpos($user->user_email, '@pardesign.net') ){

			$hidearr = array('aryo-activity-log/aryo-activity-log.php');

			$myplugins = $wp_list_table->items;

			foreach( $myplugins as $key => $val ){
				if( in_array($key,$hidearr) )
					unset($wp_list_table->items[$key]);
			}
		}
	}

	public function dev_responsive(){
		if( apply_filters('atmk/footer/show_mobile_warn', Tools::is_lab()) ) : ?>

		<div class="mobile__dev">
			<svg class='fa fa-warning'><use xlink:href='#fa-warning'></use></svg>
			<h3>Pas si vite!</h3>
			<span>Notre version mobile est présentement en processus de création.<br>Veuillez utiliser un <strong>ordinateur</strong> pour consulter le site web</span>
		</div>

		<?php endif;
	}

	/**
	 * Load a component into a template while supplying data.
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param array $params An associated array of data that will be extracted into the templates scope
	 * @param bool $output Whether to output component or return as string.
	 * @return string
	 */
	public static function get_component( $slug, $data = [] ) {
		set_query_var( 'component_data', $data );
		get_template_part( $slug );
	}
	
}