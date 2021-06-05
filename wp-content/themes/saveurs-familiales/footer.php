		</div>

        <?php 
        use ATMK\Tools;
        use ATMK\Media;
    
    
        $adress = Tools::get_meta( 'options_address', 'options', TRUE );
        $mail = Tools::get_meta( 'options_mail', 'options', TRUE );
        $tel = Tools::get_meta( 'options_tel', 'options', TRUE );
        
        ?>
		<footer class="footer">
            <div class="in">
                <h2>Contactez nous</h2>
                <div class="inner">

                    <div class="info">
                        <a class="logo" href="<?php echo home_url() ?>/?splash">
                            <?php echo ATMK\Media::output_img('images/logo.svg'); ?>
                        </a>
                        <div class="content--info">
                            <svg class='fa fa-map-o' ><use xlink:href='#fa-map-o'></use></svg>
                            <p><?php echo $adress ?></p>
                        </div>
                        <div class="content--info">
                            <svg class='fa fa-phone' ><use xlink:href='#fa-phone'></use></svg>
                            <a class="tel" href="tel:<?php echo $phone ?>"> <?php echo $tel ?></a>
                        </div>
                        <div class="content--info">
                            <svg class='fa fa-envelope-o' ><use xlink:href='#fa-envelope-o'></use></svg>
                            <a class="email" href="mailto:<?php echo $email ?>"> <?php echo $mail ?></a>
                        </div>
                    </div>
                    <div class="form">
                        <?php echo do_shortcode('[wpforms id="198"]') ?>
                    </div>
                </div>
            </div>
		</footer>

		<div class="copyright">
			<div class="container">
				<div class="inner">
					<?php echo do_shortcode('[footer-lock]'); ?> <?php _e('Tous droits réservés', 'par-design-theme'); ?> <?php echo date('Y'); ?>
					<span class="sep"></span>
					<?php bloginfo('sitename'); ?>
					<span class="sep"></span>
					<a href="https://pardesign.net" target="_blank"><?php _e('Création et Design Web PAR Design', 'par-design-theme'); ?></a>
				</div>
			</div>
        </div>
        
        
	</div>
	<?php wp_footer(); ?>
</body>
</html>
