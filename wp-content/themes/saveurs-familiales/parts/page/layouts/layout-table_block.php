<?php
    include locate_template( 'parts/page/layouts/options.php' );
    
    $table_intro  = get_sub_field($layout . 'intro');

    $bg = $options['block_bg'];
?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts" <?php echo $block_style; ?> style="<?php echo $block_margin; ?> <?php echo $block_padding; ?>" data-custom_margin="<?php echo $block_margin_data; ?>" data-custom_padding="<?php echo $block_padding_data; ?>">
    <div class="in">

        <?php if ($table_intro): ?>
            <div class="intro__text">
                <?php echo $table_intro; ?>
            </div>
        <?php endif; ?>

        <?php get_template_part('parts/page/components/rates-lines'); ?>
    </div>
</div>