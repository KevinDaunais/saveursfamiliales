<?php

use ATMK\Tools;

$socials = Tools::get_meta( 'socials', 'options', TRUE );
$email   = Tools::get_meta( 'email', 'options' );

?>
<div class="mobile-nav-wrap">
	<div class="top-mobile">
		
		<button class="hamburger  mobile-nav-toggle menu-toggle" type="button" data-toggle="menu">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>
	</div>
	<div class="mobile-menu" data-listener="menu">
		<?php if( $socials ) : ?>
		<div class="socials">
			<?php foreach( $socials as $social ) : ?>
			<a href="<?php echo $social['link']; ?>" target="_blank" onclick="gaTracker('send', 'event', 'category', 'action', {'nonInteraction': 1});"><i class="fa <?php echo $social['icon'] ?>"></i></a>
			<?php endforeach; ?>

			<a href="mailto:<?php echo antispambot( $email ); ?>"><i class="fa fa-envelope"></i></a>
		</div>
		<?php endif; ?>
		
		<ul class="top-m">
			
			<?php wp_nav_menu([ 'theme_location' => 'main-nav', 'container' => false, 'items_wrap' => '%3$s' ]); ?>
			<div class="svg--mob">

				<a href="<?php echo wc_get_cart_url() ?>"><svg class='fa fa-cart'><use xlink:href='#fa-cart'></use></svg></a>
				
				<?php if ( is_user_logged_in() ) { ?>
				<a class="account" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woothemes'); ?>"><svg class='fa fa-account'><use xlink:href='#fa-account'></use></svg></a>
				<?php } 
				else { ?>
				<a class="account" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','woothemes'); ?>"><svg class='fa fa-account'><use xlink:href='#fa-account'></use></svg></a>
				<?php } ?>
			</div>
		</ul>
        
	</div>
</div>
