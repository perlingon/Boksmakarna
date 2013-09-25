<?php get_header(); ?>
			<div id="content">

				<div id="inner-content" class="wrap clearfix">
						<div id="featured-content">
							<div id="push-spaces">
							<?php dynamic_sidebar( 'push_spaces' ); ?>
							<div class="widget">
								<h4>Nyheter</h4>
							</div>
							</div>
						</div>
						<div id="main" class="eightcol first clearfix" role="main">

							<?php grid_archive(true); ?>

						</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
