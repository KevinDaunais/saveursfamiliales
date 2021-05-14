<?php

$data = get_query_var( 'component_data' );

$b_base  = 'button_block_';
$buttons = $data['buttons'];

$pos_x = $data[$b_base . 'layout']['block_pos'];
$pos_y = $data[$b_base . 'layout']['block_col_pos'];

$block_class = $pos_x . ' ' . $pos_y;

if( $data[$b_base . 'toggle'] ) : ?>

<div class="block__button <?php echo $block_class; ?>">
	<?php foreach( $buttons as $button ) :

		$b_class  = $b_link  = '';
		$b_target = '_self';

		$icon     = $button[$b_base .'icon'];
		$icon_pos = $button[$b_base .'icon_pos'];

        $link_object = $button[$b_base .'link_object'];

        if( $link_object ){

            $b_label  = $link_object['title'];
            $b_link   = $link_object['url'];
            $b_target = $link_object['target'];
        }

		if( $button[$b_base .'style'] ){
			$b_class = 'button--text';
		}

		if( $icon != 'none' ){
			$b_class .= ' with--icon pos--' . $icon_pos;
		}

		?>

	<a href="<?php echo $b_link; ?>" target="<?php echo $b_target; ?>" class="<?php echo $b_class; ?>">
		<span class="link__label"><?php echo $b_label; ?></span>

		<?php if ( $icon != 'none' ) : ?>

		<svg class='fa fa-<?php echo $icon; ?>'><use xlink:href='#fa-<?php echo $icon; ?>'></use></svg>

		<?php endif; ?>
	</a>

	<?php endforeach; ?>
</div>

<?php endif;
