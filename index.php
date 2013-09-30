<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

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
								echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
								echo '<ul class="tags">';
								foreach ( $writers as $writer ) {echo '<li><a href="#" class="writer-tag" data-filter=".'.$writer->slug.'">'.$writer->name.'</a></li>';}
								foreach ( $genres as $genre ) {echo '<li><a href="#" class="genre-tag" data-filter=".'.$genre->slug.'">'.$genre->name.'</a></li>';}
								echo '</ul>';
								echo '<p>'.get_field('short_description').'</p>';
								echo '<em class="date">'.get_the_date('Ymd').'</em>';
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
