<?php

$data = get_query_var( 'component_data' );

$b_base  = 'button_block_';
$buttons = $data['buttons'];

$pos_x = $data[$b_base . 'layout']['block_pos'];
$pos_y = $data[$b_base . 'layout']['block_col_pos'];

$block_class = $pos_x . ' ' . $pos_y;

$filesize = filesize( get_attached_file( $post->ID ) );
$filesize = size_format( $filesize, 2 );

?>
<div class="grid__item item--box item--media doc type--file">

    <a href="<?php echo $post->guid; ?>" target="_blank" class="doc">
        <div class="doc__wrapper">
            <div class="doc__content">
                <svg class="fa fa-pdf"><use xlink:href="#fa-pdf"></use></svg>
                <div class="info">
                    <span><?php echo $post->post_title; ?></span>
                    <?php if ($filesize): ?>
                        <small><?php echo $post->post_mime_type; ?> - <?php echo $filesize ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </a>
</div>