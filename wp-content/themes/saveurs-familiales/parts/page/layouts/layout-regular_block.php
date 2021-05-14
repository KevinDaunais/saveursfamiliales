<?php

use ATMK\Template;

include locate_template( 'parts/page/layouts/options.php' );

$cols = get_sub_field( $layout . 'cols_row' );
$size = get_sub_field( $layout . 'layout' );

$grid = get_sub_field( $layout . 'grid' );


if( ! $size ){
	$size = 'full';
}

$items     = count( $cols );
$class_col = $items;

$component_data = [
    'cols'          => $cols,
    'layout'        => $layout,
    'grid'          => $grid,
    'margin'        => $block_margin_data,
    'padding'       => $block_padding_data,
    'col_style'     => $col_style,
    'block_pos'     => $options['block_pos'],
    'block_col_pos' => $options['block_col_pos'],
];


if( $cols ) : ?>

<div 
<?php echo $block_id; ?> 
class="<?php echo $block_class; ?> custom--layouts cols--<?php echo $class_col; ?> size--<?php echo $size; ?>" 
style="<?php echo $block_bg; ?>" 
data-custom_margin="<?php echo $block_margin_data; ?>"
>

	<div class="in">
		<?php Template::get_component( 'parts/page/components/grid-cols', $component_data ); ?>
	</div>
	
</div>
<?php endif;
