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
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no"/>

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
		
		<!-- TradeDoubler site verification 2355765 -->
	</head>

	<body <?php body_class(); ?>>
		<div id="top-element"></div>
		<div class="border"></div>
		<a href="#top-element" id="scrolltop-btn" title="Scrolla till toppen"style="position:fixed"></a>
		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap clearfix">

					<!-- if you'd like to use the site description you can un-comment it below -->
					<?php // bloginfo('description'); ?>

					<nav role="navigation" >
						<?php bones_main_nav(); ?>
					</nav>
					<?php 
						$logo_attachment_id = get_field('logo','option');
						$logo_img_size = "logo";
						$logo_img_size_retina = "logo@2x";
						 
						$logo = wp_get_attachment_image_src( $logo_attachment_id, $logo_img_size );
						$logo_retina = wp_get_attachment_image_src( $logo_attachment_id, $logo_img_size_retina );

						echo '<a href="'.home_url().'" rel="nofollow"><img class="logo no-retina" src="'.$logo[0].'" alt="'.get_bloginfo('name').'" /><img class="logo retina" src="'.$logo_retina[0].'" alt="'.get_bloginfo('name').'" /></a>';
					?>
					<div class="social-box">
						<ul class="social-icons">
							<h5>Följ podcasten</h5>
							<?php if (get_field('podcast_rss','option')) {
								echo '<li><a class="rss-link" title="Prenumera via RSS" href="'.get_field('podcast_rss','option').'" target="_blank"></a></li>';
							}
							if (get_field('itunes_url','option')) {
								echo '<li><a class="itunes-link" title="iTunes" href="'.get_field('itunes_url','option').'" target="_blank"></a></li>';
							}?>
						</ul>
					</div>
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
