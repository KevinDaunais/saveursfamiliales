<?php

    use ATMK\Media;

    $c_data             = get_query_var('component_data');
    $count              = $c_data;
    $featured_thumb     = get_field('featured_thumb');
    $author             = get_the_author_meta('display_name');
    $cats               = ATMK\ParentTheme::get_post_terms($post, 'category');
?>


<article <?php echo post_class('grid__item item--box item--post') ?>>

    <a class="item__inner" href="<?php echo get_permalink(); ?>">

        <div class="post__inner">

            <?php if ($featured_thumb): ?>
                <div class="post__thumbnail">
                    <div <?php Media::set_bg($featured_thumb, 'full', 'ratio--75'); ?>></div>
                </div>
            <?php endif; ?>

            <div class="info__wrapper">

                <div class="post__info">

                    <div class="infos--meta inner__date">

                        <?php if ( $cats ): ?>
                            <span><?php echo implode(', ', $cats); ?></span>
                        <?php endif; ?>
                        <span class="sep"></span>
                        <span> <?php echo get_the_date(); ?> </span>

                    </div>

                    <h4 class="grid__title"><?php the_title() ?></h4>

                    <div class="d--flex activity--metas">

                        <?php if($author): ?>
                            <div class="infos--meta meta--author">
                                <svg class='fa fa-user'><use xlink:href='#fa-user'></use></svg> <?php echo $author ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </a>
</article>