<?php 

use ATMK\Media;
use ATMK\Template;

$component_data = get_query_var( 'component_data' );

$cols      = $component_data['cols'];
$items     = $component_data['grid'];

$class_col = $items;

if( $cols ) : ?>

<div class="flex__cols flex__grid cols--<?php echo $class_col; ?> <?php echo $component_data['block_pos']; ?> <?php echo $component_data['block_col_pos']; ?>" style="<?php echo $component_data['col_style']; ?>" data-custom_padding="<?php echo $component_data['padding']; ?>">

	<?php foreach( $cols as $element ) : ?>

		<?php if( $element['col_type'] == 'slider' ) : ?>

            <div class="grid__item item--slider">
                <div class="col__slider">

                    <?php foreach( $element['slider'] as $slide ) : ?>

                    <div class="slide">
                        <div <?php Media::set_bg( $slide, 'large', 'ratio--75' ); ?>></div>
                    </div>
                    
                    <?php endforeach; ?>

                </div>
            </div>

		<?php else: ?>

            <div class="grid__item item--text" <?php echo $component_data['col_style']; ?>>
                <div class="text">
                    <div class="in__text">
                        <?php echo $element['text']; ?>
                        <?php Template::get_component( 'parts/page/components/block-button', $element['button'] ); ?>
                    </div>
                </div>
            </div>

		<?php endif; ?>
		
	<?php endforeach; ?>

</div>

<?php endif;
