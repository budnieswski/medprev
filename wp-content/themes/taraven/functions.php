<?php

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
