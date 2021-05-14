<?php get_header(); ?>

<section class="content">

	<div class="container">
		<div class="cat-select">
			<span class="selected"><?php _e( 'Catégories', 'par-design-theme' ) ?> <i class="fa fa-angle-down"></i></span>
			<ul class="list">
				<?php 

				wp_list_categories( [
					'title_li'   => '',
					'hide_empty' => false,
				]); 

				?>
			</ul>
		</div>


		<div class="post-list">
			<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<article class="post">

				<div class="d-flex">
					<div class="metas">
						<span class="loop-date"><?php the_time( 'j F Y' ) ?></span>
						<span class="loop-author"><?php _e( 'Auteur :', 'par-design-theme' ); ?> <?php echo the_author_posts_link(); ?></span>
					</div>
					
					<div class="post-info" paranim-delay="200" paranim-type="fadeInUp">
						<h2><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>

						<?php the_excerpt(); ?>
						<a href="<?php echo the_permalink(); ?>" class="button-link"><?php _e( 'Lire cette nouvelle', 'par-design-theme' ); ?></a>
					</div>

					<?php if ( has_post_thumbnail() ) : ?>
					<figure class="post-thumbnail">
						<?php the_post_thumbnail( 'single-post-image' ); ?>
					</figure>
					<?php endif; ?>
				</div>

			</article>

			<?php endwhile; endif; ?>

			<div class="pagination"><?php ATMK\Template::archive_pagination(); ?></div>

		</div>
	</div>

</section>

<?php get_footer();
