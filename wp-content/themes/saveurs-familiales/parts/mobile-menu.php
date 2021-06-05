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
			<li><a href="<?php echo get_home_url() ?>"><?php _e( 'Accueil', 'par-design-theme' ); ?></a></li>
			<?php wp_nav_menu([ 'theme_location' => 'main-nav', 'container' => false, 'items_wrap' => '%3$s' ]); ?>
		</ul>
        
	</div>
</div>
