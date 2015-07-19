<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage mictheme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="site">
  <div id="site">
      <div id="headerbox" style="margin:0px auto; width:70%">
      <!-- columns divs, float left, no margin so there is no space between column, width=1/3 -->
      <div id="column1" style="float:left; margin:0; width:33%;">
       <a href="/">Michael's site</a>
      </div>
      <div id="column2" style="float:left; margin:0;width:33%;">
       <a href="/10-2/">Blog</a>
      </div>
      <div id="column3" style="float:left; margin:0;width:33%">
       Menu
      </div>
  </div>
  <div style="clear: both;"></div>

  <div id="content" class="site-content">
