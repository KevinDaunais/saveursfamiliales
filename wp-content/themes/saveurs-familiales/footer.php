		</div>

		<footer class="footer">

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
        
        <div class="theme__switcher switcher--desktop">
            <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox" />
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
	<?php wp_footer(); ?>
</body>
</html>
