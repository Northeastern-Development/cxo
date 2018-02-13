<?php
/**********************
 *
 * Ajax Handler
 *
 * ***************/

namespace CXO\Managers;

use CXO\Models\MailChimp;
use CXO\Models\CXOTopicalPost;
use Timber\Timber;

class AjaxManager {

  public function run() {
    add_action( 'wp_ajax_mailchimp_subscribe', array($this, 'mailchimp_subscribe'));
    add_action( 'wp_ajax_nopriv_mailchimp_subscribe', array($this, 'mailchimp_subscribe'));

    add_action( 'wp_ajax_infinite_load_next', array($this, 'infinite_load_next'));
    add_action( 'wp_ajax_nopriv_infinite_load_next', array($this, 'infinite_load_next'));
  }

  public function mailchimp_subscribe() {
    $MailChimp = new MailChimp(getenv('MAILCHIMP_API_KEY'), getenv('MAILCHIMP_API_ENDPOINT'), getenv('MAILCHIMP_LIST_ID'));

    $result = $MailChimp->post([
      'email_address' => $_POST['email_address'],
      'merge_fields'  => ['FNAME'=>$_POST['first_name'], 'LNAME'=>$_POST['last_name']],
      'status'        => 'pending',
    ]);

    wp_die();
  }

  public function infinite_load_next() {
    $current_post_id = $_POST['current_post_id'];
    $current_post = new CXOTopicalPost($current_post_id);
    $next_article = $current_post->next_article;

    $next_post = new CXOTopicalPost($next_article->id);

    $compiled_html = Timber::compile('partials/articles/article-content.twig', ['post' => $next_post]);

    $response = [
      'next_article' => $next_article,
      'compiled_html' => $compiled_html,
    ];

    echo json_encode($response);

    wp_die();
  }
}
