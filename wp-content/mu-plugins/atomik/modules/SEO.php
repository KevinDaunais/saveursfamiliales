<?php 

namespace ATMK;

class SEO
{
	public static function boot(){
		Core::add_action( 'init', ['SEO', 'init'] );

		if( apply_filters('atmk/seo/use_opengraph', FALSE) ){
			Core::add_filter( 'wpseo_opengraph_title', ['SEO', 'wpseo_opengraph_title'], 100, 1 );
			Core::add_filter( 'wpseo_opengraph_desc', ['SEO', 'wpseo_opengraph_desc'], 100, 1 );
            Core::add_action( 'wpseo_add_opengraph_images', ['SEO', 'wpseo_opengraph_image'] );
		}

		add_filter( 'wpseo_metabox_prio', function(){ return 'low'; } );
	}

	public static function init(){
		if( Tools::is_lab() ){
			self::block_robots();
		}
	}

	/**
	 * Writes the robots.txt file on the lab
	 *
	 * @see init()
	 * @see is_lab()
	 */
	public static function block_robots(){
		$robots_path    = ABSPATH . 'robots.txt';
		$robots_content = "User-agent: *\nDisallow: /";

		if( ! file_exists($robots_path) ){
			$fh = fopen( $robots_path, 'w' );

			if( $fh ){
				fwrite( $fh, $robots_content );
			}
		}
	}

	public static function get_og_meta( $type ){
		$og_fields = get_field( 'options_og_fields', 'options' );

		if( $og_fields ){
			foreach( $og_fields as $field ){
				if( $field['post_type'] == get_post_type() ){
					return $field[$type];
				}
			}
		}

		return FALSE;
	}

	public static function wpseo_opengraph_title( $title ){
		$og_field = self::get_og_meta( 'title' );

		if( $og_field && is_null($title) ){
			$title = $og_field;
		}

		return $title;
	}

	public static function wpseo_opengraph_desc( $desc ){
		$og_field = self::get_og_meta('description');

		if( $og_field && is_null($desc) ){
			$desc = $og_field;
		}

		return $desc;
	}

	public static function wpseo_opengraph_image( $object ){
		$og_field = self::get_og_meta('featured');

		if( $og_field ){
			$size   = 'large';
			$thumb  = $og_field['sizes'][ $size ];
			$width  = $og_field['sizes'][ $size . '-width' ];
			$height = $og_field['sizes'][ $size . '-height' ];

			$image = [
				'url'    => $thumb, 
				'height' => $height, 
				'width'  => $width,
			];
			
			$object->add_image( $image );
		}
	}
}
