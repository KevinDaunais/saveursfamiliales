<?php

/**
 * @todo DONT FORGET TO CHANGE THE "CHANGEME!!!" REWRITE RULE URL
 */

# BEGIN MAINTENANCE-PAGE REDIRECT
#<IfModule mod_rewrite.c>
#RewriteEngine on
#RewriteBase /
#RewriteRule ^maintenance\.php$ - [L]

#RewriteCond %{REMOTE_ADDR} !^74\.57\.54\.136
#this is our IP, comment it to test the redirection

#RewriteCond %{REQUEST_URI} !/maintenance.php$ [NC]
#RewriteCond %{REQUEST_URI} !\.(jpe?g?|png|gif) [NC]
#RewriteRule ^(.*)$ http://CHANGEME!!!/maintenance.php [R=302,L]
#</IfModule>
# END MAINTENANCE-PAGE REDIRECT

/*
<rule name="maintenance redirect" stopProcessing="true">
	<match url=".*" ignoreCase="false" />
	<conditions logicalGrouping="MatchAll">
		<add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
		<add input="{REQUEST_FILENAME}" negate="true" pattern="\.aspx$" ignoreCase="true" />
		<add input="{REMOTE_HOST}" pattern="^74\.57\.54\.136" ignoreCase="false" negate="true" />
	</conditions>
	<action type="Redirect" url="maintenance.php" appendQueryString="true" />
</rule>
 */

 ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="robots" content="noindex">
	<title>MAINTENANCE</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
		h1, .tel {padding: 0; margin: 64px 0; }

		h1 {font-size: 40px; font-size: 4.0rem;}
		h2 {font-size: 36px; font-size: 3.6rem;}
		h3 {font-size: 32px; font-size: 3.2rem;}
		h4 {font-size: 28px; font-size: 2.8rem;}
		h5 {font-size: 24px; font-size: 2.4rem;}
		h6 {font-size: 20px; font-size: 2.0rem;}

		html {font-size: 62.5%;}
		body {
		font-family: sans-serif;
		background: #FEFEFE;
		color: #333;
		padding-top: 100px; padding-top: 25vh;
		}
		p { font-size: 16px; font-size: 1.6rem;}
		.img-center {
		margin: 0 auto;
		text-align: center;
		}
		.tel {font-size: 32px; font-size: 3.2rem;}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<p class="text-center">
				<img src="#" title="Logo">
			</p>
			<h1 class="text-center">MAINTENANCE</h1>
			<p class="text-center">Notre site est actuellement en cours de maintenance.</p>
			<p class="text-center">Veuillez réessayer plus tard.</p>
			<hr>
			<p class="text-center">Our site is currently undergoing maintenance.</p>
			<p class="text-center">Please try again at a later time.</p>
		</div>
		</div>
	</div>

</body>
</html>
