<?php 

namespace ATMK;

class Lang
{

	const DEFAULT_LANG    = 'fr';
	const OVERRIDE_LOCALE = FALSE;

	public static function boot(){
		self::define_icl_language_code();

		Core::add_filter( 'pardesign_scripts_js_i18n', ['Lang', 'add_lang_to_ajaxurl'] );
		Core::add_action( 'after_setup_theme', ['Lang', 'after_setup_theme'] );
	}

	private static function define_icl_language_code(){

		if( ! defined('ICL_LANGUAGE_CODE') ){

			if( self::OVERRIDE_LOCALE ){
				define( 'ICL_LANGUAGE_CODE', self::DEFAULT_LANG );
			}else{
				$locale = get_locale();

				if( $locale ){
					$locale_parts = explode( '_', $locale );

					define( 'ICL_LANGUAGE_CODE', $locale_parts[0] );
				}else{
					define( 'ICL_LANGUAGE_CODE', self::DEFAULT_LANG );
				}
			}
		}
	}

	/**
	 * Folder must contain files named like fr_FR.mo
	 */
	public static function after_setup_theme(){
		load_theme_textdomain( 'par-design-theme', get_stylesheet_directory() . '/languages' );
		load_theme_textdomain( 'par-design-theme', get_template_directory() . '/languages' );
	}

	public static function add_lang_to_ajaxurl( $i18n ){
		$i18n['ajaxurl'] = add_query_arg( array('lang' => ICL_LANGUAGE_CODE), admin_url('admin-ajax.php') );

		return $i18n;
	}
}
