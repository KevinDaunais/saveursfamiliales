<?php

namespace ATMK;

class Gravityforms
{
	public static function boot(){
		Core::add_filter( 'gform_custom_merge_tags', ['Gravityforms', 'custom_merge_tags'], 10, 4 );
		Core::add_filter( 'gform_replace_merge_tags', ['Gravityforms', 'replace_custom_merge_tags'], 10, 7 );
		Core::add_filter( 'gform_submit_button', ['Gravityforms', 'form_submit_button'], 10, 2 );
		Core::add_filter( 'gform_notification', ['Gravityforms', 'notification_tpl'], 10, 3 );
		Core::add_filter( 'gform_email_background_color_label', ['Gravityforms', 'gform_email_background_color_label'], 10, 3 );

		Core::add_filter( 'gform_export_separator', ['Gravityforms', 'change_separator'], 10, 2 );

		Core::add_filter( 'gform_ajax_spinner_url', ['Gravityforms', 'custom_spinner'] );
	}

	/**
	 * Custom tags for gravity forms
	 *
	 * @param  array	$merge_tags		original list of tags
	 * @param  int		$form_id		id of the current form
	 * @param  array	$fields			current form's fields
	 * @param  int		$element_id		id of the current element
	 *
	 * @return array             		modified list of tags
	 */
	public static function custom_merge_tags( $merge_tags, $form_id, $fields, $element_id ){
		$merge_tags[] = array('label' => 'URL du site', 'tag' => '{site_url}');
		$merge_tags[] = array('label' => 'Nom de domaine du site', 'tag' => '{domain_name}');

		return $merge_tags;
	}

	/**
	 * Replace merge tags with their content
	 *
	 * @param  string $text       	The current text in which merge tags are being replaced
	 * @param  object $form       	Current form
	 * @param  object $entry      	Current entry
	 * @param  boolean $url_encode 	Whether or not to encode any URLs found in the replaced value
	 * @param  boolean $esc_html   	Whether or not to encode HTML found in the replaced value
	 * @param  boolean $nl2br      	Whether or not to convert newlines to break tags
	 * @param  string $format    	Default "html"; determines how the value should be formatted
	 *
	 * @return string             	The text with the merge tags replaced
	 */
	public static function replace_custom_merge_tags( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ){
		$site_url    = site_url();
		$parse       = parse_url($site_url);

		return str_replace( array( '{site_url}', '{domain_name}' ), array( $site_url, $parse['host'] ), $text );
	}

	public static function form_submit_button($button, $form) {

		//save attribute string to $button_match[1]
		preg_match("/<input([^\/>]*)(\s\/)*>/", $button, $button_match);

		//remove value attribute
		$button_atts = str_replace("value='".$form['button']['text']."' ", "", $button_match[1]);

		return '<button '.$button_atts.'><span>'.$form['button']['text'].'</span></button>';
	}

	public static function notification_tpl( $notification, $form, $entry ){

		$title   = $notification['subject'];
		$message = $notification['message'];

		$formatted_email = '';

		ob_start();

		include get_stylesheet_directory() . '/inc/gf-email.php';

		$formatted_email = ob_get_clean();

		$notification['message'] = $formatted_email;

		return $notification;
	}

	public static function gform_email_background_color_label($ffffff, $field, $lead){
		$ffffff = 'f5f5f5';
		return $ffffff;
	}

	public static function change_separator( $separator, $form_id ) {

		if( ! current_user_can('administrator') ){
			return ';';
		}

		return $separator;
	}

	/**
	 * Changes the default Gravity Forms AJAX spinner.
	 *
	 * @since 1.0.0
	 *
	 * @param string $src  The default spinner URL.
	 * @return string $src The new spinner URL.
	 */
	public static function custom_spinner( $original_spinner ) {
		return apply_filters( 'atmk/gravityforms/spinner', get_stylesheet_directory_uri() . '/images/form_loader.svg', $original_spinner );
	}
}
