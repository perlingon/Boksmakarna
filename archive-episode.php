<?php get_header(); ?>
			
			<div id="content" class="episodes">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post();?>
							<?php 
								$title = get_the_title();
								$title = substr($title, strrpos($title, "-") + 1);
							?>
							<div class="post-wrapper">
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

								<header class="article-header">

									<h4 class="h4"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Fredagsintervjun</a></h3>
									<h2 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $title; ?></a></h3>

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
									
									<?php if (get_field('mp3_source')) {?>
									<div class="player">
										<ul class="playlist init small">
											  <!-- files from the web (note that ID3 information will *not* load from remote domains without permission, Flash restriction) -->
											  <li><a href="<?php the_field('mp3_source'); ?>"><i></i>Fredagsintervjun - <?php echo $title; ?></a></li>
										</ul>
									</div>
									<?php }?>

								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php echo do_shortcode('[ssba url='.get_permalink().']'); ?>
									<?php
									$book_id = substr(get_the_title(), 0, 1);

									$args = array( 'posts_per_page' => 1, 'post_type' => 'book', 'meta_key' => 'podcast_book_id','meta_value' => $book_id);
									$theposts = get_posts( $args );
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
								<?php 

								if (!get_field('thumbnail')) {
									the_post_thumbnail('featured');
								}else{
									echo '<img class="attachment-featured wp-post-image" src="'.get_field('thumbnail').'" />';
								}
								
								 ?>
							
							<div class="player">
								<ul class="playlist init">
									  <!-- files from the web (note that ID3 information will *not* load from remote domains without permission, Flash restriction) -->
									  <li><a href="<?php the_field('mp3_source'); ?>"><i></i>Fredagsintervjun - <?php echo $title; ?></a></li>
								</ul>
							</div>
							</div>
							<div style="clear:both"></div>
							<hr />
						</div>
							<?php endwhile; ?>

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
												<p><?php _e( 'This is the error message in the custom posty type archive template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div> <!-- end #main -->

								</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
