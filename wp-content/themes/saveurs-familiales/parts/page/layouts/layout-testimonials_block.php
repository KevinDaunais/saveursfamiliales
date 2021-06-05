<?php

    include(locate_template('parts/page/layouts/options.php'));
    
    $slides     = get_sub_field($layout .'tests');
?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts" style="<?php echo $block_margin; ?><?php echo $block_padding; ?> <?php echo $block_bg; ?>" data-custom_margin="<?php echo $block_margin_data; ?>" data-custom_padding="<?php echo $block_padding_data; ?>">
	
	<div class="in">

		<?php if ( $slides ): ?>
			<div class="testimonials__slider">
                <?php foreach( $slides as $slide ): ?>
                    <div class="slide__element">
                        <div class="in custom--layouts">

                            <div class="in__text">

                                <div class="text__testi" style="<?php echo $col_style; ?>">
                                    <h5><span><?php _e('«', 'par-design-theme')?></span><?php echo $slide['testimonial'] ?><span><?php _e('».', 'par-design-theme')?></span></h5>
                                </div>

                                <span class="testi__title" style="<?php echo $col_style; ?>"><?php echo $slide['title'] ?></span>
                                <img src="<?php echo $slide['logo']['sizes']['large']?>" alt="">

                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
			</div>
        <?php endif; ?>
	</div>
	<div class="pattern__overlay">
		<svg class='fa fa-flower'><use xlink:href='#fa-flower'></use></svg>
	</div>

</div>