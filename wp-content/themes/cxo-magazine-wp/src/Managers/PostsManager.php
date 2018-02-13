<?php
/**********************
 *
 * Registering custom post types
 *
 * ***************/

namespace CXO\Managers;

class PostsManager {
  public function run() {
    add_action('init', [$this, 'register_post_types'], 1);
    add_action('init', [$this, 'register_taxonomy'], 1);
  }

  public function register_post_types() {
    $this->modify_default_post();
    $this->register_report();
    $this->register_topical_post();
  }

  public function register_taxonomy() {
    $this->register_topics();
  }

  private function modify_default_post() {
    add_post_type_support('post', 'excerpt');
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
    unregister_taxonomy_for_object_type( 'category', 'post' );
  }

  private function register_report() {
    register_post_type('report', array(
      'labels' => array(
        'name'               => 'Reports',
        'singular_name'      => 'Report',
        'menu_name'          => 'CXO Reports',
        'name_admin_bar'     => 'Reports',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Report',
        'new_item'           => 'New Report',
        'edit_item'          => 'Edit Report',
        'view_item'          => 'View Report',
        'all_items'          => 'All Reports',
        'search_items'       => 'Search Reports',
        'not_found'          => 'No Reports found.',
        'not_found_in_trash' => 'No Reports found in Trash.'
      ),
      'public'              => true,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'has_archive'         => 'reports',
      'rewrite'             => array('slug' => 'reports', 'with_front' => false),
      'exclude_from_search' => true,
      'hierarchical'        => false,
      'menu_position'       => 4,
      'menu_icon'           => 'dashicons-book',
      'supports'            => array('title', 'editor', 'thumbnail', 'revisions'),
    ));
  }

  private function register_topical_post() {
    register_post_type('topical_post', array(
      'labels' => array(
        'name'               => 'Topical Posts',
        'singular_name'      => 'Topical Post',
        'menu_name'          => 'Topical Posts',
        'name_admin_bar'     => 'Topical Posts',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Topical Post',
        'new_item'           => 'New Topical Post',
        'edit_item'          => 'Edit Topical Post',
        'view_item'          => 'View Topical Post',
        'all_items'          => 'All Topical Posts',
        'search_items'       => 'Search Topical Posts',
        'not_found'          => 'No Topical Posts found.',
        'not_found_in_trash' => 'No Topical Posts found in Trash.'
      ),
      'public'              => true,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'has_archive'         => false,
      'rewrite'             => array('slug' => 'report', 'with_front' => false),
      'exclude_from_search' => true,
      'hierarchical'        => false,
      'menu_position'       => 4,
      'menu_icon'           => 'dashicons-media-document',
      'supports'            => array('title', 'thumbnail', 'editor', 'excerpt', 'revisions'),
    ));
  }

  private function register_topics() {
    register_taxonomy('topics', array('post', 'topical_post'), array(
      'labels' => array(
        'name'              => _x( 'Topics', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Topic', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Topics', 'textdomain' ),
        'all_items'         => __( 'All Topics', 'textdomain' ),
        'parent_item'       => __( 'Parent Topic', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Topic:', 'textdomain' ),
        'edit_item'         => __( 'Edit Topic', 'textdomain' ),
        'update_item'       => __( 'Update Topic', 'textdomain' ),
        'add_new_item'      => __( 'Add Topic', 'textdomain' ),
        'new_item_name'     => __( 'Topic Name', 'textdomain' ),
        'menu_name'         => __( 'Topics', 'textdomain' ),
      ),
      'hierarchical'      => true,
      'public'            => true,
      'show_ui'           => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => true,
      'show_tagcloud'     => true,
      'map_meta_cap'      => true,
    ));
  }
}
