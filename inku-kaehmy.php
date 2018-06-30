<?php
/**
 * Plugin Name:       Inku Kaehmy
 * Description:       Plugin for handling kaehmy.
 * Version:           0.0.1
 * Author:            Best coders of code
 * License:           WTFPL
 * Text Domain:       inku-kaehmy
 * Domain Path:				/languages
 */

require_once('functions.php');

class Inku_Kaehmy_Plugin {
  public function __construct() {
    add_action('admin_menu', array($this, 'register_admin_menu'));
    add_action('rest_api_init', array($this, 'register_routes'));
  }

  // Add action to get tags from db.
  public function register_routes() {
    register_rest_route('inku-kaehmy/v1', '/tags', 
      array(
        'methods' => 'GET',
        'callback' => 'get_all_tags',
      )
    );
    
    register_rest_route('inku-kaehmy/v1', '/grabbings', 
    array(
      'methods' => 'GET',
      'callback' => 'get_all_grabbings',
      )
    );

  }

  /*
   * Add page to test function return values
   */
  public function register_admin_menu() {
    add_menu_page(
      __('Kaehmy management', 'inku-kaehmy'),
      __('Kaehmy management', 'inku-kaehmy'),
      'manage_options',
      'kaehmy-management',
      array($this, 'render_tester_page')
    );
  }

  /*
   * Test page for functions
   */
  public function render_tester_page() {
    ob_start();
    require('test.php');
    $asd = ob_get_contents();
    ob_end_clean();
    echo $asd;
  }
}

$inku_kaehmy = new Inku_Kaehmy_Plugin();

?>