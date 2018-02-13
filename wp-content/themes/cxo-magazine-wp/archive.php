<?php
global $paged;

if (!isset($paged) || !$paged){
  $paged = 1;
}
$templates = array( 'pages/archive.twig' );
$context = Timber::get_context();

$context['title'] = 'Archive';
if ( is_day() ) {
  $context['title'] = 'Archive: '.get_the_date( 'D M Y' );
} else if ( is_month() ) {
  $context['title'] = 'Archive: '.get_the_date( 'M Y' );
} else if ( is_year() ) {
  $context['title'] = 'Archive: '.get_the_date( 'Y' );
} else if ( is_tag() ) {
  $context['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
  $context['title'] = single_cat_title( '', false );
  array_unshift( $templates, 'pages/archive-' . get_query_var( 'cat' ) . '.twig' );
} else if ( is_post_type_archive() ) {
  $context['title'] = post_type_archive_title( '', false );
  array_unshift( $templates, 'pages/archive-' . get_post_type() . '.twig' );
}

$args = array(
  'post_type' => get_post_type(),
  'posts_per_page' => 5,
  'paged' => $paged
);
$context['paginated_posts'] = new Timber\PostQuery($args);

Timber::render( $templates, $context );
