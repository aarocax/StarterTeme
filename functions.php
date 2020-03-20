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
define('USE_OWL_CAROUSEL2_LIBRARY', true);
define('WAYPOINTS_LIBRARY', true);

// Carga de archivos javascript
$scripts_admin = ['scripts2.js'];

// Carga using gulp
//$scripts_frontend = ['../build/js/concat.js'];

$scripts_frontend = ['scripts.js', 'other_scripts.js'];

// Archivos que contienen llamadas ajax
$ajax_scripts = [];

// Carga de archivos css
$css_admin = [];
$css_frontend = [];

$mime_types = [['svg','image/svg+xml']];

new StarterSite($scripts_admin, $scripts_frontend, $ajax_scripts, $css_admin, $css_frontend, $mime_types);