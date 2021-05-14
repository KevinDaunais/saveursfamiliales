<?php 

namespace PAREXT\App\Objects;

class Mail
{

	private $phpmailer;

	private $options;

	public function __construct( $args ){

		$defaults = [
			'CharSet'  => 'UTF-8',

			'From'     => get_option('admin_email'),
			'FromName' => get_option('blogname'),
			'ReplyTo'  => get_option('admin_email'),

			'Port' => 25,
			'Host' => 'localhost',

			'SMTPAuth'   => FALSE, 
			'SMTPSecure' => '',
			'Username'   => '',
			'Password'   => '',

		];

		$options = wp_parse_args( $args, $defaults );
		$this->options = array_intersect_key( $options, $defaults );

		$this->setup_mailer( $this->options );
	}

	public function setup_mailer( $options ){
		require_once ABSPATH . WPINC . '/class-phpmailer.php';
        require_once ABSPATH . WPINC . '/class-smtp.php';
		$this->phpmailer = new \PHPMailer();
		
		$this->phpmailer->isSMTP();
		$this->phpmailer->isHTML( TRUE );

		$replyto   = $options['ReplyTo'];
		$from_mail = $options['From'];
		$from_name = $options['FromName'];

		unset( $options['ReplyTo'] );
		unset( $options['From'] );
		unset( $options['FromName'] );

		foreach( $options as $option => $value ){
			$this->phpmailer->$option = $value;
		}

		if( $replyto ){
			$this->phpmailer->addReplyTo( $replyto );
		}

		$this->phpmailer->SetFrom( $from_mail, $from_name );

		$this->phpmailer->addCustomHeader( "X-MSmail-Priority" , "Normal" );
		$this->phpmailer->addCustomHeader( "X-MimeOLE" , "Produced By Microsoft MimeOLE V6.00.2800.1441" );
		$this->phpmailer->addCustomHeader( "Organization" , $from_name );

	}

	public function send( $to, $subject, $message ){
		$this->phpmailer->clearAllRecipients();
		$this->phpmailer->clearAttachments();

		$this->phpmailer->AddEmbeddedImage( $this->get_logo(), 'emaillogo' );

		$this->phpmailer->Subject = $subject;
		$this->phpmailer->AddAddress( $to );
		$this->phpmailer->MsgHTML( $message );
		
		$sent = $this->phpmailer->Send();
	}

	public function get_template( $vars ){
		$tpl = include \PAREXT\plugin()->tools->plugin_path() . '/inc/tpl.email.php';

		foreach( $vars as $key => $value ){

			$value = apply_filters( 'parext_mail_get_template_var', $value, $key );
			$value = apply_filters( "parext_mail_get_template_var_{$key}", $value, $key );

			$tpl = str_replace( "[{$key}]", $value, $tpl );
		}

		return apply_filters( 'parext_mail_get_template', $tpl );
	}

	private function get_logo(){
		$base = get_stylesheet_directory() . '/images/logo.';

		if( file_exists($base . 'png') ){
			return $base . 'png';
		
		}elseif( file_exists($base . 'jpg') ){
			return $base . 'jpg';
		
		}else{
			return \PAREXT\plugin()->tools->get_img_path( 'logo.png' );
		}
	}
}