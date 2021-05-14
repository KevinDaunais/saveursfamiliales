<?php
    use ATMK\Template;

    get_header();

    $header_data = [];

    if( $_GET['custom_search'] == true ){

        $header_data['page_titles'] = '<h5>'.__('Résultat(s) de recherche pour :').'</h5>';
        $header_data['page_titles'] .= '<h1>'. get_search_query() .'</h1>';
    }

?>

<section class="content">

	<div class="container">

        <div class="page-layouts">

            <?php Template::get_component( 'parts/header/page-header', $header_data ); ?>

            <?php get_template_part('parts/search/search-results') ?>

        </div>

	</div>

</section>

<?php get_footer();
