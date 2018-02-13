<?php

define('CXO_THEME_URI', get_template_directory_uri());
define('CXO_THEME_PATH', dirname(__FILE__) . '/');
define('CXO_URL', get_site_url());

include CXO_THEME_PATH . 'vendor/autoload.php';

use CXO\Managers\AdminManager;
use CXO\Managers\ThemeManager;
use CXO\Managers\PostsManager;
use CXO\Managers\RewriteManager;
use CXO\Managers\AjaxManager;

// Pretty error reporting
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
error_reporting(E_ERROR);

// .env variables
if (!defined('PANTHEON_ENVIRONMENT')) {
  $dotenv = new Dotenv\Dotenv(__DIR__);
  $dotenv->load();
}

// Init timber directories
$timber = new \Timber\Timber();
Timber::$dirname = 'templates';

// Initialize site
add_action('after_setup_theme', function () {
  $managers = [new AdminManager(), new PostsManager(), new RewriteManager(), new AjaxManager()];
  $themeManager = new ThemeManager($managers);

  $themeManager->run();
});
