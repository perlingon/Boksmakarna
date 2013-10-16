<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									<p class="byline vcard"><?php
										printf( __( '<time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme' ), get_the_time( 'Y.m.d' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );
									?></p>

								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php
										$content = get_the_content();
										echo wpautop($content);
									 ?>
									 <div class="navigation">
									<?php previous_post_link('%link', 'Nästa Artikel >'); ?>
									</div>
								</section> <!-- end article section -->

								<footer class="article-footer">
									<?php echo do_shortcode('[ssba]'); ?>
								</footer> <!-- end article footer -->

								<?php comments_template(); ?>

							</article> <!-- end article -->

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

				</div> <!-- end #inner-content -->

				<div class="archive-list">
						<h4>Artiklar</h4>
						<hr />
						<div class="list-wrapper">
							<div class="archive-slider">
							<div>
						<?php $posts = new WP_Query('showposts=-1&orderby=date&order=desc');
						
						if ($posts->post_count < 5) {
							$items = 1;
						}else if($posts->post_count < 9){
							$items = 2;
						}else{
							$items = 3;
						}
						?>


							<?php foreach(new WP_Query_Columns($posts, $items) as $column => $column_count) : ?>
							<?php 
							    	if($column % 4 == 0){
									    echo '</div><div class="rsContent separator">';
									}
							?>
							    <ul>
							        <?php while ($column_count--) : $posts->the_post(); ?>
							        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
							        <?php endwhile; ?>
							    </ul>
							<?php endforeach; ?>
						<?php wp_reset_query();?>
					</div></div>
					<div style="clear:both"></div>
					</div>
				
				</div>
				<div style="clear:both"></div>

			</div> <!-- end #content -->

<?php get_footer(); ?>
