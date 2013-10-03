<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									
								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<p><?php the_excerpt(); ?></p>
									 <?php
									 	$slug = get_the_slug();
									 	$episodes = new WP_Query('post_type=episode&category_name='.$slug.'&posts_per_page=-1&orderby=title&order=ASC&tag__not_in=35');
									 	$interview = new WP_Query('post_type=episode&category_name='.$slug.'&posts_per_page=-1&orderby=title&order=ASC&tag__in=35');
									 			if ($episodes->have_posts()) {
													echo '<ul class="playlist small">';
													while ( $episodes->have_posts() ) {
															$episodes->the_post();
															$count++;
															echo '<li class="episode-'.$count.'"><a href="'.get_field('mp3_source').'"><i></i>' . get_the_title() . '</a></li>';
													}
													$count = 0;
													$ep2 = 'Tisdag<br />';
													$ep3 = 'Onsdag<br />';
													$ep4 = 'Torsdag<br />';
													$ep5 = 'Fredag<br />';

													if ($episodes->post_count == 1) {
														echo $ep2;
														echo $ep3;
														echo $ep4;
														echo $ep5;
													}elseif($episodes->post_count == 2){
														echo $ep3;
														echo $ep4;
														echo $ep5;
													}elseif($episodes->post_count == 3){
														echo $ep4;
														echo $ep5;
													}elseif($episodes->post_count == 4){
														echo $ep5;
													}
													wp_reset_query();
													echo '</ul>';

													echo '<ul class="playlist-nav">';
													while ( $episodes->have_posts() ) {
															$episodes->the_post();
															$count++;
															echo '<li><a href="#episode-'.$count.'"><i></i>' . get_the_title() . '</a></li>';
													}
													$count = 0;
													$ep2 = 'Tisdag<br />';
													$ep3 = 'Onsdag<br />';
													$ep4 = 'Torsdag<br />';
													$ep5 = 'Fredag<br />';

													if ($episodes->post_count == 1) {
														echo $ep2;
														echo $ep3;
														echo $ep4;
														echo $ep5;
													}elseif($episodes->post_count == 2){
														echo $ep3;
														echo $ep4;
														echo $ep5;
													}elseif($episodes->post_count == 3){
														echo $ep4;
														echo $ep5;
													}elseif($episodes->post_count == 4){
														echo $ep5;
													}
													//wp_reset_query();
													echo '</ul><hr />';

												}else{
													echo '<i>Inga avsnitt.</i>';
												}
												wp_reset_query();
												/*if ($interview->have_posts()) {
													echo '<ul class="playlist">';
													while ( $interview->have_posts() ) {
															$interview->the_post();
															echo '<li><a href="'.get_field('mp3_source').'"><i></i>' . get_the_title() . '</a></li>';
													}
													//wp_reset_query();
													echo '</ul>';
												}else{
													echo '<i>Ingen intervju.</i>';
												}
												wp_reset_query();*/
																			 
									?>
									<div id="sm2-container">
  										<!-- SM2 flash goes here -->
									 </div>
								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php //the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>
								<img class="offer" src="http://placehold.it/300x120/" />
							</article> <!-- end article -->

							<div class="media">

								<div id="tabs">
								  <ul>
								    <li><a href="#read-more"><span>Läs Mer</span></a></li>
								    <li><a href="#media"><span>Lyssna</span></a></li>
								  </ul>
								  	<div id="media">							  
									<?php the_post_thumbnail('featured');

									if ($episodes->have_posts()) {
														echo '<ul id="main-player" class="playlist init main">';
														while ( $episodes->have_posts() ) {
																$episodes->the_post();
																$count++;
																echo '<li id="episode-'.$count.'"';
																if ($count==1) {echo 'style="display:block"';}
																echo '><a href="'.get_field('mp3_source').'"><i></i>' . get_the_title() . '</a></li>';
														}
														echo "</ul>";
									}
									$count = 0;
									wp_reset_query();
									?>
									<div class="sharing">
										<img src="http://placehold.it/120x70/" />
									</div>
									
									</div>
									<div id="read-more">
										<section class="entry-content">
											<div class="columns">
												<?php the_content(); ?>
											</div>
										</section>
									</div>
								</div>
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
					<div style="clear:both"></div>
					<?php grid_archive(false,'book','3'); ?>
				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
