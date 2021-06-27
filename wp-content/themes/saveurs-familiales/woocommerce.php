<?php get_header(); ?>

	<section class="content">
		<div class="container page__layouts flex__menu">
			<div class="sidebar">
				<h3 class="cat__title">Catégories</h3>
				<div class="cat__side">
					<a class="dropdown__cat" href="">voir les catégories</a>
				<?php get_sidebar('shop') ?>
				</div>
			</div>
			<div class="menu__content">
                  <?php woocommerce_content (); ?>
			</div>
		</div>
    </section>
<?php get_footer();
