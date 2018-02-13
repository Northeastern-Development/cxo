<?php
/**********************
 *
 * Filters and functions for basic site setup
 *
 * ***************/


namespace CXO\Managers;

class ThemeManager {
  private $managers = [];

  public function __construct(array $managers) {
    $this->managers = $managers;

    add_filter('timber/context', array($this, 'add_to_context'));
  }

  public function run() {
    if (count($this->managers) > 0) {
      foreach ($this->managers as $manager) {
        $manager->run();
      }
    }

    add_action('wp_loaded', [$this, 'cleanup'], 1);
    add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

    // Allow featured images.
    add_theme_support('post-thumbnails');

    $this->add_options_pages();
  }

  public function cleanup() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
  }

  public function enqueue_scripts() {

    wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . '/static/build/modernizr.js', array(), null, true);

    wp_enqueue_script(
      'cxo_script',
      CXO_THEME_URI . '/static/build/js/main.js',
      array(),
      filemtime(get_stylesheet_directory() . '/static/build/js/main.js'), // add version # for cache busting
      true
    );
    wp_localize_script( 'cxo_script', 'ajax_url', admin_url( 'admin-ajax.php' ) );

  }

  public function add_to_context($context) {
    $context['is_home'] = is_home();
    $context['css_last_modified'] = filemtime(get_stylesheet_directory() . '/static/build/css/style.css');
    $context['environment'] = isset($_ENV['PANTHEON_ENVIRONMENT']) ? $_ENV['PANTHEON_ENVIRONMENT'] : 'local';
    $context['options'] = get_fields('option');

    return $context;
  }

  public function add_options_pages() {
    if ( function_exists('acf_add_options_page') ) {
      acf_add_options_page('Global Options');
    }
  }
}
