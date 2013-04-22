<?php

add_action('wp_head','add_google_fonts');
function add_google_fonts(){
	echo "<link href='http://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>";
}