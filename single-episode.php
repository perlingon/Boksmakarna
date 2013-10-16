<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php 
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
							?>
							<div class="post-wrapper">
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">

								<header class="article-header">

									<h4 class="h4"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Fredagsintervju</a></h3>
									<h2 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $tag_title; ?></a></h3>

								</header> <!-- end article header -->

								<section class="entry-content clearfix">

									<?php the_excerpt(); ?>
									

								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php echo do_shortcode('[ssba url='.get_permalink().']'); ?>
									<?php
									$category = get_the_category(); 
									$slug = $category[0]->slug;

									$args = array( 'posts_per_page' => 1, 'name' => $slug, 'post_type' => 'book');
									$theposts = get_posts( $args );

									foreach($theposts as $post) :

									setup_postdata($post);
									
									echo '<h4>Provlyssna boken</h4><h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';

									endforeach;

									wp_reset_postdata();
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
									<?php the_post_thumbnail('featured');?>
									<?php if (get_field('mp3_source')) {?>
									<div class="player">
										<ul class="playlist init">
											  <!-- files from the web (note that ID3 information will *not* load from remote domains without permission, Flash restriction) -->
											  <li><a href="<?php the_field('mp3_source'); ?>"><i></i>Fredagsintervju - <?php echo $tag_title; ?></a></li>
										</ul>
									</div>
									<?php }?>
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
					<?php grid_archive(false,'episode'); ?>
				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
