<?php

$context         = Timber::context();
$timber_post     = Timber::query_post();
$context['post'] = $timber_post;

$cover_image_id = $post->demo_fields_imagen_imagen;

$context['cover_image'] = new Timber\Image($cover_image_id);

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}
