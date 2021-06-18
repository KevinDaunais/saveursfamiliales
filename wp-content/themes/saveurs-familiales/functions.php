<?php 

namespace ATMK;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( '\\' . __NAMESPACE__ . '\\ParentTheme' ) ) {

class ParentTheme
{
    

	public static function version(){
		return '1.0.0';
	}

	public static function boot(){
		Template::add_action( 'atmk/sidebars', 'sidebars' );
		//Template::add_action( 'wp_footer', 'add_huddle' );
		
		Template::add_filter( 'atmk/template_favicons_colors', 'favicons_colors' );
		Template::add_filter( 'atmk/kpi_notice', 'kpi_notice' );

		Template::add_action( 'atmk/enqueue_scripts', 'enqueue_scripts' );
        Template::add_action( 'atmk/enqueue_styles', 'enqueue_styles' );
        Template::add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

        Template::add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
        Template::add_filter( 'woocommerce_enqueue_styles', '__return_false' );
        
        Template::add_action('acf/init', 'init_par_flexs');
        Template::add_filter( 'block_categories', 'block_categories', 10, 2 );
	}

    

	public static function enqueue_scripts(){
		//wp_dequeue_style('wp-block-library');
		wp_deregister_script('comment-reply');

		Scripts::enqueue_script('lazysizes', 'lazysizes-all.min.js');
		Scripts::enqueue_script('slick', 'slick.min.js');
		
		$deps = [ 'lazysizes', 'slick' ];
		add_filter( 'atmk/scripts/main/deps', function( $_deps ) use ( $deps ) {
			return array_merge( $_deps, $deps );
		});
	}



    function woocommerce_header_add_to_cart_fragment( $fragments ) {
        global $woocommerce;
    
        ob_start();
    
        ?>
        <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> – <?php echo $woocommerce->cart->get_cart_total(); ?></a>
        <?php
        $fragments['a.cart-customlocation'] = ob_get_clean();
        return $fragments;
    }

    public static function mytheme_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }
    
    

	public static function enqueue_styles(){
		//Scripts::enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700' );	
	}

	public static function favicons_colors(){
		return [
			'theme' => '#ffffff',
			'title'	=> '#e4022e',
		];
	}

	public static function par_kpi(){
		return 'Les KPI du site!';
	}

	public static function get_terms_page_id(){
		return 3;
	}

	public static function sidebars( $sidebars ){
		return $sidebars;
	}

	public static function add_huddle(){
        ?>
        <script>
            (function (d, t, g) {
                var ph    = d.createElement(t), s = d.getElementsByTagName(t)[0];
                ph.type   = 'text/javascript';
                ph.async   = true;
                ph.charset = 'UTF-8';
                ph.src     = g + '&v=' + (new Date()).getTime();
                s.parentNode.insertBefore(ph, s);
            })(document, 'script', '//parxp.ca/?p=17074&ph_apikey=979d000cfd8145007a6d90636fa3a76c');
        </script>
        <?php
    }

    public static function get_post_terms( \WP_Post $post, $taxonomy ){
				
        $taxonomies = wp_get_post_terms($post->ID, $taxonomy);

		$list = [];

		if ($taxonomies) {

			foreach ($taxonomies as $taxonomy) {
				$list[] = $taxonomy->name;
			}
		}

		return $list;
	}
	

    public static function block_categories( $categories, $post ) {

        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'par-flex',
                    'title' => __( 'Blocs Flex PAR Atomic', 'my-plugin' ),
                    'icon'  => '<svg class="fa paratomic"><use xlink:href="#paratomic"></use></svg>',
                ),
            )
        );
    }
    
    public static function init_par_flexs(){

        if( function_exists('acf_register_block_type') ) {

            acf_register_block_type(array(
                'name'              => 'intro_block',
                'title'             => __('Bloc Introduction'),
                'render_template'   => 'parts/page/layouts/layout-intro_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa paratomic"><use xlink:href="#paratomic"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'slider_block',
                'title'             => __('Bloc Diaporama'),
                'render_template'   => 'parts/page/layouts/layout-slider_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-slider"><use xlink:href="#bloc-slider"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'doc_block',
                'title'             => __('Bloc Documents'),
                'render_template'   => 'parts/page/layouts/layout-doc_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-doc"><use xlink:href="#bloc-doc"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'regular_block',
                'title'             => __('Bloc Contenu régulier'),
                'render_template'   => 'parts/page/layouts/layout-regular_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-intro"><use xlink:href="#bloc-intro"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'table_block',
                'title'             => __('Bloc Tableau'),
                'render_template'   => 'parts/page/layouts/layout-table_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-table"><use xlink:href="#bloc-table"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'accs_block',
                'title'             => __('Bloc Accordéons'),
                'render_template'   => 'parts/page/layouts/layout-accs_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-acc"><use xlink:href="#bloc-acc"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'team_block',
                'title'             => __('Bloc Équipe'),
                'render_template'   => 'parts/page/layouts/layout-team_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-team"><use xlink:href="#bloc-team"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'grid_block',
                'title'             => __('Bloc Grille'),
                'render_template'   => 'parts/page/layouts/layout-grid_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-grid"><use xlink:href="#bloc-grid"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'video_block',
                'title'             => __('Bloc Vidéo'),
                'render_template'   => 'parts/page/layouts/layout-video_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-video"><use xlink:href="#bloc-video"></use></svg>',
            ));

            acf_register_block_type(array(
                'name'              => 'gallery_block',
                'title'             => __('Bloc Galerie'),
                'render_template'   => 'parts/page/layouts/layout-gallery_block.php',
                'category'          => 'par-flex',
                'icon'              => '<svg class="fa bloc-gallery"><use xlink:href="#bloc-gallery"></use></svg>',
            ));
        }
    }
}

do_action( 'atmk/register_theme', __NAMESPACE__ . '\ParentTheme' );
ParentTheme::boot();

}
