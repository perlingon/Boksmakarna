<?php
/*
Plugin Name: FWP+: Include source in title
Plugin URI: http://feedwordpress.radgeek.com/wiki/fwp-include-source-title
Description: alters the titles of incoming syndicated posts to include the name of the syndication source
Version: 2010.0205
Author: Charles Johnson
Author URI: http://radgeek.com/
License: GPL

*/



add_filter(
/*hook=*/ 'syndicated_item_title',
/*function=*/ 'fwp_include_source_in_title',
/*order=*/ 10,
/*arguments=*/ 2
);

/*

 fwp_include_source_in_title: Gets the title of the syndication source and

 includes it in the title of all syndicated posts.


 @param string $title The current title of the syndicated item.

 @param SyndicatedPost $post An object representing the syndicated post.

  The syndicated item data is contained in $post->item

  The syndication feed channel data is contained in $post->feed

  The subscription data is contained in $post->link

 @return string The new title to give the syndicated item.

*/



function fwp_include_source_in_title ($title, $post) {
// Use SyndicatedLink::name() to retrieve source name
$tags = $post->link->taxonomies();

$tagstring = join(" - ", $tags);
// Put the source name into the title
$title = $tags;

// Send it back
return $title;
} /* fwp_include_source_in_title() */