<?php

use ATMK\Media;

include locate_template( 'parts/page/layouts/options.php' );

$video = get_sub_field( $layout . 'video' );
$intro = get_sub_field( $layout . 'intro' );
$docs  = get_sub_field( $layout . 'docs' );
$grid  = get_sub_field( $layout . 'grid' );

?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts" <?php echo $block_style; ?> data-custom_margin="<?php echo $block_margin_data; ?>" data-custom_padding="<?php echo $block_padding_data; ?>">
	<div class="in">

		<?php if ($intro) : ?>

		<div class="in__intro">
			<?php echo $intro ?>
		</div>

		<?php endif; ?>

        <?php if ($docs): ?>

            <div class="docs__wrapper flex__grid cols--<?php echo $grid; ?>">
			<?php foreach( $docs as $doc ) :

				$link = $filesize = '';

				$type = 'type--image';

				if( $doc['img_icon'] ) {

					$type = 'type--file';
				
					$filesize = filesize( get_attached_file( $doc['file']['id'] ) );
					$filesize = size_format( $filesize, 2 );

					$link = $doc['file']['url'];

				}else{
					$link = $doc['url'];
				}

				?>

			<div class="doc grid__item <?php echo $type; ?>">

				<?php 

				$a_mode = ' download ';

				if( ! $doc['file_url'] ){
					$a_mode = ' target="_blank" ';
				}

				?>

				<a <?php echo $a_mode; ?> href="<?php echo $link; ?>">
					<div class="doc__wrapper">
						<div class="doc__content">
							<?php if ( $doc['image'] ) : ?>

							<div <?php Media::set_bg( $doc['image'], 'medium', 'doc__img' ); ?>></div>
							<div class="doc__txt"><?php echo $doc['label']; ?></div>

							<?php else: ?>

							<svg class="fa fa-pdf"><use xlink:href="#fa-pdf"></use></svg>
							<div class="info">
								<span><?php echo $doc['label'] ?></span>
								<small><?php echo $doc['file']['subtype'] ?> - <?php echo $filesize ?></small>
							</div>

							<?php endif; ?>
						</div>
					</div>
				</a>
				
			</div>

			<?php endforeach; ?>
		</div>
        
        <?php endif; ?>

	</div>
</div>