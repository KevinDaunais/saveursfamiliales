<?php

use ATMK\Media;
use ATMK\Template;

include locate_template( 'parts/page/layouts/options.php' );

$slides = get_sub_field( $layout . 'slides' );
$size   = get_sub_field( $layout . 'layout' );
?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts size--<?php echo $size; ?>" style="<?php echo $block_margin; ?>" data-custom_margin="<?php echo $block_margin_data; ?>">
	
	<div class="in">

		<?php if ( $slides ) : ?>

		<div class="block__slides">
			<?php foreach( $slides as $slide ) : 

				$slide_class = 'normal--text';

				if( $slide['text_boxed'] ){
					$slide_class = ' boxed--text';
				}
				
				?>
			<div <?php Media::set_bg($slide['bg'], 'full', 'slide__element'); ?>>
				<div class="in <?php echo $slide_class; ?> custom--layouts" style="<?php echo $col_style; ?> <?php echo $block_padding; ?> <?php echo $block_bg; ?>" data-custom_padding="<?php echo $block_padding_data; ?>">
					<div class="in__img">

						<div <?php Media::set_bg($slide['logo'], 'large', 'logo ratio--100'); ?>></div>
					</div>
					<div class="in__text">
						<?php echo $slide['text'] ?>

						<?php Template::get_component( 'parts/page/components/block-button', $slide['slide_buttons'] ); ?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		
		<?php endif; ?>
		
	</div>

</div>