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

class Inku_Kaehmy_Plugin {
  public function __construct() {
    add_action('admin_menu', array($this, 'register_admin_menu'));
    register_activation_hook(__FILE__, '__init');
  }

  public function __init() {
    add_action('admin_menu', array($this, 'register_admin_menu'));
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