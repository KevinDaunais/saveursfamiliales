<?php

use ATMK\Embed;

include locate_template( 'parts/page/layouts/options.php' );

$video  = get_sub_field( $layout . 'video' );
$size   = get_sub_field( $layout . 'layout' );
?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts size--<?php echo $size; ?>" <?php echo $block_style; ?>>
	
	<div class="in">

		<?php if ( $video ) : ?>
			
		<div class="embed with--vid" data-youtubeid="<?php echo $video; ?>">
			<?php echo Embed::get_embed( $video ); ?>
		</div>

		<?php endif; ?>
		
	</div>

</div>