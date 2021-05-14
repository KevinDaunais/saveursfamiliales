<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html id="top" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="dns-prefetch" href="//fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<title><?php wp_title(); ?></title>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'after_body_tag' ); ?>

	<div class="page-wrapper">

        <header class="header">
			<div class="container">
                <div class="header__in">
                    <?php wp_nav_menu( [ 'theme_location' => 'main-nav', 'container' => 'nav', 'container_class' => 'main-nav-wrap', 'fallback_cb' => 'false' ] ); ?>
                    <?php get_template_part('parts/mobile-menu'); ?>
                </div>
			</div>
		</header>
		
		<div class="main">
