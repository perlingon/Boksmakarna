<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<div class="info-wrapper">
								<header class="article-header">

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									<div class="taxonomies">
										<?php
											
											$writers = get_the_terms( $post->ID , 'writer' );
											if ( $writers && ! is_wp_error( $writers ) ) : 
												$writer_links = array();

												foreach ( $writers as $writer ) {
													$writer_links[] = '<a href="'.get_post_type_archive_link('book').'#filter=.'.$writer->slug.'" >'.$writer->name.'</a>';
												}
																	
												$list = join( ", ", $writer_links );
												echo '<div class="writers">'.$list.'</div>';

											endif;

											?>
									</div>
									<div class="cover"><?php the_post_thumbnail('featured'); ?></div>
								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php 

									echo '<p>'.excerpt(14).'</p>';

									if( has_term( 'yes', 'upcoming' ) ) {
									    echo 'Avsnitt kommer snart...';
									}else{

									 	$slug = get_the_slug();
									 	$episodes = new WP_Query('post_type=episode&category_name='.$slug.'&posts_per_page=-1&orderby=title&order=ASC&tag__not_in=20');
									 	$interview = new WP_Query('post_type=episode&category_name='.$slug.'&posts_per_page=-1&orderby=title&order=ASC&tag__in=20');
									 			if ($episodes->have_posts()) {
													echo '<ul class="playlist small">';
													while ( $episodes->have_posts() ) {
															$episodes->the_post();
															$count++;
															echo '<li class="episode-'.$count.'"><a href="'.get_field('mp3_source').'"><i></i>' . get_the_title() . '</a></li>';
													}
													$count = 0;

													$day = date('l');

													$start = '<ul class="upcoming-episode">';
													$ep2 = '<li>Avsnitt 2 kommer tisdag</li>';
													$ep3 = '<li>Avsnitt 3 kommer onsdag</li>';
													$ep4 = '<li>Avsnitt 4 kommer torsdag</li>';
													$ep5 = '<li>Avsnitt 5 kommer fredag</li>';
													$end = '</ul>';

													if ($day == 'Tuesday') {
														$ep2 = '<li>Avsnitt 2 kommer idag</li>';
														$ep3 = '<li>Avsnitt 3 kommer imorgon</li>';
													}

													if ($day == 'Wednesday') {
														$ep3 = '<li>Avsnitt 3 kommer idag</li>';
														$ep4 = '<li>Avsnitt 4 kommer imorgon</li>';
													}

													if ($day == 'Thursday') {
														$ep4 = '<li>Avsnitt 4 kommer idag</li>';
														$ep5 = '<li>Avsnitt 5 kommer imorgon</li>';
													}

													if ($day == 'Friday') {
														$ep5 = '<li>Avsnitt 5 kommer idag</li>';
													}

													

													if ($episodes->post_count == 1) {
														echo $start;
														echo $ep2;
														echo $ep3;
														echo $ep4;
														echo $ep5;
														echo $end;
													}elseif($episodes->post_count == 2){
														echo $start;
														echo $ep3;
														echo $ep4;
														echo $ep5;
														echo $end;
													}elseif($episodes->post_count == 3){
														echo $start;
														echo $ep4;
														echo $ep5;
														echo $end;
													}elseif($episodes->post_count == 4){
														echo $start;
														echo $ep5;
														echo $end;
													}
													wp_reset_query();
													echo '</ul>';

													echo '<ul class="playlist-nav">';
													while ( $episodes->have_posts() ) {
															$episodes->the_post();

															$posttags = get_the_tags();
															if ( $posttags && ! is_wp_error( $posttags ) ) : 
																$tags = array();
																foreach ( $posttags as $posttag ) {
																	if ($posttag->term_id !== '20') {
																		$tags[] = $posttag->name;
																	}
																}		
																$episode_tag_title = join( ' ', $tags );
															endif;

															$count++;
															echo '<li><a href=":;javascript" data="episode-'.$count.'"><i></i><span>' . $episode_tag_title . '</span></a></li>';
													}
													$count = 0;

													if ($episodes->post_count == 1) {
														echo $start;
														echo $ep2;
														echo $ep3;
														echo $ep4;
														echo $ep5;
														echo $end;
													}elseif($episodes->post_count == 2){
														echo $start;
														echo $ep3;
														echo $ep4;
														echo $ep5;
														echo $end;
													}elseif($episodes->post_count == 3){
														echo $start;
														echo $ep4;
														echo $ep5;
														echo $end;
													}elseif($episodes->post_count == 4){
														echo $start;
														echo $ep5;
														echo $end;
													}
													//wp_reset_query();
													echo '</ul>';

												}else{
													echo '<i>Inga avsnitt.</i>';
												}
												wp_reset_query();
												if ($interview->have_posts()) {
													echo '<div class="interview">';
													while ( $interview->have_posts() ) {
															$interview->the_post();
															$posttags = get_the_tags();
															if ( $posttags && ! is_wp_error( $posttags ) ) : 
																$tags = array();
																foreach ( $posttags as $posttag ) {
																	if ($posttag->term_id !== '20') {
																		$tags[] = $posttag->name;
																	}
																}		
																$tag_title = join( ' & ', $tags );
															endif;
															echo '<a href="'.get_permalink().'">';
															echo '<div><span class="icon"></span></div><h4>Fredagsintervju - '.$tag_title.'</h4>';
															echo '</a>';
													}
													
													echo '</div>';
													echo '<div style="clear:both"></div>';
												}else{
													echo '<i>Ingen intervju.</i>';
												}
												wp_reset_query();
											}

									?>
									<div id="sm2-container">
  										<!-- SM2 flash goes here -->
									 </div>
								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php //the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>
								</div>
								<?php if (get_field('offer')) {
										while (has_sub_field('offer')) {
								?>
								
								<div class="offer infobox">
									<?php if (get_sub_field('link')) {?>
											<a class="buy-link" href="<?php the_sub_field('link'); ?>" target="_blank" title="<?php the_sub_field('headline'); ?>">
	 								<?php } ?>
	 								<h4><?php the_sub_field('headline'); ?></h4>
									<div class="thumb">
										<?php 
										$partner = get_sub_field('partner');
 
										if( $partner ): 
										 
											// override $post
											$post = $partner;
											setup_postdata( $post ); 
										 	the_post_thumbnail('full');

											wp_reset_postdata();
											endif; ?>
									</div>
									<div class="info">
									<div class="description">
										<?php the_sub_field('description'); ?>
									</div>
									</div>
									<?php if (get_sub_field('link')) { echo '</a>';} ?>
									<br style="clear:both" />
								</div>
								<?php } };?>
								
							</article> <!-- end article -->

							<div class="media">
								<?php
								$genres = get_the_terms( $post->ID , 'genre' );
											if ( $genres && ! is_wp_error( $genres ) ) : 
												$genre_links = array();

												foreach ( $genres as $genre ) {
													$genre_links[] = '<a href="'.get_post_type_archive_link('book').'#filter=.'.$genre->slug.'" >'.$genre->name.'</a>';
												}
																	
												$list = join( ',', $genre_links );
												echo '<div class="genres">'.$list.'</div>';

											endif;
								?>
								<div id="tabs">
								  <ul>
								  	<?php
								  	/* if (get_field('offer')) {
								  		while (has_sub_field('offer')) {
								  		echo '<li><a href="'.get_sub_field('link').'"class="buy-button">Köp>></a></li>';
								  		}
								  	}*/ ?>
								    <li><a href="#read-more"><span>Läs Mer</span></a></li>
								    <li><a href="#listen"><span>Lyssna</span></a></li>
								  </ul>
								  	<div id="listen">							  
									<?php the_post_thumbnail('featured');
									if( !has_term( 'yes', 'upcoming' ) ) {
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
									}
									?>
									<div class="sharing">
									<?php echo do_shortcode('[ssba]'); ?>
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
					<hr />
					<div style="clear:both"></div>
					<?php grid_archive(false,'book','3'); ?>
				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
