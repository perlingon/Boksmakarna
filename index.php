<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">
						<hr />
						<div id="editorial">
							<div class="push-spaces">
								<?php dynamic_sidebar( 'push_spaces' ); ?>
							</div>
							<div class="news">
								<hr />
								<div class="widget">
									<div class="separator"></div>
									<span class="headline">Aktuellt</span>
									<?php 
										$news = new WP_Query('posts_per_page=1&orderby=date&status=published');
										if ($news->have_posts()) {
											while ( $news->have_posts() ) {
												$news->the_post();
												echo '<a href="'.get_permalink().'"><h4 class="widgettitle">'.get_the_title().'</h4></a>';
												echo '<div class="textwidget">'.get_the_excerpt().'</div>';
												echo '<span>'.get_the_date('Y.m.d').'</span>';
											}
										}
										wp_reset_query();
									?>
									<span class="link"><a href="/nyheter">Fler nyheter</a></span>
								</div>
							</div>
						</div>
						<hr />
						<div id="main" class="eightcol first clearfix" role="main">

						<div class="grid-container">
							<?php if (have_posts()) : while (have_posts()) : the_post();
								$count++;
								$writers = get_the_terms( $post->ID , 'writer' );
								$genres = get_the_terms( $post->ID , 'genre' );
								echo '<div id="block-'.$count.'" class="grid-item post '.get_the_slug();
								foreach ( $writers as $writer ) {echo ' '.$writer->slug;}
								foreach ( $genres as $genre ) {echo ' '.$genre->slug;}
								echo '">';
								echo '<a href="'.get_permalink().'">';
								lazyload_thumbnail('grid-block');
								echo "</a>";
								echo '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
								echo '<ul class="tags">';
								foreach ( $writers as $writer ) {echo '<li><a href="#" class="writer-tag" data-filter=".'.$writer->slug.'">'.$writer->name.'</a></li>';}
								foreach ( $genres as $genre ) {echo '<li><a href="#" class="genre-tag" data-filter=".'.$genre->slug.'">'.$genre->name.'</a></li>';}
								echo '</ul>';
								echo '<p>'.get_field('short_description').'</p>';
								echo '<div class="timestamp">'.get_the_time('U').'</div>';
								echo '</div>';
								endwhile;
								$count=0;
							?>
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
