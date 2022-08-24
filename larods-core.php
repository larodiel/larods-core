<?php

/**
 * @package Larods Core
 */

/*
Plugin Name: Larods core
Plugin URI: https://larods.com.br
Description: Plugin required to the core functions work.
Version: 1.0.0
Author: Victor larodiel <me@larods.com.br>
Author URI: https://larods.com.br
License: MIT
Text Domain: larods-core
*/

if (!defined('ABSPATH')) {
    exit;
}

define('LRD_CORE_VERSION', '1.0.0');
define('LRD_CORE_PATH', plugin_dir_path(__FILE__));
define('LRD_CORE_URL', plugin_dir_url(__FILE__));

require 'vendor/autoload.php';

use LarodsCoreBlocks\LoadBlocks;
use LarodsCoreApp\AssetsLoad;

new LoadBlocks();
$assets = new AssetsLoad();
$assets->loadPublicAssets();
