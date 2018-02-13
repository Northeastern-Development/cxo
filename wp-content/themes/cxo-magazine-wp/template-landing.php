<?php
 /**
  * Template Name: Landing Page
  *
  * Apply this to get the Landing Page to appear
  */
use CXO\Models\CXOTopicalPost;

$context = Timber::get_context();
$post = Timber::query_post();

$context['page'] = $post;

$carousel_posts = [];
foreach ($post->get_field('hero_posts') as $topical_post) {
  array_push($carousel_posts, new CXOTopicalPost($topical_post['post']->id));
}
$context['carousel_posts'] = $carousel_posts;


Timber::render( 'pages/landing.twig', $context );
