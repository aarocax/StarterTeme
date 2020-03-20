<?php

namespace METRIC\app;

use METRIC\app\utils\Logger;
use METRIC\app\SiteController;
use Timber\Timber;

class AjaxHandler {

	public static function register()
	{

		$handler = new self();

		add_action('wp_ajax_get_posts', array($handler, 'getPosts'));
		add_action('wp_ajax_nopriv_get_posts', array($handler, 'getPosts'));
	}

	public function getPosts()
	{
		echo json_encode(SiteController::getPosts());
    die();
	}

}