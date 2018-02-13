<?php
/**
 * Functionality for Topical Posts
 */
namespace CXO\Models;

use Timber\Post;
use Timber\Timber;

class CXOTopicalPost extends Post {
  public $report;
  public $report_num;
  public $report_len;
  public $report_posts;
  public $link;
  public $next_article;
  public $is_last;

  public function __construct($pid = null) {
    parent::__construct($pid);

    $this->report = $this->get_report_obj();

    if (isset($this->report)) {
      $this->set_up_data();
    }
  }

  public function set_up_data() {
   $this->report_posts = $this->report->get_field('topical_posts');
   $this->report_num = $this->get_report_num();
   $this->report_len = $this->get_report_len();
   $this->link = $this->get_link();
   $this->next_article = $this->get_next_article();
   $this->is_last =  $this->check_last_article();
 }

  public function get_link() {
    return CXO_URL .'/reports/'. $this->report->slug .'/'. $this->slug;
  }

  public function get_next_article() {
    if (isset($this->report)) {
      $array_pos = $this->get_report_array_pos();

      if ($array_pos < count($this->report_posts) - 1) {
        $next_index = $array_pos+1;
        $next_post = $this->report_posts[$next_index]['post'];
        $next_post->report_num = sprintf('%02d', $next_index+1);
        $next_post->link = CXO_URL .'/reports/'. $this->report->slug .'/'. $next_post->slug;

        return $next_post;
      } else {
        $next_post = $this->report_posts[0]['post'];
        $next_post->report_num = '01';
        $next_post->link = CXO_URL .'/reports/'. $this->report->slug .'/'. $next_post->slug;

        return $next_post;
      }
    }
  }

  public function get_report_num() {
    $array_pos = $this->get_report_array_pos();
    return sprintf('%02d', $array_pos+1);
  }

  public function get_report_len() {
    if (isset($this->report)) {
      $topical_posts = $this->report->get_field('topical_posts');
      return sprintf('%02d', count($topical_posts));
    }
  }

  public function get_report_array_pos() {
    $array_pos = null;

    foreach ($this->report_posts as $i => $report_post) {
      $post = $report_post['post'];
      if ($post->id === $this->id) {
        $array_pos = $i;
      }
    }

    return $array_pos;
  }

  private function check_last_article() {
    return $this->report_num >= $this->report_len;
  }

  public function get_report_obj() {
    $report_obj = null;
    $args = array(
      'post_type' => 'report',
      'posts_per_page' => -1,
    );
    $report_pages = \Timber::get_posts($args);

    foreach ($report_pages as $report_page) {
      $topical_posts = get_field('topical_posts', $report_page->id);
      foreach($topical_posts as $topical_post) {
        if ($topical_post['post']->ID == $this->id) {
          $report_obj = $report_page;
        }
      }
    }

    return $report_obj;
  }

}
