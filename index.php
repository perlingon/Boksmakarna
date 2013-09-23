<?php get_header(); ?>
			<div id="content">

				<div id="inner-content" class="wrap clearfix">
						<div id="featured-content">

						<?php if( get_field('slides','option')){
							echo '<div id="slider" class="royalSlider heroSlider rsMinW rsDefault rsDefaultInv">';
							while( has_sub_field('slides','option') ):
								if( get_sub_field('link','option')){
			  					while(has_sub_field('link','option') ):
			  						if (get_sub_field('raw_link')) {
			  							echo '<a href="'.get_sub_field('raw_link').'" >';
			  						}else{
			  							$post_object = get_sub_field('object');
			  							setup_postdata( $post_object );
			  							echo '<a href="'.get_permalink().'" >';
			  							wp_reset_postdata();
			  						};
			  						
			  					endwhile;
			  					};
			  					echo '<div class="rsContent">';
									if( get_sub_field('images','option')){
				  					while(has_sub_field('images','option') ):
				  						echo '<img class="rsImg" src="'.get_sub_field('big').'"></img>';
				  					endwhile;
				  					};
								if(get_sub_field('template') !== "Veckans Bok"){
				  					if( get_sub_field('content') && get_sub_field('content_position')){
				  						echo '<div class="infoBlock infoBlockLeftBlack rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200"';
				  						if(get_sub_field('content_position','option')){
				  							while(has_sub_field('content_position','option') ):
				  								echo ' style="top:'.get_sub_field('xpos').'%;left:'.get_sub_field('ypos').'%">';
				  							endwhile;
				  						}else{
				  								echo '>';
				  						}
				  						the_sub_field('content');
				  						echo '</div>';
				  					};
			  					}
			  					echo '</div>';
			  					if( get_sub_field('link','option')){
			  						while(has_sub_field('link','option') ):
			  						echo '</a>';
			  						endwhile;
			  					};
			  				endwhile;
			  				echo '</div>';
		  					};
			  			?>
<!---
							<div id="slider" class="royalSlider heroSlider rsMinW rsDefault rsDefaultInv">
							  <div class="rsContent">
							    <img class="rsImg" src="http://placehold.it/960x460" alt="">
							  </div>
							  <div class="rsContent">
							    <img class="rsImg" src="http://placehold.it/960x460" alt="">
							  </div>
							 <div class="rsContent">
							    <img class="rsImg" src="http://placehold.it/960x460" alt="">
							  </div>
							  <div class="rsContent">
							    <img class="rsImg" src="http://placehold.it/960x460" alt="">
							  </div>
							</div>
-->
							<div id="push-spaces">
							<?php dynamic_sidebar( 'push_spaces' ); ?>
							<div class="widget">
								<h4>Nyheter</h4>
							</div>
							</div>
						</div>
						<div id="main" class="eightcol first clearfix" role="main">

							<?php grid_archive(true); ?>

						</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
