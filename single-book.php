<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									<p class="byline vcard"><?php
										printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );
									?></p>

								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<div id="sm2-container">
  										<!-- SM2 flash goes here -->
									 </div>
									 <?php
									 	$slug = get_the_slug();
									 	$episodes = new WP_Query('post_type=episode&category_name='.$slug.'&posts_per_page=-1&orderby=title&order=ASC');
									 			if ($episodes->have_posts()) {
													echo '<ul class="graphic">';
													while ( $episodes->have_posts() ) {
															$episodes->the_post();
															echo '<li><a href="'.get_field('mp3_source').'">' . get_the_title() . '</a></li>';
													}
													wp_reset_query();
													echo '</ul>';
												}
																			 
									?>
									<br /><br />
									 <ul class="graphic">
									  <!-- files from the web (note that ID3 information will *not* load from remote domains without permission, Flash restriction) -->
									  <li><a href="http://www.freshly-ground.com/misc/music/carl-3-barlp.mp3">Avsnitt 1</a></li>
									  <li><a href="http://www.freshly-ground.com/data/audio/binaural/Mak.mp3">Avsnitt 2</a></li>
									  <li><a href="http://www.freshly-ground.com/data/audio/binaural/Things that open, close and roll.mp3">Avsnitt 3</a></li>
									  <li><a href="http://www.freshly-ground.com/misc/music/20060826%20-%20Armstrong.mp3">Avsnitt 4</a></li>
									  <li><a href="http://freshly-ground.com/data/video/Rain%20on%20Car%20Roof.aac">Avsnitt 5</a></li>
									 </ul>
									<?php the_field('short_description'); ?>
								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>

							</article> <!-- end article -->

							<div class="media">
								<?php the_post_thumbnail('cover'); ?>
							</div>

						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry clearfix">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
									</footer>
							</article>

						<?php endif; ?>

					</div> <!-- end #main -->
					<?php grid_archive(false,'book','3'); ?>
				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
