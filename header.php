<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- drop Google Analytics Here -->
		<!-- end analytics -->

	</head>

	<body <?php body_class(); ?>>

		<div class="border"></div>
		<a href="#container" id="scrolltop-btn" style="position:fixed"></a>
		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap clearfix">

					<!-- if you'd like to use the site description you can un-comment it below -->
					<?php // bloginfo('description'); ?>

					<nav role="navigation" >
						<?php bones_main_nav(); ?>
					</nav>
					<?php 
						$attachment_id = get_field('logo','option');
						$size = "logo"; // (thumbnail, medium, large, full or custom size)
						 
						$logo = wp_get_attachment_image_src( $attachment_id, $size );
						echo '<a href="'.home_url().'" rel="nofollow"><img class="logo" src="'.$logo[0].'" alt="'.get_bloginfo('name').'" /></a>';
					?>
					<div class="social-box"><img src="http://placehold.it/200x80/" /></div>
					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					

				</div> <!-- end #inner-header -->

			</header> <!-- end header -->
			<?php 
				if (is_home()) {
					//echo '<a href="'.home_url().'" rel="nofollow"><img class="logo" src="'.$logo[0].'" alt="'.get_bloginfo('name').'" /></a>';
					require_once( 'library/slider.php' );
				}
			?>
	<div class="center">
			<?php 
				if (!is_home()) {
					echo '<hr />';
				}
			?>
