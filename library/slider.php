<?php 
if( get_field('slides','option')){
      echo '<div class="slider-holder"></div>';
			echo '<div id="slider" class="royalSlider rsBok" style="display:none">';
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

					$veckans = null;
					$image_only = null;
					$featured = null;
					$template = null;

					if (get_sub_field('template') == "Veckans Bok") {
						$veckans = 1;
						$template = 'veckans';
					}
  					if (get_sub_field('template') == "Image Only") {
  						$image_only = 1;
  						$template = 'image-only';
  					}
  					if (get_sub_field('template') == "Featured Content") {
  						$featured = 1;
  						$template = 'featured';
  					}
					
					if( get_sub_field('images','option')){
  					while(has_sub_field('images','option') ):
  						if(get_sub_field('background','option')){
  							while(has_sub_field('background','option') ):
  								if (get_sub_field('image') && get_sub_field('color')) {
  									echo '<div class="rsContent '.$template.'" style="background:url('.get_sub_field('image').');background-color:'.get_sub_field('color').'">';
  								} elseif(get_sub_field('image')){
  									echo '<div class="rsContent" style="background:url('.get_sub_field('image').')">';
  								} else {
  									echo '<div class="rsContent" style="background:'.get_sub_field('color').'">';
  								}
  							endwhile;
  						}else{
  								echo '<div class="rsContent">';
  						}
  						if ($veckans == 1) {
  							echo '<div style="padding-left:200px"><img class="rsImg big" src="'.get_sub_field('big').'"></img></div>';
  						} else {
  							echo '<img class="rsImg big" src="'.get_sub_field('big').'"></img>';
  						}
  						if (get_sub_field('small')) {
  							echo '<img class="small" src="'.get_sub_field('small').'"></img>';
  						}else{
  							echo '<img class="small" src="'.get_sub_field('big').'"></img>';
  						}
  						
  					endwhile;
  					};
				if($image_only !== 1){
  					if( get_sub_field('content') && get_sub_field('content_position')){
  						echo '<div class="info" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">';
  						
  						if ($veckans == 1) {
  							echo '<div class="content">';
  						}else{
  							if(get_sub_field('content_position','option')){
  							while(has_sub_field('content_position','option') ):
  								echo '<div class="content" style="top:'.get_sub_field('xpos').'%;left:'.get_sub_field('ypos').'%">';
  							endwhile;
	  						}else{
	  							echo '<div class="content">';
	  						}
  						}
  						
  						echo '<h2>'.get_sub_field('headline').'</h2>';
              if ($veckans == 1) {
  						  echo 'Klicka här';
              }else{
                echo get_sub_field('content');
              }
  						echo '</div></div>';
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