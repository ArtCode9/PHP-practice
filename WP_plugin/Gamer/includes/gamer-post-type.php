<?php
// Register custom post type for gamers
function register_gamer_post_type(){
      $labels = array(
         'name'               => 'Gamers',
         'singular_name'      => 'Gamer',
         'menu_name'          => 'Gamers',
         'name_admin_bar'     => 'Gamer',
         'add_new'            => 'Add New',
         'add_new_item'       => 'Add New Gamer',
         'new_item'           => 'New Gamer',
         'edit_item'          => 'Edit Gamer',
         'view_item'          => 'View Gamer',
         'all_items'          => 'All Gamers',
         'search_items'       => 'Search Gamers',
         'parent_item_colon' => 'Parent Gamers:',
         'not_found'          => 'No gamers found.',
         'not_found_in_trash' => 'No gamers found in Trash.'
      );

      
      $args = array(
         'labels'             => $labels,
         'public'            => true,
         'publicly_queryable' => true,
         'show_ui'           => true,
         'show_in_menu'      => true,
         'query_var'         => true,
         'rewrite'          => array('slug' => 'gamer'),
         'capability_type'   => 'post',
         'has_archive'     => true,
         'hierarchical'    => false,
         'menu_position'    => null,
         'supports'        => array('title'),
         'menu_icon'       => 'dashicons-games'
      );
      register_post_type('gamer', $args);
}
add_action('init', 'register_gamer_post_type');