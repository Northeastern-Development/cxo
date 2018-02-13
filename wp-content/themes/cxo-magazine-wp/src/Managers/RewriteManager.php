<?php
/**********************
 *
 * URL Rewrites
 *
 * ***************/

namespace CXO\Managers;

class RewriteManager {
  public function run() {
    add_action('generate_rewrite_rules', array($this, 'topical_post_url_rewrite'));

    flush_rewrite_rules();
  }

  public function topical_post_url_rewrite($wp_rewrite) {
    $rules = array();
    $args = array(
      'post_type' => 'report',
      'posts_per_page' => -1,
    );
    $report_pages = \Timber::get_posts($args);

    foreach ($report_pages as $page) {
      foreach ($page->get_field('topical_posts') as $topical_post) {
        $post = $topical_post['post'];
        $rules['/reports/'. $page->slug .'/'. $post->slug . '/?$'] = 'index.php?topical_post=' . $post->slug;
      }
    }

    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
  }
}
