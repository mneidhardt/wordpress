<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage jactheme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body>
<div id="header">
  <ul class="menu">
    <li class="menuheadentry"><a href="/">Jacob Langvad/BXL</a></li>
    <li class="menuentry leftspaced"><a href="/Artikler">Artikler</a></li>
    <li class="menuentry"><a href="/Radio">Radio</a></li>
    <li class="menuentry"><a href="/Boger">Bøger</a></li>
    <li class="menuentry"><a href="/Foredrag">Foredrag</a></li>
    <li class="menuentry"><a href="/Kurser">Kurser</a></li>
    <li class="menuentry leftspaced"><a href="/Kontakt">Kontakt</a></li>
</div>
