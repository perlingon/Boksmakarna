<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
							<?php 
							$titles = new WP_Query('post_type='.$post_type.'&posts_per_page=-1&orderby=title');
		
							$all_writers = get_terms("writer");
							$all_genres = get_terms("genre");
							
							$count_writers = count($all_writers);
							$count_genres = count($all_genres);
							
							
							if ($titles->have_posts()) {
								echo '<select data-placeholder="Titel..." id="titles" class="chosen-select" multiple tabindex="4">';
								while ( $titles->have_posts() ) {
										$titles->the_post();
										echo '<option value=".'.get_the_slug().'">' . get_the_title() . '</option>';

								}
								wp_reset_query();
								echo '</select>';
							}
							
							if ( $count_writers > 0 ){
							     echo '<select data-placeholder="Författare..." id="writers" class="chosen-select" multiple tabindex="4">';
							     foreach ( $all_writers as $writer ) {
							       echo '<option value=".'.$writer->slug.'">' . $writer->name . '</option>';
							     }
							     echo "</select>";
							 }

							if ( $count_genres > 0 ){
							     echo '<select data-placeholder="Genre..." id="genres" class="chosen-select" multiple tabindex="4">';
							     foreach ( $all_genres as $genre ) {
							       echo '<option value=".'.$genre->slug.'">' . $genre->name . '</option>';
							     }
							     echo "</select>";
							 }
							 
							?>
							<div class="sorting">
								<ul>Sortera på:</ul>
								<ul class="sort-by">
									<li class="active"><a href="#date">Datum</a></li>
									<li><a href="#title" id="sort-book" class="title">Titel</a></li>
								</ul>
								<ul class="sort-order">
									<li><a href="#">Stigande</a></li>
								</ul>
							</div>
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
									<?php if ( function_exists( 'bones_page_navi' ) ) { ?>
										<?php bones_page_navi(); ?>
									<?php } else { ?>
										<nav class="wp-prev-next">
											<ul class="clearfix">
												<li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'bonestheme' )) ?></li>
												<li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'bonestheme' )) ?></li>
											</ul>
										</nav>
									<?php } ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the archive.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div> <!-- end #main -->

						

								</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
