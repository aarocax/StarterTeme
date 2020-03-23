<?php	

namespace METRIC\app\setup;

use Timber\Site;
use Timber\Timber;
use Timber\Menu;

use METRIC\app\AjaxHandler;
use METRIC\app\utils\Logger;

class StarterSite extends Site
{
	private $scripts_admin;
	private $scripts_frontend;
	private $css_admin;
	private $css_frontend;
	private $mime_types;

	public function __construct(array $scripts_admin = [], array $scripts_frontend = [], array $css_admin = [], array $css_frontend = [], array $mime_types = [])
	{

		if ( ! class_exists( 'Timber\Timber' ) ) {
			add_action(
				'admin_notices',
				function() {
					echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
				}
			);

			add_filter(
				'template_include',
				function( $template ) {
					return get_stylesheet_directory() . '/templates/no-timber.html';
				}
			);
			return;
		}

		$timber = new Timber();

		Timber::$dirname = array( 'templates', 'views' );
		Timber::$autoescape = false;

		$this->scripts_admin = $scripts_admin;
		$this->scripts_frontend = $scripts_frontend;
		$this->css_admin = $css_admin;
		$this->css_frontend = $css_frontend;
		$this->mime_types = $mime_types;

		add_action( 'after_setup_theme', [ $this, 'theme_supports' ] );
		add_filter( 'timber/context', [ $this, 'add_to_context' ] );
		add_action( 'init', [ $this, 'register_menus' ] );
		add_action( 'init', [ $this, 'create_options_page' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'load_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_load_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_load_styles' ] );
		add_filter( 'acf/settings/save_json', [$this, 'acf_json_save_point'] );
		add_filter( 'acf/settings/load_json', [$this, 'acf_json_load_point'] );

		if (DEACTIVATE_GUTEMBERG) {
			add_filter('use_block_editor_for_post_type', '__return_false', 100);
		}

		AjaxHandler::register();

		parent::__construct();

	}


	public function theme_supports()
	{
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5',	['comment-form', 'comment-list', 'gallery', 'caption'] );
		add_theme_support( 'post-formats', ['aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio'] );
		add_theme_support( 'menus' );
	}

	public function add_to_context( $context )
	{
		$context['menu_header']  = new Menu('Menu Header');
		$context['menu_main']  = new Menu('Menu Main');
		$context['menu_footer']  = new Menu('Menu Footer');
		$context['site']  = $this;

		return $context;
	}

	public function register_menus()
	{
		register_nav_menus(	array(
	 		'menu-header' => 'Menu Header',
	 		'menu-main' => 'Menu Main',
    	'menu-footer' => 'Menu Footer',
    ));
	}

	public static function add_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['apk'] = 'application/vnd.android.package-archive';
		return $mimes;
	}

	public function load_styles( $twig )
	{
		foreach ($this->css_frontend as $key => $script) {
			wp_enqueue_style('styles_'.$key, get_template_directory_uri() . '/static/css/'.$script, array(), false, 'all');
		}
	}

	public function admin_load_styles( $twig )
	{
		foreach ($this->css_admin as $key => $script) {
			wp_enqueue_style('styles_'.$key, get_template_directory_uri() . '/static/css/'.$script, array(), false, 'all');
		}
	}

	public function load_scripts( $scripts )
	{
		wp_dequeue_script('jquery');
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', false, null, true);
		wp_enqueue_script('jquery', false, array(), false, true);

		foreach ($this->scripts_frontend as $key => $script) {

			if (DEV_MODE) {
				// Carga la librería de utilidades con el endpoint Ajax
				if ($script == "SiteUtils.js") {
					wp_register_script('site_utils', get_template_directory_uri() . '/static/js/SiteUtils.js', __FILE__);
					wp_enqueue_script('site_utils', get_template_directory_uri() . '/static/js/SiteUtils.js', array('jquery'), false, true);

					wp_localize_script('site_utils', 'PT_Ajax', array(
			    	'ajaxurl' => admin_url('admin-ajax.php'),
						'nonce' => wp_create_nonce('ajax-post-nonce')
					));
				} else {
					wp_register_script('script_'.$key, get_template_directory_uri() . '/static/js/'.$script, __FILE__);
					wp_enqueue_script('script_'.$key, get_template_directory_uri() . '/static/js/'.$script, array('jquery'), false, true);
				}
			} else {
				wp_register_script('script_'.$key, get_template_directory_uri() . '/static/js/'.$script, __FILE__);
				wp_enqueue_script('script_'.$key, get_template_directory_uri() . '/static/js/'.$script, array('jquery'), false, true);

				wp_localize_script('script_'.$key, 'PT_Ajax', array(
		    	'ajaxurl' => admin_url('admin-ajax.php'),
					'nonce' => wp_create_nonce('ajax-post-nonce')
				));
			}

			
		}

	}

	public function admin_load_scripts( $scripts )
	{
		foreach ($this->scripts_admin as $key => $script) {
			wp_register_script('script_'.$key, get_template_directory_uri() . '/static/js/admin/'.$script, __FILE__);
			wp_enqueue_script('script_'.$key, get_template_directory_uri() . '/static/js/admin/'.$script, array('jquery'), false, true);
		}
	}


	/*
 	 * WP Filter
 	 * save advanced custom fields definitions in a json files at acf-json/ directory
   */
	public static function acf_json_save_point( $path ) {
		$path = get_stylesheet_directory() . '/acf-json';
	  return $path;
	}

	/*
 	 * WP Filter
 	 * load advanced custom fields definitions from json files at acf-json/ directory
   */
	public static function acf_json_load_point( $paths ) {
		unset($paths[0]);
	  $paths[] = get_stylesheet_directory() . '/acf-json';
		return $paths;    
	}
}