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

	<title><?php wp_title(); ?></title>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="fullscreen 404" >
	<div class="container">
		<h1><?php _e( 'Erreur 404 !', 'par-design-theme')?></h1>
		<h2><?php _e( 'La page est introuvable', 'par-design-theme')?></h2>
		<div class="cta"><a class="back-to-home" href="<?php bloginfo('wpurl'); ?>"><?php _e('Retournez sur l’accueil', 'par-design-theme' )?></a></div>
	</div>
</div>


</body>
</html>
