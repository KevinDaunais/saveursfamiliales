<?php

use ATMK\Media;

include locate_template( 'parts/page/layouts/options.php' );

$members = get_sub_field( $layout . 'team' );
$intro   = get_sub_field( $layout . 'intro' );
$grid    = get_sub_field( $layout . 'grid' );

?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts" style="<?php echo $block_margin; ?>" data-custom_margin="<?php echo $block_margin_data; ?>">
	<div class="in">
		
		<?php if ( $intro ) : ?>
		<div class="in__intro">
			<?php echo $intro ?>
		</div>
		<?php endif; ?>

		<div class="team__members flex__grid cols--<?php echo $grid; ?>">
			
			<?php foreach( $members as $member ) : ?>
			<div class="member grid__item">
				<div class="member__container">
					<div <?php Media::set_bg( $member['photo'], 'large', 'member__img' ); ?>></div>
					
					<div class="member__content">
						<div class="content__text">
							<?php echo $member['bio']; ?>
						</div>

						<?php if ( $member['color'] ): ?>
						
						<div style="background-color: <?php echo $member['color']; ?>;" class="img__overlay"></div>
						
						<?php else: ?>

						<div class="img__overlay"></div>

						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>

		</div>
	</div>
</div>