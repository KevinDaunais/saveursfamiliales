<?php get_header(); ?>
<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

	<section class="content">

		<div class="container page__layouts">

            <?php if (have_rows('page_content')) : while (have_rows('page_content')) : the_row();

            get_template_part('parts/page/layouts/layout', get_row_layout());

            endwhile; endif; ?>

		</div>

    </section>
    
<?php endwhile; endif; ?>

<?php get_footer();
