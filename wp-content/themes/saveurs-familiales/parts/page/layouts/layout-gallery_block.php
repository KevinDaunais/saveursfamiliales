<?php

use ATMK\Media;

include locate_template( 'parts/page/layouts/options.php' );

$gallery = get_sub_field( $layout . 'gallery' );
$intro   = get_sub_field( $layout . 'intro' );
$grid    = get_sub_field( $layout . 'grid' );

?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts" <?php echo $block_style; ?>>

	<div class="in">

		<?php if ( $intro ) : ?>

		<div class="in__intro">
			<?php echo $intro; ?>
		</div>

		<?php endif; ?>

		<?php if ( $gallery ) : ?>
			<div class="gallery__images flex__grid cols--<?php echo $grid; ?>">
				<?php foreach( $gallery as $img ) : ?>
				<div class="grid__item gallery__image">
					<div class="image__hover">
						<div data-src="<?php echo $img['url']; ?>" data-exthumbimage="<?php echo $img['sizes']['thumbnail']; ?>" data-sub-html="<?php echo $img['caption'] ?>" <?php Media::set_bg( $img, 'large', 'img' ); ?>>
							<div class="overlay">
								<span><?php _e('En voir plus','par-design-theme'); ?></span>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>

</div>