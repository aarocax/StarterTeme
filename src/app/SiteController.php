<?php

namespace METRIC\app;

use Timber\Timber;

class SiteController
{

	public static function getPosts(string $postType = 'post', int $num = -1)
	{
		$args = array(
	    'post_type' => $postType,
	    'posts_per_page' => $num,
	    'post_status' => 'publish',
	    'orderby'        => 'date',
	    'order' => 'DESC'
		);

		return Timber::get_posts( $args );
	}

}