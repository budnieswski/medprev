<?php

/**
 * Regras para o filtro de Exames e Especialidades
 */

 // function exames_plugin_rules() {
 //  add_rewrite_rule('exames/?([^/]*)', 'index.php?pagename=exames&unidade_filter=$matches[1]', 'top');
 //  // flush_rewrite_rules();
 // }

 // function exames_plugin_query_vars($vars) {
 //  $vars[] = 'unidade_filter';
 //  return $vars;
 // }


 //register activation function
 // register_activation_hook(__FILE__, 'exames_plugin_activate');
 //register deactivation function
 // register_deactivation_hook(__FILE__, 'exames_plugin_deactivate');
 //add rewrite rules in case another plugin flushes rules
 // add_action('init', 'exames_plugin_rules');
 //add plugin query vars (unidade_filter) to wordpress
 // add_filter('query_vars', 'exames_plugin_query_vars');
 //register plugin custom pages display
 // add_filter('template_redirect', 'exames_plugin_display');






function create_custom_rewrite_rules() {
  //This function accepts (from the left to the right), regex, url for redirection and  priority
    add_rewrite_rule('especialidades/([^/]+)/?', 'index.php?page_id=50&unidade_filter=$matches[1]', 'top');
    add_rewrite_rule('exames/([^/]+)/?', 'index.php?page_id=51&unidade_filter=$matches[1]', 'top');

    //Afterwords we need to call WordPress function flush which will re-save all rules
    // flush_rewrite_rules();
}
// add_action('admin_init', 'create_custom_rewrite_rules');
// flush_rewrite_rules();

function handle_custom_query_vars($query_vars) {
    $query_vars[] = 'unidade_filter';
    return $query_vars;
}
add_filter('query_vars', 'handle_custom_query_vars');



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
