<?php

$context = Timber::get_context();
$post = Timber::query_post();

$context['post'] = $post;

Timber::render(array('pages/page-' . $post->post_name . '.twig', 'pages/page.twig'), $context);
