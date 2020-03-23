<?php
/**
 * 
 * Si todo esto te resulta extraño, por favor no toques nada y contacta con un programador
 * 
 */

require_once(__DIR__ . '/vendor/autoload.php');

use METRIC\app\setup\StarterSite;

// Activación de librerías de terceros
define('DEACTIVATE_GUTEMBERG', true);
define('DEV_MODE', true); // carga los ficheros js y css por separado para depuración

// Carga de archivos javascript
$scripts_frontend = []; 
$scripts_admin = []; // carga script para el panel de administración (si son necesarios);
$css_admin = [];
$css_frontend = [];

if (DEV_MODE) {
	$scripts_frontend = [ 'SiteUtils.js', 'scripts.js', 'other_scripts.js' ];
	$css_frontend = ['styles.css'];
} else {
	$scripts_frontend = [
		'../build/js/site.js',
	];
	$css_frontend = ['../build/css/site.css'];
}


$mime_types = [['svg','image/svg+xml']];

new StarterSite($scripts_admin, $scripts_frontend, $css_admin, $css_frontend, $mime_types);