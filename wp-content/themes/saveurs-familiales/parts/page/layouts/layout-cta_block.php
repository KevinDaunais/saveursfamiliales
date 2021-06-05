<?php
use ATMK\Template;
use ATMK\Media;
use ATMK\Files;

include locate_template( 'parts/page/layouts/options.php' );

$blocks = get_sub_field( $layout . 'blocks' );


$animations = 'animation--true';

if( $block_counts < 3 ){

    $animations = 'animation--false';
}

$count = 0;



?>
<?php if ($blocks): ?>

    <div <?php echo $block_id; ?> class="<?php echo $block_class; ?> <?php echo $animations ?> custom--layouts" <?php echo $block_style; ?> data-custom_margin="<?php echo $block_margin_data; ?>" >

        <div class="cta__wrapper">

            <?php foreach($blocks as $block): $count++; ?>
                <?php
                    $element_class = 'without--bg';

                    if( $block['block_bg'] ){
                        $element_class = 'with--bg';
                    }

                ?>
                <div class="block__element <?php echo $element_class; ?> element--<?php echo $block['block_size']; ?>">
                    <div <?php Media::set_bg($block['block_bg'], 'full', 'cover--el'); ?>></div>
                    <div class="overlay cover--el" style="background-color:<?php echo $block['block_bgcolor']; ?>"></div>
                    <div class="in">
                        <div class="text__wrapper" style="color:<?php echo $block['block_textcolor']; ?>">
                            <?php echo $block['text'] ?>
                        </div>
						
                        <?php Template::get_component( 'parts/page/components/block-button', $block['buttons'] ); ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>

<?php endif; ?>

