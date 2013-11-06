<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">
						<hr />
						<div id="editorial">
							<div class="news">
								<div class="widget">
									<div class="separator"></div>
									<span class="headline">Aktuellt</span>
									<?php 
										$news = new WP_Query('posts_per_page=1&orderby=date&status=published');
										if ($news->have_posts()) {
											while ( $news->have_posts() ) {
												$news->the_post();
												echo '<a href="'.get_permalink().'"><h3 class="widgettitle">'.get_the_title().'</h3></a>';
												echo '<div class="textwidget"><p class="sweet-justice">'.excerpt(14).'</p></div>';
												echo '<span>'.get_the_date('Y.m.d').'</span>';
											}
										}
										wp_reset_query();
										$archive_year = get_the_time('Y');
									?>
								</div>
								<span class="link"><a href="<?php echo get_year_link($archive_year); ?>">Fler nyheter</a></span>
							</div>
							<div class="push-spaces">
								<hr />
								<?php dynamic_sidebar( 'push_spaces' ); ?>
								<div style="clear:both"></div>
							</div>
						</div>
						<hr />
						<div id="main" class="eightcol first clearfix" role="main">
						<div class="grid-head">
						<!--<h4 class="grid-headline">Nya böcker</h4>
						<hr/>-->
						</div>
						<div class="grid-container">
							<?php if (have_posts()) : while (have_posts()) : the_post();
								$count++;
								$writers = get_the_terms( $post->ID , 'writer' );
								$genres = get_the_terms( $post->ID , 'genre' );
								
								echo '<div id="block-'.$count.'" class="grid-item post ';
								if( has_term( 'yes', 'upcoming' ) ) {echo 'upcoming ';}
								echo get_the_slug();
								foreach ( $writers as $writer ) {echo ' '.$writer->slug;}
								foreach ( $genres as $genre ) {echo ' '.$genre->slug;}
								echo '">';

								is_latest_post_sticker($post->ID,'book');
								
								if(!has_term( 'yes', 'upcoming' ) ) {echo '<a href="'.get_permalink().'">';}
								if( has_term( 'yes', 'upcoming' ) ) {
									echo '<div class="overlay">';
									if (get_field('upcoming_date')) {
										$date = date_i18n('d F', strtotime(get_field('upcoming_date')));
										echo 'Kommer '.$date;
									}else{
										echo 'Kommer snart...';
									}
									echo "</div>";
								}
								the_post_thumbnail('grid-block');
								if(!has_term( 'yes', 'upcoming' ) ) {echo '</a>';}
								echo '<div class="belowimg">';
								if(!has_term( 'yes', 'upcoming' ) ) {
								echo '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
								echo '<div class="label"><a href="'.get_permalink().'">Lyssna</a></div>';
								}else{
								echo '<h4>'.get_the_title().'</h4>';
								}
								if ( $writers && ! is_wp_error( $writers ) ) : 
									$writer_links = array();
									foreach ( $writers as $writer ) {
										$writer_links[] = '<a href="'.get_post_type_archive_link('book').'#filter=.'.$writer->slug.'" class="writer-tag" data-filter=".'.$writer->slug.'">'.$writer->name.'</a>';
										//$writer_links[] = $writer->name;
									}
									$list = join( ", ", $writer_links );
									echo '<div class="tags writer-tags">'.$list.'</div>';
								endif;
								echo '<p class="sweet-justice">'.get_field('short_description').'</p>';
								echo '<div class="timestamp">'.get_the_time('U').'</div>';
								if ( $genres && ! is_wp_error( $genres ) ) : 
									$genre_links = array();
									foreach ( $genres as $genre ) {
										$genre_links[] = '<a href="'.get_post_type_archive_link('book').'#filter=.'.$genre->slug.'" class="genre-tag" data-filter=".'.$genre->slug.'">'.$genre->name.'</a>';
										//$genre_links[] = $genre->name;
									}
									$list = join( " / ", $genre_links );
									echo '<div class="tags genre-tags">'.$list.'</div>';
								endif;
								echo '</div>';
								echo '</div>';
								endwhile;
								$count=0;
							?>
							<div style="clear:both"></div>
						</div>
						<div class="grid-foot">
						<a href="<?php echo get_post_type_archive_link( 'book' ); ?>">Till Biblioteket ></a>
						</div>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
											<header class="article-header">
												<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
											<section class="entry-content">
												<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the index.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
