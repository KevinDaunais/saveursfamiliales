<?php

use ATMK\Media;

include locate_template( 'parts/page/layouts/options.php' );

$header_type  = get_sub_field( $layout . 'type' );
$text         = get_sub_field( $layout . 'text' );
$header_image = get_sub_field( $layout . 'image' );


$bg = $data['block_bg'];
$block_class .= ' page__header with--bgcolor';
$class = 'color';

if( ! is_archive() )
	$title = get_the_title();

if( $header_type )
	$class = $header_type;
	
?>

<section <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts type--<?php echo $class; ?>" style="<?php echo $block_bg; ?> <?php echo $block_margin; ?>" data-custom_margin="<?php echo $block_margin_data; ?>">
	<div class="header__inner">
		<div class="header__wrapper">

			<?php if ( $header_type == 'image' && $header_image ) : ?>

                <div class="header__img">
                    <div <?php Media::set_bg( $header_image, "full", "ratio--75" ); ?>></div>
                </div>

			<?php endif; ?>

			<div class="header__content custom--layouts" style="<?php echo $block_padding; ?>" data-custom_padding="<?php echo $block_padding_data; ?>">

				<div class="content__bg" style="<?php echo $col_style; ?>">

					<?php if ( $text ) : ?>

					<div class="content__text">
						<?php echo $text ?>
					</div>

					<?php endif; ?>

				</div>

			</div>

		</div>
	</div>
</section>