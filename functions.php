<?php
locate_template('project_blog_post-type.php', true);

add_action('wp_head','add_google_fonts');
function add_google_fonts(){
	echo "<link href='http://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>" . "\n";
}

add_action('wp_head','add_favicons');
function add_favicons(){
	echo '<link rel="shortcut icon" href="'.get_stylesheet_directory_uri() . '/favicon.ico'.'">' . "\n";
	
	echo '<link rel="apple-touch-icon" href="'.get_stylesheet_directory_uri() . '/apple-touch-icon-precomposed.png'.'" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="72x72" href="'.get_stylesheet_directory_uri() . '/apple-touch-icon-72x72-precomposed.png'.'" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="114x114" href="'.get_stylesheet_directory_uri() . '/apple-touch-icon-114x114-precomposed.png'.'" />' . "\n";
	//echo '<link rel="apple-touch-icon" sizes="144x144" href="'.get_stylesheet_directory_uri() . '/apple-touch-icon-precomposed.png'.'" />' . "\n";
}

function hc_single_id(){
	global $wp_query;
	$post_id = $wp_query->post->ID;
	return $post_id;
}

add_action('wp_head','open_graph_stuff');
function open_graph_stuff(){
	echo '<meta property="og:image" content="'.get_stylesheet_directory_uri() . '/i/actor-notes-image.jpg'.'" />' . "\n";
	echo '<meta property="og:image" content="'.get_stylesheet_directory_uri() . '/i/actor-notes-image2.jpg'.'" />' . "\n";
}

add_action('wp_head','hc_meta_info');
function hc_meta_info(){
	echo '<meta name="Collaborative acting thoughts. Read journal entries from other actors and contribute your own. Let\'s all have an epiphany together!" />' . "\n";
	echo '<link rel="image_src" href="'.get_stylesheet_directory_uri() . '/i/actor-notes-image.jpg'.'" />' . "\n";
	echo '<link rel="image_src" href="'.get_stylesheet_directory_uri() . '/i/actor-notes-image2.jpg'.'" />' . "\n";
}



// Add class of 'project-blog' to body for styleing the blog page
add_filter('body_class', 'projet_blog_body_class');
function projet_blog_body_class($classes) {
        $classes[] = 'project-blog';
        return $classes;
}

/**
 * Here are some customizations that change text output via the gettext filter.
 * This was intended for translating themes to other languages, but why not
 * use it for more customization?
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 *
 */
add_filter( 'gettext', 'happycol_change_excerpt_name', 20, 3 );
function happycol_change_excerpt_name( $translated_text, $text, $domain ) {

    if( is_post_type_archive('blog') ) {

        switch ( $translated_text ) {

            case 'Archives' :

                $translated_text = 'Project Blog';
                break;


        }

    }

    return $translated_text;
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
