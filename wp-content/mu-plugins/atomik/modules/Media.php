<?php 

namespace ATMK;

class Media
{


    /**
	 * Display contents of image file
	 *
	 * @param  string $file file name for which to get the path
	 *
	 * @return string       path for the file
	 */
	public static function output_img( $file, $mode = Files::LOCATE_BOTH ){
		echo self::read_file( $file, $mode );
	}

	/**
	 * Get the contents of a file
	 *
	 * @param  string $file file name for which to get the contents
	 *
	 * @return string       path for the file
	 */
	public static function read_file( $file, $mode = Files::LOCATE_BOTH ){
		$file_path = self::locate_file( $file, $mode );

		if( ! $file_path ){

			if( stripos('.svg', $file) !== FALSE ){
				return "<img src='{$file}' alt='svg' title='Inline SVG can only be displayed when image is local, using svg image instead.' />";
			}

			return '';
		}

		return file_get_contents( $file_path );
    }

    /**
	 * Return the path of a file after it has been located in the child or parent theme
	 *
	 * @param string $file The path to a file relative to a theme folder
	 *
	 * @return string The path to the located file or FALSE if file is not found
	 */
	public static function locate_file( $file, $mode = Files::LOCATE_BOTH ){

		if( $mode & Files::LOCATE_CHILD && is_readable( get_stylesheet_directory() . '/' . $file ) ){
			return get_stylesheet_directory() . '/' . $file;

		}elseif( $mode & Files::LOCATE_PARENT && is_readable( get_template_directory() . '/' . $file ) ){
			return get_template_directory() . '/' . $file;
		} elseif( $mode & Files::LOCATE_PARENT && is_readable( get_template_directory() . '/' . $file ) ){
			return get_template_directory() . '/' . $file;
		}

		return FALSE;
    }

	/**
	 * Get the url for an image file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the image
	 */
	public static function img_url( $file, $mode = Files::LOCATE_BOTH ){
		echo self::get_img_url( $file, $mode );
	}
	/**
	 * Get the url for an image file
	 *
	 * @param  string $file file name for which to get the url
	 *
	 * @return string       url for the image
	 */
	public static function get_img_url( $file, $mode = Files::LOCATE_BOTH ){
		return Files::locate_file_url( "images/{$file}", $mode );
	}
	/**
	 * Get the path for an image file
	 *
	 * @param  string $file file name for which to get the path
	 *
	 * @return string       path for the image
	 */
	public static function get_img_path( $file, $mode = Files::LOCATE_BOTH ){
		return Files::locate_file_path( "images/{$file}", $mode );
	}

	/**
	 * Responsive BG image and lazyloaded
	 *
	 * @param array $image_data the id of the image (from ACF or similar)
	 * @param string $image_size the size of the thumbnail image or custom image size
	 * @param string $image_class
	 */
	public static function set_bg( $image_data, $image_size, $image_class ){

		if( ! empty($image_data['ID']) ) {

			$sizes = wp_get_attachment_image_sizes( $image_data['ID'], $image_size );
			$bgset = wp_get_attachment_image_srcset( $image_data['ID'], $image_size );

			if( ! $bgset && ! empty($image_data['sizes'][$image_size]) ){
				$bgset = $image_data['sizes'][$image_size];
			}

			if( ! $bgset ){
				$bgset       = wp_get_attachment_image_src( $image_data['ID'], 'full' );
				$bgset       = $bgset[0];
				$ie_fallback = wp_get_attachment_image_src( $image_data['ID'], 'full' );
			}

			if( is_string($image_data) ){
				$bgset       = $image_data . ', 1920vw';
				$ie_fallback = $image_data;
			} else {
				$bg          = wp_get_attachment_image_src( $image_data['ID'], $image_size );
				$ie_fallback = $bg[0];
			}

			echo 'class="' . esc_html($image_class) . ' lazyload" data-bgset="' . esc_html($bgset) . '" data-sizes="' . esc_html($sizes) . '" data-ie="' . $ie_fallback . '"';
		}else{
			echo 'class="' . esc_html($image_class) . ' lazyload"';
		}
	}

	/**
	 * Responsive Image Helper Function
	 *
	 * @param string $image_id the id of the image (from ACF or similar)
	 * @param string $image_size the size of the thumbnail image or custom image size
	 * @param string $max_width the max width this image will be shown to build the sizes attribute
	 */
	public static function responsive_image( $image_id, $image_size, $max_width ){
		if( $image_id != '' ){
			$image_src    = wp_get_attachment_image_url( $image_id, $image_size );
			$image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );
			echo 'src="' . $image_src . '" srcset="' . $image_srcset . '" sizes="(max-width: ' . $max_width . ') 100vw, ' . $max_width . '"';

		}
	}
}