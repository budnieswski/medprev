<?php

/**
 * Regras para o filtro de Exames e Especialidades
 */
// function create_custom_rewrite_rules() {
//   //This function accepts (from the left to the right), regex, url for redirection and  priority
//     add_rewrite_rule('especialidades/([^/]+)/?', 'index.php?page_id=50&unidade_filter=$matches[1]', 'top');
//     add_rewrite_rule('exames/([^/]+)/?', 'index.php?page_id=51&unidade_filter=$matches[1]', 'top');

//     //Afterwords we need to call WordPress function flush which will re-save all rules
//     flush_rewrite_rules();
// }
// add_action('admin_init', 'create_custom_rewrite_rules');
// flush_rewrite_rules();

// function handle_custom_query_vars($query_vars) {
//     $query_vars[] = 'unidade_filter';
//     return $query_vars;
// }
// add_filter('query_vars', 'handle_custom_query_vars');


// add_filter( 'rewrite_rules_array','my_insert_rewrite_rules' );
// add_filter( 'query_vars','my_insert_query_vars' );
// add_action( 'wp_loaded','my_flush_rules' );

// flush_rules() if our rules are not yet included
function my_flush_rules(){
  $rules = get_option( 'rewrite_rules' );

  if ( ! isset( $rules['exames/([^/]+)/?'] ) ) {
    global $wp_rewrite;
      $wp_rewrite->flush_rules();
  }
}
//https://codex.wordpress.org/Class_Reference/WP_Rewrite

// Adding a new rule
function my_insert_rewrite_rules( $rules )
{
  $newrules = array();
  $newrules['exames/([^/]+)/?'] = 'index.php?page_id=51&unidade_filter=$matches[1]';
  return $newrules + $rules;
}

// Adding the id var so that WP recognizes it
function my_insert_query_vars( $vars )
{
    array_push($vars, 'id');
    return $vars;
}



if ( ! class_exists( 'Timber' ) ) {
  add_action( 'admin_notices', function() {
    echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
  } );
  return;
}

require(dirname(__FILE__).'/core/taraven.php');
Class MyTheme extends Taraven {
  
  function __construct() {

    // parent::preview_version(true);

    $settings = array(
      'css' => array('main.css'),
      'js' => array(
          'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
          'lib/jquery.fancybox.min.js',
          'lib/jquery.meio.mask.min.js',
          'lib/responsiveslides.min.js',
          // 'lib/jquery.validate.min.js',
          // 'lib/jssor.js',
          // 'lib/jssor.slider.js',
          // 'lib/stick.min.js',
          'lib/jquery.menumaker.js',
          'lib/velocity.min.js',
          // 'http://cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js?ver=1.0.0',
          'main.js',
          // For use Advanced Custom Fields Maps
          // 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false',
          // 'lib/google.maps.js',
      ),
      'menu' => array('Header'),
      'acf' => array('Default', 'Home'),
      'blog' => false,
    );
    
    // Taraven construct
    parent::__construct($settings);
  }

}

new MyTheme();

require(dirname(__FILE__).'/model/functions-custom.php');
