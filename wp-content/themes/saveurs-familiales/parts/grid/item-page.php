<?php

    use ATMK\Media;

    $c_data = get_query_var('component_data');

    $count = $c_data;

    $type_label  = __('Page');
	$thumb_class = "no--thumb";
?>


<article <?php echo post_class('grid__item item--box item--faq '.$thumb_class.' ') ?>>

    <a class="item__inner" href="<?php echo get_permalink(); ?>">

        <div class="post__inner">

            <div class="info__wrapper">

                <div class="post__info">

                    <h6><?php echo $type_label ?></h6>

                    <h5><?php the_title() ?></h5>

                </div>

            </div>

        </div>

    </a>
</article>