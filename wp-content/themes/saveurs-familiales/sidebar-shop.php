<?php

$rm_cats = get_field('rm_cats','options');

$args = array(
	'show_option_all'    	=> __( 'Toutes', 'theme' ),
	'style'              	=> 'list',
	'hierarchical'       	=> 1,
	'title_li'           	=> '',
	'show_option_none'   	=> __( 'Aucune catégorie', 'theme' ),
	'taxonomy'           	=> 'product_cat',
	'exclude'				=> $rm_cats,
);

if( is_singular('product') ){
	$p_terms = get_the_terms( $post, 'product_cat' );

	if( is_array($p_terms) && sizeof($p_terms) ){
		usort( $p_terms, 'wp_list_sort' ); // order by ID to match woocommerce
		$args['current_category'] = reset( $p_terms )->term_id;
	}

}

?>
<ul class="products-filter">
	<?php  wp_list_categories( $args );  ?>
</ul>

<div class="mobile-products-filter">
	<?php
	$args = array(
		'show_option_all'   => __( 'Filtrer par catégorie', 'theme' ),
		'hierarchical'      => 1,
		'show_option_none'  => 0,
		'taxonomy'          => 'product_cat',
		'value_field'		=> 'slug',
		'orderby'			=> 'name',
		'exclude'			=> $rm_cats,
	);

	if ( is_tax('product_cat') ) {
		$queried_object = get_queried_object();

		$args['selected'] = $queried_object->slug;
	}

	wp_dropdown_categories( $args );
	?>
</div>

<script type="text/javascript">
	var dropdown = document.getElementById("cat");
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value == 0 ) {
			location.href = "<?php echo home_url( '/boutique/' ); ?>";
		} else {
			location.href = "<?php echo home_url( '/cat/' ); ?>"+dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
</script>
