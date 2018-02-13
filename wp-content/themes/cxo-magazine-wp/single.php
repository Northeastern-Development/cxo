<?php
use CXO\Models\CXOTopicalPost;
$context = Timber::get_context();


if ($post->post_type === 'topical_post') {
  $post = new CXOTopicalPost();
} else if ($post->post_type === 'report') {
  $post = Timber::query_post();
  $context['page'] = $post;
} else {
  $post = Timber::query_post();
  $args = array(
    'post_type' => 'post',
    'post__not_in' => [$post->id],
    'posts_per_page' => 3
  );
  $context['latest_posts'] = Timber::query_posts($args);
}

$context['post'] = $post;

Timber::render( array( 'pages/single-' . $post->post_type . '.twig', 'pages/single.twig' ) , $context );

