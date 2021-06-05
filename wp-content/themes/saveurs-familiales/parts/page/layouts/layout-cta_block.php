<?php

    use ATMK\Template;
    use ATMK\Tools;
    use ATMK\Media;

    include locate_template( 'parts/page/layouts/options.php' );

    $filter  = get_sub_field( $layout . 'filter' );
    $bg = get_sub_field( $layout . 'bg' );
    $content = get_sub_field( $layout . 'content' );
    $btn = get_sub_field( $layout . 'btn' );
    
    if($filter){
        $filter = "filter--blue";
    } else{
        $filter = "filter--orange";
    }

    $component_data = [
        'cols'          => $element['row'],
        'layout'        => $layout,
        'grid'          => 2,
        'margin'        => false,
        'padding'       => false,
        'col_style'     => false,
        'block_pos'     => 'y--starts',
        'block_col_pos' => 'x--starts',
    ];
?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts" style="<?php echo $col_style; ?> <?php echo $block_padding; ?>" data-custom_padding="<?php echo $block_padding_data; ?>" data-custom_margin="<?php echo $block_margin_data; ?>">
	<div <?php Media::set_bg( $bg, "full", "cover--el" ); ?>>
    
		<div class="in__cta <?php echo $filter ?>">
            <div class="cta__element">
                <div class="cta__content">
                    <?php echo $content ?>
                    <div class="cta__btn">
                        <?php echo $title ?>
                        <?php Template::get_component( 'parts/page/components/block-button', $btn ); ?>
                    </div>
                </div>

            </div>
        </div>	
	</div>
</div>
