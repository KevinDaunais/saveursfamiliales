<?php

use ATMK\Template;

include locate_template( 'parts/page/layouts/options.php' );

$accs  = get_sub_field( $layout . 'accs' );
$intro = get_sub_field( $layout . 'intro' );

$count = 0;

if( $accs ) : ?>

<div <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts" style="<?php echo $col_style; ?> <?php echo $block_padding; ?>" data-custom_padding="<?php echo $block_padding_data; ?>" data-custom_margin="<?php echo $block_margin_data; ?>">
	<div class="in">

		<?php if ( $intro ) : ?>
			
		<div class="in__intro">
			<?php echo $intro ?>
		</div>
		
		<?php endif; ?>

		<div class="accs">
			<?php foreach( $accs as $element ) : ?>

            <?php 

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

			<div class="acc" id="acc-<?php echo ++$count; ?>">

				<div class="title">
					<h3><?php echo $element['title'] ?></h3>
					<span class="toggle"></span>
				</div>

				<div class="contents">
					<?php Template::get_component( 'parts/page/components/grid-cols', $component_data ); ?>
				</div>
                
			</div>

			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
