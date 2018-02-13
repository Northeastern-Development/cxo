<?php
/**********************
 *
 * Modifications to the WordPress admin
 * - Removing comments
 * - Removing dashboard widgets
 *
 * ***************/

namespace CXO\Managers;

class AdminManager {

  public function run() {
    add_action('wp_loaded', [$this, 'cleanup'], 1);
  }

  public function cleanup() {
    // Disable comment functionality
    add_action('admin_init', array($this, 'disable_comments_post_type_support'));
    add_filter('comments_open', array($this, 'disable_comments_status'), 20, 2);
    add_filter('pings_open', array($this, 'disable_comments_status'), 20, 2);
    add_filter('comments_array', array($this, 'disable_comments_hide_existing_comments'), 10, 2);
    add_action('admin_menu', array($this, 'disable_comments_admin_menu'));
    add_action('admin_init', array($this, 'disable_comments_admin_menu_redirect'));
    add_action('admin_init', array($this, 'disable_comments_dashboard'));
    add_action('add_admin_bar_menus', array($this, 'disable_comments_admin_bar'));
    add_action('init', array($this, 'remove_comment_support'), 100);

    // Kill dashboard widgets
    add_action('wp_dashboard_setup', array($this, 'remove_dashboard_widgets'));

    // enqueue styles to the wysiwyg
    add_editor_style('static/build/css/editor-style.css');
  }

  public function disable_comments_post_type_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
      if (post_type_supports($post_type, 'comments')) {
        remove_post_type_support($post_type, 'comments');
        remove_post_type_support($post_type, 'trackbacks');
      }
    }
  }

  // Close comments on the front-end
  public function disable_comments_status() {
    return false;
  }

  // Hide existing comments
  public function disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
  }

  // Remove comments menu options
  public function disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
    $user = wp_get_current_user();
    if (in_array('editor', (array) $user->roles)) {
      remove_menu_page('tools.php');
    }
  }

  // Redirect any user trying to access comments page
  public function disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
      wp_redirect(admin_url());
      exit;
    }
  }

  // Remove comments metabox from dashboard
  public function disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
  }

  // Remove comments links from admin bar
  public function disable_comments_admin_bar()
  {
    if (is_admin_bar_showing()) {
      remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
  }

  // Removes comment support from post and pages
  public function remove_comment_support() {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
  }

  public function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  }

}
