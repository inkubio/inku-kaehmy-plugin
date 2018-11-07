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

    /* CORS headers */
    add_action( 'rest_api_init', function() {
	    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	      add_filter( 'rest_pre_serve_request', function( $value ) {
		      header( 'Access-Control-Allow-Origin: *' );
		      header( 'Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE' );
		      header( 'Access-Control-Allow-Credentials: true' );

		      return $value;		
      	});
      }, 15
    );
  }

  // Add action to get tags from db.
  public function register_routes() {
    /*GET methods*/ 
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

    register_rest_route('inku-kaehmy/v1', '/grabbing/(?P<id>\d+)', 
    array(
      'methods' => 'GET',
      'callback' => 'get_grabbing',
      'args' => array('id'),
      )
    );

    register_rest_route('inku-kaehmy/v1', '/grabbing/(?P<id>\d+)/comments', 
    array(
      'methods' => 'GET',
      'callback' => 'get_grabbing_comments',
      'args' => array('id'),
      )
    );

    register_rest_route('inku-kaehmy/v1', '/me', 
    array(
      'methods' => 'GET',
      'callback' => 'get_logged_in_user_id',
      )
    );


    /*DELETE methods */
    register_rest_route('inku-kaehmy/v1', '/comment/(?P<id>\d+)', 
    array(
      'methods' => 'DELETE',
      'callback' => 'delete_comment',
      'args' => array('id'),
      )
    );

    register_rest_route('inku-kaehmy/v1', '/grabbing/(?P<id>\d+)', 
    array(
      'methods' => 'DELETE',
      'callback' => 'delete_grabbing',
      'args' => array('id'),
      
      )
    );
    /*POST methods*/
    
    register_rest_route('inku-kaehmy/v1', '/grabbings', 
    array(
      'methods' => 'POST',
      'callback' => 'post_grabbing',
      )
    );

    register_rest_route('inku-kaehmy/v1', '/comments', 
    array(
      'methods' => 'POST',
      'callback' => 'post_comment',
      )
    );

    register_rest_route('inku-kaehmy/v1', '/me', 
    array(
      'methods' => 'POST',
      'callback' => 'get_logged_in_user_id',
      )
    );

    /*PUT methods*/
    register_rest_route('inku-kaehmy/v1', '/comment/(?P<id>\d+)', 
    array(
      'methods' => 'PUT',
      'callback' => 'put_comment',
      'args' => array('id'),
      )
    );
    register_rest_route('inku-kaehmy/v1', '/grabbing/(?P<id>\d+)', 
    array(
      'methods' => 'PUT',
      'callback' => 'put_grabbing',
      'args' => array('id'),
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
