<?php

namespace ATMK;

class Files
{
	const LOCATE_PARENT = 1;
	const LOCATE_CHILD  = 2;
	const LOCATE_BOTH   = self::LOCATE_PARENT|self::LOCATE_CHILD;

	public static function boot(){
		Core::add_filter( 'sanitize_file_name', ['Files', 'sanitize_filename_on_upload'], 10 );
	}

	/**
	 * Return the path of a file after it has been located in the child or parent theme
	 *
	 * @param string $file The path to a file relative to a theme folder
	 *
	 * @return string The path to the located file or FALSE if file is not found
	 */
	public static function locate_file_path( $file, $mode = self::LOCATE_BOTH ){

		if( $mode & self::LOCATE_CHILD && is_readable( get_stylesheet_directory() . '/' . $file ) ){
			return get_stylesheet_directory() . '/' . $file;

		}elseif( $mode & self::LOCATE_PARENT && is_readable( get_template_directory() . '/' . $file ) ){
			return get_template_directory() . '/' . $file;
		}

		return FALSE;
	}

	public static function locate_file_url( $file, $mode = self::LOCATE_BOTH ){

		if( $mode & self::LOCATE_CHILD && is_readable( get_stylesheet_directory() . '/' . $file ) ){
			return get_stylesheet_directory_uri() . '/' . $file;

		}elseif( $mode & self::LOCATE_PARENT && is_readable( get_template_directory() . '/' . $file ) ){
			return get_template_directory_uri() . '/' . $file;
		}

		return FALSE;
	}

	/**
	 * Get the contents of a file
	 *
	 * @param  string $file file name for which to get the contents
	 *
	 * @return string       path for the file
	 */
	public static function read_file( $file, $mode = self::LOCATE_BOTH ){
		$file_path = self::locate_file_path( $file, $mode );

		if( ! $file_path ){
			return '';
		}

		return file_get_contents( $file_path );
	}

	/**
	 * Make sure filenames are clean by removing accents
	 *
	 * @param  string $filename original filename
	 *
	 * @return string           sanitized filename
	 */
	 public static function sanitize_filename_on_upload( $filename ){

		if( stripos($filename, '-migrate-') !== FALSE ){
			return $filename;
		}

 		$sanitized_filename = remove_accents($filename); // Convert to ASCII

 		// Standard replacements
 		$invalid = array(
 			' ' => '-',
 			'%20' => '-',
 			'_' => '-'
 		);
 		$sanitized_filename = str_replace(array_keys($invalid), array_values($invalid), $sanitized_filename);

 		$sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
 		$sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
 		$sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
 		$sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
 		$sanitized_filename = strtolower($sanitized_filename); // Lowercase

 		return $sanitized_filename;
 	}
}