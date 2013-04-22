<?php
locate_template('project_blog_post-type.php', true);

add_action('wp_head','add_google_fonts');
function add_google_fonts(){
	echo "<link href='http://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>";
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
