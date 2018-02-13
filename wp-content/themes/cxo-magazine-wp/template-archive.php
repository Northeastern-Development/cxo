<?php
 /**
  * Template Name: Archive Page
  *
  * Apply this to get the Archive for Posts
  */


$context = Timber::get_context();
$post = Timber::query_post();

$context['page'] = $post;
$context['title'] = 'Updates';

$args = array(
  'post_type' => 'post',
  'posts_per_page' => 9,
  'paged' => $paged
);
$context['posts'] = new Timber\PostQuery($args);

Timber::render( 'pages/archive.twig', $context );
