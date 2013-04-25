<?php
function hc_custom_type_blog_init() {
  $labels = array(
    'name' => 'Blog',
    'singular_name' => 'Blog Post',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Blog Post',
    'edit_item' => 'Edit Blog Post',
    'new_item' => 'New Blog Post',
    'all_items' => 'All Blog Posts',
    'view_item' => 'View Blog Post',
    'search_items' => 'Search Blog Posts',
    'not_found' =>  'No blog posts found',
    'not_found_in_trash' => 'No blog posts found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Blog'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'blog' ),
    'capability_type' => 'page',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
  ); 

  register_post_type( 'blog', $args );
}
add_action( 'init', 'hc_custom_type_blog_init' );

