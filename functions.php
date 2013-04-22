<?php

add_action('wp_head','add_google_fonts');
function add_google_fonts(){
	echo "<link href='http://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>";
}

wp_enqueue_script(
	'fittext',
	get_stylesheet_directory_uri() . '/js/fittext/jquery.fittext.js',
	array( 'jquery' ),
	true
);
wp_enqueue_script(
	'footer-js',
	get_stylesheet_directory_uri() . '/js/footer.js',
	array( 'fittext' ),
	true
);