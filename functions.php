<?php
locate_template('project_blog_post-type.php', true);

add_action('wp_head','add_google_fonts');
function add_google_fonts(){
	echo "<link href='http://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>\n";
}

add_action('wp_head','ie_sux');
function ie_sux(){
	echo '<!--[if lt IE 9]><style>
		header a, header a:visited, header a:link, header a:hover{
		color:#000;
		}
		header a:hover{
		text-decoration:underline;
		}
		header nav a, header nav a:visited, header nav a:link, header nav a:hover{
		color:#000 !important;
		}
		header nav a:hover{
		text-decoration:underline;
		}
		</style>
		<![endif]-->';
}

add_action('wp_head','add_favicons');
function add_favicons(){
	$stylesheet_directory = get_stylesheet_directory_uri();
	
	echo "<link rel='shortcut icon' href='{$stylesheet_directory}/favicon.ico'> \n";
	
	echo "<link rel='apple-touch-icon' href='{$stylesheet_directory}/apple-touch-icon-precomposed.png' />\n";
	echo "<link rel='apple-touch-icon' sizes='72x72' href='{$stylesheet_directory}/apple-touch-icon-72x72-precomposed.png' />\n";
	echo "<link rel='apple-touch-icon' sizes='114x114' href='{$stylesheet_directory}/apple-touch-icon-114x114-precomposed.png' />\n";
	//echo "<link rel='apple-touch-icon' sizes='144x144' href='{$stylesheet_directory}/apple-touch-icon-precomposed.png' />\n";
}

add_filter('the_content', 'display_editor_notes');
function display_editor_notes($content){
	$note = get_post_meta(get_the_ID(),'editor_note',true);
	if($note === '') return $content;
	
	$note = wptexturize($note);//make typograpy pretty
	$note = wpautop($note);//add <p> and <br> where necessary
	
	return "<div class='editor-note'>{$note}</div>{$content}";
}

function hc_single_id(){
	global $wp_query;
	$post_id = $wp_query->post->ID;
	return $post_id;
}

add_action('wp_head','open_graph_stuff');
function open_graph_stuff(){
	$stylesheet_directory = get_stylesheet_directory_uri();
	echo "<meta property='og:image' content='{$stylesheet_directory}/i/actor-notes-image.jpg' />\n";
	echo "<meta property='og:image' content='{$stylesheet_directory}/i/actor-notes-image2.jpg' />\n";
}

add_action('wp_head','hc_meta_info');
function hc_meta_info(){
	$stylesheet_directory = get_stylesheet_directory_uri();
	echo "<meta name='Collaborative acting thoughts. Read journal entries from other actors and contribute your own. Let&apos;s all have an epiphany together!' />\n";
	echo "<link rel='image_src' href='{$stylesheet_directory}i/actor-notes-image.jpg'.'' />\n";
	echo "<link rel='image_src' href='{$stylesheet_directory}i/actor-notes-image2.jpg'.'' />\n";
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


/*
Plugin Name: Draft Notification
Plugin URI: http://www.dagondesign.com/articles/draft-notification-plugin-for-wordpress/
Description: Sends an email to the site admin when a draft is saved.
Author: Dagon Design
Version: 1.21
Author URI: http://www.dagondesign.com

modified as suggested at http://wordpress.org/support/topic/pending-review-email-alert?replies=9#post-834558
*/

function dddn_process($id) {

	global $wpdb;

	$tp = $wpdb->prefix;

	$result = $wpdb->get_row("
		SELECT post_status, post_title, user_login, user_nicename, display_name
		FROM {$tp}posts, {$tp}users
		WHERE {$tp}posts.post_author = {$tp}users.ID
		AND {$tp}posts.ID = '$id'
	");

	if ($result->post_status == "pending") {

		$message = "";
		$message .= "A draft was updated on '" . get_bloginfo('name') . "'\n\n";
		$message .= "Title: " . $result->post_title . "\n\n";

			// *** Choose one of the following options to show the author's name

		$message .= "Author: " . $result->display_name . "\n\n";
		// $message .= "Author: " . $result->user_nicename . "\n\n";
		// $message .= "Author: " . $result->user_login . "\n\n";

		$message .= "Link: " . get_permalink($id);

		$subject = "Draft submitted for publishing on '" . get_bloginfo('name') . "'";

		$recipient = get_bloginfo('admin_email');

		mail($recipient, $subject, $message);

	}

}

add_action('save_post', 'dddn_process');


/*
Add get shortlink to all publicly queriable types
*/
if( !function_exists( 'my_theme_cpt_shortlinks' ) ) {
	/**
	 * Allow shortlinks to be retrieved for pages and custom post types
	 */
	function my_theme_cpt_shortlinks( $shortlink, $id, $context, $allow_slugs=true ) {
		/**
		 * If query is the context, we probably shouldn't do anything
		 */
		if( 'query' == $context )
			return $shortlink;

		$post = get_post( $id );
		$post_id = $post->ID;

		/**
		 * If this is a standard post, return the shortlink that was already built
		 */
		if( 'post' == $post->post_type )
			return $shortlink;

		/**
		 * Retrieve the array of publicly_queryable, non-built-in post types
		 */
		$post_types = get_post_types( array( '_builtin' => false, 'publicly_queryable' => true ) );
		if( in_array( $post->post_type, $post_types ) || 'page' == $post->post_type )
			$shortlink = home_url('?p=' . $post->ID);

		return $shortlink;
	}
}
add_filter( 'get_shortlink', 'my_theme_cpt_shortlinks', 10, 4 );
