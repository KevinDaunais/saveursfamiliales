<?php

global $wp_query;

$count = 0;

$prev_type  = '';
$is_open    = FALSE;

$results_count = array();

foreach( $wp_query->posts as $found_post ){

    if( array_key_exists( $found_post->post_type, $results_count ) )
        $results_count[$found_post->post_type]++;
    else
        $results_count[$found_post->post_type] = 1;
}

?>

<div class="accs_block">

<?php if( have_posts() ) : while( have_posts() ) : the_post();  $obj = get_post_type_object( get_post_type() );  ?>

    <?php if( get_post_type() && get_post_type() != $prev_type ) : ?>

        <?php if( $is_open ) : ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php

            $count = array_key_exists( get_post_type(), $results_count ) ? $results_count[get_post_type()] : 0;
            $obj = get_post_type_object( get_post_type() );
            $label = $obj->labels->name;

            $current_type = get_post_type();

            if ( get_post_type() == 'post' )
                $label = __('Actualités','theme');

            if ( get_post_type() == 'page' )
                $label = __('Page','theme');

            if ( get_post_type() == 'attachment' )
                $label = __('Fichiers médias','theme');

        ?>

    <div class="post-type <?php echo get_post_type(); ?> acc">

        <div class="title">
            <h4>
                <?php echo $label; ?>
                <span class="results">
                    <?php echo $count; ?>
                    <?php echo $count ? _n('résultat', 'résultats', $count,'theme') : __('résultat','theme'); ?>
                </span>
            </h4>
            <span class="toggle"></span>
        </div>

        <div class="contents">

            <div class="post-list flex__grid cols--2 type--post large--gutters">

    <?php $is_open = TRUE; $prev_type = get_post_type(); endif;

        get_template_part("parts/grid/item-{$current_type}");

    endwhile;

    if( $is_open ) : ?>
            </div>
        </div>
    </div>
    <?php endif;

    else: ?>

    <p class="no-results">
    <?php _e('Aucun résultat','theme'); ?>
    </p>

<?php endif; ?>

</div>