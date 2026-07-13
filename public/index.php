<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Hostinger Shared Hosting Deployment
|--------------------------------------------------------------------------
|
| On Hostinger shared hosting, ALL Laravel files live inside public_html.
| The 'public/' folder contents are in root of public_html.
| The Laravel app files are in 'laravel-app/' subfolder.
|
*/

// Hostinger: Laravel app is in 'laravel-app/' subdirectory within public_html
$laravelBase = __DIR__ . '/laravel-app';

// Fallback: Standard structure (Docker / local dev)
if (!is_dir($laravelBase)) {
    $laravelBase = __DIR__ . '/..';
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $laravelBase . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $laravelBase . '/vendor/autoload.php';

// Bootstrap Laravel and handle the incoming request.
/** @var Application $app */
$app = require_once $laravelBase . '/bootstrap/app.php';

// Override public path for Hostinger
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
