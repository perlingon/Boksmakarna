<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix main">
					<div id="main" class="eightcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								
								<div class="info-wrapper">
								<header class="article-header">
									<?php is_latest_post_sticker($post->ID,'book');?>
									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									<div class="taxonomies">
										<?php
											$book_title = get_the_title();
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
									echo '<div class="read-more-small"><h4>'.get_the_title().'</h4><p>'.get_the_content().' <a href=":;javascript" class="close">Visa mindre</a><p></div>';

									if( has_term( 'yes', 'upcoming' ) ) {
									    echo 'Avsnitt kommer snart...';
									}else if(!get_field('podcast_book_id')){
										echo 'Bokens ID är inte ifyllt.';
									}else{
									 	
									 	$book_id_searchterm = get_field('podcast_book_id').'.';
										
									 	$episodes = new WP_Query('post_type=episode&s='.$book_id_searchterm.'&category_name=avsnitt-1,avsnitt-2,avsnitt-3,avsnitt-4,avsnitt-5&posts_per_page=-1&orderby=title&order=ASC');
									 	$interview = new WP_Query('post_type=episode&s='.$book_id_searchterm.'&category_name=fredagsintervjun&posts_per_page=-1&orderby=title&order=ASC');
									 	if (get_field('voice_actor')) {
									 		$voice_actor = 'Uppläsare: '.get_field('voice_actor');
									 	}
									 	
									 			if ($episodes->have_posts()) {
													echo '<ul class="playlist small small-list">';
												
														while ( $episodes->have_posts() ) {
																$episodes->the_post();

																// Make title with category
																$postcats = get_the_category();
																if ( $postcats && ! is_wp_error( $postcats ) ) : 
																	$cats = array();
																	foreach ( $postcats as $postcat) {
																			$cats[] = $postcat->name;
																	}		
																	$episode_cat_title = join( ' ', $cats );
																endif;

																//Find page numbers in parenthases
																$string = get_the_title();
																$regex = '#\((([^()]+|(?R))*)\)#';
																if (preg_match_all($regex, $string ,$matches)) {
																    $pages = ' '.implode(' ', $matches[0]).'';
																}else{
																	$pages = '';
																}

																$count++;
																if ($episodes->post_count === 1) {
																	echo '<li class="episode-'.$count.' new-play"><a href="'.get_field('mp3_source').'"><i></i><h5>Provlyssna</h5> ' . $book_title .'</a><p>'. $voice_actor .'</p></li>';
																}else{
																	echo '<li class="episode-'.$count.'"><a href="'.get_field('mp3_source').'"><i></i>' . $episode_cat_title . $pages .'</a></li>';
																}
														}

													$count = 0;

													/*
													$day = date('l');

													
													$start = '<ul class="upcoming-episode">';
													$ep2 = '<li>Avsnitt 2 kommer tisdag</li>';
													$ep3 = '<li>Avsnitt 3 kommer onsdag</li>';
													$ep4 = '<li>Avsnitt 4 kommer torsdag</li>';
													$ep5 = '<li>Avsnitt 5 kommer fredag</li>';
													$end = '</ul>';

													if ($day == 'Monday') {
														$ep2 = '<li>Avsnitt 2 kommer imorgon</li>';
													}

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
													*/
													wp_reset_query();
													echo '</ul>';

													echo '<ul class="playlist-nav">';
													while ( $episodes->have_posts() ) {
															$episodes->the_post();
															
															// Make title with category
															$postcats = get_the_category();
															if ( $postcats && ! is_wp_error( $postcats ) ) : 
																$cats = array();
																foreach ( $postcats as $postcat) {
																		$cats[] = $postcat->name;
																}		
																$episode_cat_title = join( ' ', $cats );
															endif;

															//Find page numbers in parenthases
															$string = get_the_title();
															$regex = '#\((([^()]+|(?R))*)\)#';
															if (preg_match_all($regex, $string ,$matches)) {
															    $pages = ' ('.implode(' ', $matches[1]).')';
															}else{
																$pages = '';
															}

															$count++;
															if ($episodes->post_count === 1) {
																	echo '<li class="new-play"><a href=":;javascript" data="episode-'.$count.'"><i></i><div class="text"><h5>Provlyssna</h5><h4>'.$book_title.'</h4></div><div style="clear:both"></div><span>'.$voice_actor.'</span></li>';
																}else{
																	echo '<li><a href=":;javascript" data="episode-'.$count.'"><i></i><span>' . $episode_cat_title . $pages .'</span></a></li>';
																}
													}
													$count = 0;

													/*
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
													}*/
													//wp_reset_query();
													echo '</ul>';

												}else{
													//echo '<i>Inga avsnitt.</i>';
												}
												wp_reset_query();
												if ($interview->have_posts()) {
													echo '<div class="interview infobox">';
													while ( $interview->have_posts() ) {
															$interview->the_post();
															
															$title = get_the_title();
															$title = substr($title, strrpos($title, "-") + 1);
															
															echo '<a href="'.get_permalink().'">';
															echo '<div class="icon"></div>';
															echo '<div class="text">';
															echo "<h5>Fredagsintervjun</h5>";
															echo '<h4>'.$title.'</h4>';
															echo '</div>';
															echo '</a>';
															echo '<div style="clear:both"></div>';
													}
													
													echo '</div>';
													echo '<div style="clear:both"></div>';
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
									$offer_count = 0;
									echo '<div class="offer infobox">';
										while (has_sub_field('offer')) {

										$scheduling = get_sub_field('scheduling');

										if ($scheduling) {
											$first_row = $scheduling[0];
											$today = date("Ymd");
											
											if ($first_row['start_date']) {
												$start_date = $first_row['start_date'];
											}else{
												$start_date = $today;
											}
											
											if ($first_row['end_date']) {
												$end_date = $first_row['end_date'];
											}else{
												$end_date = 99999999;
											}
											
											if(($today >= $start_date) && ($today <= $end_date)){
												$valid_offer = true;
											}
										}

										if ($valid_offer) {
											
										$offer_count++;
								?>
									
									<div class="offer-item item-<?php echo $offer_count; ?>">
									<?php if (get_sub_field('link')) {?>
											<a class="buy-link" href="<?php the_sub_field('link'); ?>" target="_blank" title="<?php the_sub_field('headline'); ?>">
	 								<?php } ?>
	 								<h5><?php the_sub_field('headline');?></h5>
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
									</div>
								<?php 
								if ($offer_count == 1) {
									echo '<div class="slash"></div>';
								}
								}};
								echo '<div style="clear:both"></div>';
								echo "</div>";
								};
								?>
								
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
								  	<div class="latest-sticker"><?php is_latest_post_sticker($post->ID,'book');?></div>							  
									<?php the_post_thumbnail('featured');
									if( !has_term( 'yes', 'upcoming' ) && get_field('podcast_book_id') ) {
									if ($episodes->have_posts()) {
														echo '<ul id="main-player" class="playlist init main">';
														while ( $episodes->have_posts() ) {
															$episodes->the_post();
																
																// Make title with category
																$postcats = get_the_category();
																if ( $postcats && ! is_wp_error( $postcats ) ) : 
																	$cats = array();
																	foreach ( $postcats as $postcat) {
																			$cats[] = $postcat->name;
																	}		
																	$episode_cat_title = join( ' ', $cats );
																endif;

																//Find page numbers in parenthases
																$string = get_the_title();
																$regex = '#\((([^()]+|(?R))*)\)#';
																if (preg_match_all($regex, $string ,$matches)) {
																    $pages = ' ('.implode(' ', $matches[1]).')';
																}else{
																	$pages = '';
																}


																$count++;
																echo '<li id="episode-'.$count.'"';
																if ($count==1) {echo 'style="display:block"';}
																if ($episodes->post_count === 1) {
																	echo '><a href="'.get_field('mp3_source').'"><i></i>' . $book_title .'</a></li>';
																}else{
																	echo '><a href="'.get_field('mp3_source').'"><i></i>' . $episode_cat_title . $pages .'</a></li>';
																}
														}
														echo "</ul>";
														echo '<div class="sharing">';
														echo do_shortcode('[ssba]');
														echo '</div>';
									}
									$count = 0;
									wp_reset_query();
									}
									?>
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
