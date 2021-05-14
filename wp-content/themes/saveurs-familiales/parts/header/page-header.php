<?php
    use ATMK\Media;
    use ATMK\Files;

    $data = get_query_var('component_data');
?>


<section class="page__header">
    <?php if (isset($data['page_bg'])): ?>
        <div <?php Media::set_bg($data['page_bg'], 'full', 'cover--bg'); ?>></div>
    <?php endif; ?>
    <div class="overlay"></div>

    <div class="container">
        <div class="in__text">
            <?php get_template_part('parts/breadcrumbs') ?>

            <?php echo $data['page_titles'] ?>
        </div>
    </div>
</section>