<?php

include locate_template( 'parts/page/layouts/options.php' );

$class        = 'grid--offset';
$content_mode = get_sub_field( $layout . 'type' );
$intro        = get_sub_field( $layout . 'intro' );

if( $content_mode == 'manual' ){
	$grids	= get_sub_field( $layout . 'select' );

} else {

	$num_show  = get_sub_field( $layout . 'count' );
	$post_type = get_sub_field( $layout . 'post_type' );

	$args = [
		'posts_per_page' => $num_show,
		'post_type'      => [$post_type],
		'post_status'    => 'publish',
		'exclude'        => [''],
	];

	$tax = get_sub_field( $layout . 'tax' );

	$tax_query   = [
		'taxonomy' => 'category',
		'terms'    => $tax,
		'field'    => 'id',
	];

	$post_type_obj = get_post_type_object( $post_type );
	$type_name     = $post_type_obj->labels->name;

	switch( $post_type ){
		case 'event':
			$tax_query['taxonomy'] = 'event_cat';
			break;

		case 'job':
			$tax_query['taxonomy'] = 'job_status';
			break;

		case 'team':
			$tax_query['taxonomy'] = 'team_dep'; 
			break;

		case 'training':
			$tax_query['taxonomy'] = 'training_type';
			break;
		
		default:
			$tax_query['taxonomy'] = 'category';
			break;
	}

	if( $post_type == 'post' ){
		$type_name = 'nouvelles';
	}

	if( $tax_query['terms'] ){
		$args['tax_query'][] = $tax_query;
	}

	$grids = get_posts($args);
}

$grid = $num_show;

if( $num_show > 4 or $num_show == '-1' && $post_type != 'job' ){
	$grid = 4;
}

if( $grids ) : ?>

<section <?php echo $block_id; ?> class="<?php echo $block_class; ?> custom--layouts type--<?php echo $class; ?>" style="<?php echo $block_padding; ?> <?php echo $block_margin; ?>" data-custom_margin="<?php echo $block_margin_data; ?>" data-custom_padding="<?php echo $block_padding_data; ?>">

	<div class="in">

		<?php if ( $intro ) : ?>

		<div class="in__intro">
			<?php echo $intro ?>
		</div>

		<?php endif; ?>

		<div class="flex__grid cols--<?php echo $grid; ?> type--<?php echo $post_type; ?> large--gutters offset--col">
			<?php 
			foreach( $grids as $post ) : 
				setup_postdata( $post );
				get_template_part( "parts/grid/item-{$post_type}" );
			endforeach; 
			
			wp_reset_postdata();

			?>
		</div>

	</div>

	<a href="<?php echo get_post_type_archive_link( $post_type );?>" class="button--link button--transparent archive--buton">
		<?php _e('Voir toutes les', 'par-design-theme'); ?>
		<?php echo $type_name; ?>
	</a>

</section>

<?php endif;
