<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php
							$book_id = substr(get_the_title(), 0, 1);
							$args = array( 'posts_per_page' => 1, 'post_type' => 'book', 'meta_key' => 'podcast_book_id','meta_value' => $book_id);
							$theposts = get_posts( $args );

							$title = get_the_title();

							if ( 'fredagsintervjun' == has_category() ){
								$title = substr($title, strrpos($title, "-") + 1);
								$type_tag = 'Fredagsintervjun';
							}else{
								$regex = '#\((([^()]+|(?R))*)\)#';
								if (preg_match_all($regex, $title ,$matches)) {
									$pages = ' '.implode(' ', $matches[0]).'';
								}else{
									$pages = '';
								}
								// Make title with category
								$postcats = get_the_category();
								if ( $postcats && ! is_wp_error( $postcats ) ) : 
									$cats = array();
									foreach ( $postcats as $postcat) {
											$cats[] = $postcat->name;
									}		
									$title = join( ' ', $cats );
								endif;

								$title = $title.$pages;
								$type_tag = 'Fredagsintervjun';

								if ($theposts) {
										foreach($theposts as $post) :
										setup_postdata($post);
										$type_tag = get_the_title();
										endforeach;
										wp_reset_postdata();
								}
							}

							
							?>
							<div class="post-wrapper">
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

								<header class="article-header">

									<h4 class="h4"><?php echo $type_tag; ?></h3>
									<h2 class="h2"><?php echo $title; ?></h3>

								</header> <!-- end article header -->

								<section class="entry-content clearfix">
									<div class="small-image">
									<?php 

										if (!get_field('thumbnail')) {
											the_post_thumbnail('featured');
										}else{
											echo '<img class="attachment-featured wp-post-image" src="'.get_field('thumbnail').'" />';
										}
								
									 ?>
									</div>
									<?php the_excerpt(); ?>
									<?php echo '<div class="read-more-small"><h4>'.$type_tag.' - '.$title.'</h4><p>'.get_the_content().' <a href=":;javascript" class="close">Visa mindre</a><p></div>';?>

									<?php if (get_field('mp3_source')) {?>
									<div class="player">
										<ul class="playlist init small">
											  <!-- files from the web (note that ID3 information will *not* load from remote domains without permission, Flash restriction) -->
											  <li><a href="<?php the_field('mp3_source'); ?>"><i></i><?php echo $type_tag; ?> - <?php echo $title; ?></a></li>
										</ul>
									</div>
									<?php }?>
									

								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php echo do_shortcode('[ssba url='.get_permalink().']'); ?>
									<?php
									

									if ($theposts) {
										foreach($theposts as $post) :
										setup_postdata($post);
										echo '<h4>Provlyssna boken</h4><h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
										endforeach;
										wp_reset_postdata();
									}
									?>
									
								</footer> <!-- end article footer -->

							</article> <!-- end article -->

							<div class="media">
							<div id="tabs">
								  <ul>
								    <li><a href="#read-more"><span>Läs Mer</span></a></li>
								    <li><a href="#listen"><span>Lyssna</span></a></li>
								  </ul>
								  	<div id="listen">							  
									<?php 

										if (!get_field('thumbnail')) {
											the_post_thumbnail('featured');
										}else{
											echo '<img class="attachment-featured wp-post-image" src="'.get_field('thumbnail').'" />';
										}
								
								 	?>
									<?php if (get_field('mp3_source')) {?>
									<div class="player">
										<ul class="playlist init">
											  <!-- files from the web (note that ID3 information will *not* load from remote domains without permission, Flash restriction) -->
											  <li><a href="<?php the_field('mp3_source'); ?>"><i></i><?php echo $type_tag; ?> - <?php echo $title; ?></a></li>
										</ul>
									</div>
									<?php }?>
									</div>
									<div id="read-more">
										<section class="entry-content">
											<div class="columns">
												<p>
												<?php the_content(); ?>
												</p>
											</div>
										</section>
									</div>
								</div>
							</div>
							<div style="clear:both"></div>
							<hr />
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
					<?php grid_archive(false,'episode',3); ?>
				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
