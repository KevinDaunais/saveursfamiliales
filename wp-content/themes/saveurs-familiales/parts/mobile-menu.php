<?php

use ATMK\Tools;

$socials = Tools::get_meta( 'socials', 'options', TRUE );
$email   = Tools::get_meta( 'email', 'options' );

?>
<div class="mobile-nav-wrap">
	<div class="top-mobile">
		<a href="#" class="firemenu--button">
			
			<svg class='fa fa-paper-plane'><use xlink:href='#fa-paper-plane'></use></svg>
		</a>
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

        <div class="switcher--mobile">
            <span class="label"><?php _e('Mode sombre', 'par-design-theme'); ?></span>
            <div class="theme__switcher">
                <label class="theme-switch" for="checkboxm">
                    <input type="checkbox" id="checkboxm" />
                    <div class="theme__slider round">
                        <div class="theme__element element--light">
                            <svg class='fa fa-sun'><use xlink:href='#fa-sun'></use></svg> 
                        </div>
                        <div class="theme__element element--dark">
                            <svg class='fa fa-moon'><use xlink:href='#fa-moon'></use></svg> 
                        </div>
                        <div class="bg__toggle"></div>
                    </div>
                </label>
            </div>
        </div>
        
	</div>
</div>
