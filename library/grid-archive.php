 <?php

function grid_archive($toolbar = false, $post_type = 'book', $post_count = -1 ){

	if ($post_type == 'book' AND $toolbar) {
		
		$titles = new WP_Query('post_type='.$post_type.'&posts_per_page='.$post_count.'&orderby=title');
		
		$all_writers = get_terms("writer");
		$all_genres = get_terms("genre");
		
		$count_writers = count($all_writers);
		$count_genres = count($all_genres);
		

		echo '<ul>';
		echo '<li><a href="#" data-filter="*" class="filter">Visa Alla</a></li>';
		echo '</ul>';

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

		//Sorting
		echo '<div id="sorting">';
		echo '<ul class="sort-by">Sortera:';
		echo '<li class="active"><a href="#date">Datum</a></li>';
		echo '<li><a href="#title" id="sort-book" class="title">Bokstavsordning: Titel</a></li>';
		echo '</ul>';

		echo '<ul class="sort-order">';
		echo '<li><a href="#">Stigande</a></li>';
		echo '</ul>';
		echo '</div>';
	}

	//Grid container
	echo '<div class="grid-container">';

		//Query args
		$items = new WP_Query('post_type='.$post_type.'&posts_per_page='.$post_count.'&orderby=date');
		while ( $items->have_posts() ) {
			$items->the_post();
			$count++;
			if ($post_type == 'book') {

				$writers = get_the_terms( $items->ID , 'writer' );
				$genres = get_the_terms( $items->ID , 'genre' );

				echo '<div id="block-'.$count.'" class="grid-item post ';
								if( has_term( 'yes', 'upcoming' ) ) {echo 'upcoming ';}
								echo get_the_slug();
								foreach ( $writers as $writer ) {echo ' '.$writer->slug;}
								foreach ( $genres as $genre ) {echo ' '.$genre->slug;}
								echo '">';
								if(!has_term( 'yes', 'upcoming' ) ) {echo '<a href="'.get_permalink().'">';}
								if( has_term( 'yes', 'upcoming' ) ) {
									echo '<div class="overlay">';
									if (get_field('upcoming_date')) {
										$date = DateTime::createFromFormat('Ymd', get_field('upcoming_date'));
										echo 'Kommer '.$date->format('d.m.y');
									}else{
										echo 'Kommer snart...';
									}
									echo "</div>";
								}
								lazyload_thumbnail('grid-block');
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
										$writer_links[] = '<a href="#" class="writer-tag" data-filter=".'.$writer->slug.'">'.$writer->name.'</a>';
									}
									$list = join( ", ", $writer_links );
									echo '<div class="tags writer-tags">'.$list.'</div>';
								endif;
								echo '<p>'.get_field('short_description').'</p>';
								echo '<div class="timestamp">'.get_the_time('U').'</div>';
								if ( $genres && ! is_wp_error( $genres ) ) : 
									$genre_links = array();
									foreach ( $genres as $genre ) {
										$genre_links[] = '<a href="#" class="genre-tag" data-filter=".'.$genre->slug.'">'.$genre->name.'</a>';
									}
									$list = join( " / ", $genre_links );
									echo '<div class="tags genre-tags">'.$list.'</div>';
								endif;
								echo '</div>';
								echo '</div>';

			} else if ($post_type == 'episode') {
				if (has_tag('fredagsintervju')) {
					echo '<div id="block-'.$count.'" class="grid-item">';
					the_post_thumbnail('grid-block');
					echo '<h3>'.get_the_title().'</h3>';
					the_excerpt();
					echo '</div>';
				}

			} else {
				echo '<alert>Invalid post type for archive.</alert>';
			}
			
		} $count = 0;

		wp_reset_query();
	echo '</div>';
	};
?>