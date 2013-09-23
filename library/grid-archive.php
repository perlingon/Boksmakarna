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
	echo '<div id="grid-container">';

		//Query args
		$items = new WP_Query('post_type='.$post_type.'&posts_per_page='.$post_count.'&orderby=date');
		while ( $items->have_posts() ) {
			$items->the_post();
			$count++;
			if ($post_type == 'book') {

				$writers = get_the_terms( $items->ID , 'writer' );
				$genres = get_the_terms( $items->ID , 'genre' );

				echo '<div id="block-'.$count.'" class="grid-item '.get_the_slug();
				foreach ( $writers as $writer ) {echo ' '.$writer->slug;}
				foreach ( $genres as $genre ) {echo ' '.$genre->slug;}
				echo '">';
				echo '<a href="'.get_permalink().'">';
				the_post_thumbnail('grid-block');
				echo "</a>";
				echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
				echo '<ul class="tags">';
				foreach ( $writers as $writer ) {echo '<li><a href="#" class="writer-tag" data-filter=".'.$writer->slug.'">'.$writer->name.'</a></li>';}
				foreach ( $genres as $genre ) {echo '<li><a href="#" class="genre-tag" data-filter=".'.$genre->slug.'">'.$genre->name.'</a></li>';}
				echo '</ul>';
				echo '<p>'.get_field('short_description').'</p>';
				echo '<em class="date">'.get_the_date('Y-m-d').'</em>';
				echo '</div>';

			} else if ($post_type == 'episode') {

				echo '<div id="block-'.$count.'" class="grid-item">';
				the_post_thumbnail('grid-block');
				echo '<h3>'.get_the_title().'</h3>';
				the_excerpt();
				echo '</div>';

			} else {
				echo '<alert>Invalid post type for archive.</alert>';
			}
			
		} $count = 0;
		wp_reset_query();
	echo '</div>';
	};
?>