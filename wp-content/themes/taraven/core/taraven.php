<?php

DEFINE( 'URL_THEME', get_template_directory_uri() );
DEFINE( 'URL_SITE', home_url() );

require(dirname(__FILE__)."/taraven.functions.php");

Class Taraven extends TimberSite {

  // temp variable to process theme settings
  private static $temp;

  function __construct( $theme ) {

    // All theme settings
    $this->temp = $theme;

    // Detect if is mobile or not
    $detect = wp_is_mobile();
    $this->temp['is_mobile'] = ($detect==false) ? '' : 'true';

    add_theme_support( 'menus' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support('post-thumbnails');
    add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption') );
  
    add_filter('post_gallery', array($this, 'gbGallery'), 10, 2);
    add_filter('sanitize_file_name', array($this, 'sanitizeFileName'), 10);
    add_filter( 'body_class', array($this, 'body_class_add_categories') );
    
    if(is_admin())
      add_filter('site_transient_update_plugins', array($this, 'removePluginUpdate') );

    add_post_type_support( 'page', 'excerpt' );

    // Enqueue Scripts and Styles
    // add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

    add_action('init', array( $this, 'add_menu' ) );
    add_action('init', array( $this, 'add_acf' ) );

    if( isset($this->temp['blog']) && !empty($this->temp['blog']) )
      require(dirname(__FILE__)."/taraven.blog.php");

    // After all 
    add_filter('get_twig',  array($this, 'add_to_twig') );
    add_filter('timber_context', array( $this, 'add_to_context' ) );

    parent::__construct();
  }

  // Remove special caracteres from upload files (just uri)
  function sanitizeFileName ($filename) {
    return remove_accents( $filename );
  }

  /**
   * Proper way to enqueue scripts and styles.
   */
  function enqueue_scripts() {

    $theme_uri = get_template_directory_uri() . "/assets";

    foreach ($this->theme->js AS $key => $script) {
      if( preg_match('/^(http|https|\/\/)/',$script) )
        wp_enqueue_script( md5($script), $script, array(), '1.0.0', true );
      else
        wp_enqueue_script( md5($script), $theme_uri . '/js/' . $script, array(), '1.0.0', true );        
    }

    foreach ($this->theme->css AS $key => $script) {
      if( preg_match('/^(http|https|\/\/)/',$script) )
        wp_enqueue_style( md5($script), $script );
      else
        wp_enqueue_style( md5($script), $theme_uri . '/css/' . $script );      
    }
  }


  // Add Category Name to body_class
  function body_class_add_categories( $classes ) {
   
    if ( is_page() ){
      global $post;
      $classes[] = 'page-' . $post->post_name;

      return $classes;
    }
    // Only proceed if we're on a single post page
    if ( is_single() )
      return $classes;
   
    // Get the categories that are assigned to this post
    $post_categories = get_the_category();
   
    // Loop over each category in the $categories array
    foreach( $post_categories as $current_category ) {
   
      // Add the current category's slug to the $body_classes array
      $classes[] = 'category-' . $current_category->slug;
   
    }
   
    // Finally, return the $body_classes array
    return $classes;
  }


  // Remove plugin update mensagem
  function removePluginUpdate($value) {
    // if( isset($value->response[ 'advanced-custom-fields-pro/acf.php' ]) )
      unset($value->response[ 'advanced-custom-fields-pro/acf.php' ]);
    return $value;
  }

  function sanitizeOutput($buffer) {
    // if localhost/127.0.0.1 (::1), change to localhost
    $ip = $_SERVER['REMOTE_ADDR'];
    $ip = (strlen(str_replace(':', '', $ip)) < 5) ? 'localhost' : gethostbyname(gethostname()); // IPV4 from server (192.168...)

    return str_replace('http://localhost/', "http://{$ip}/", $buffer);
  }

  function preview_version($enable = false) {
    if( $enable ) {
      ob_start(array($this, 'sanitizeOutput'));
    }
    
  }

  // Register menus
  function add_menu($item='') {
    $menu = array();
    if( $item == '' ) {
      foreach ($this->temp['menu'] AS $value) {
        $menu[ strtolower(str_replace(' ', '_', $value) )] = __($value);
      }
    } else {
      $menu[ strtolower(str_replace(' ', '_', $item) )] = __($item);
    }

    register_nav_menus( $menu );
  }

  // Add options (Advanced Custom Fields) menu
  function add_acf($item='') {
    if(function_exists('acf_add_options_page')) { 
      acf_add_options_page();

      if( $item == '' ) {
        foreach ($this->temp['acf'] AS $value) {
          acf_add_options_sub_page( __($value) );
        }
      } else {
        acf_add_options_sub_page( __($item) );
      }

    }
  }

  // Setup site variable (TWIG)
  function add_to_context( $context ) {
    $this->theme->css = $this->temp['css'];
    $this->theme->js  = $this->temp['js'];
    $this->is_mobile  = $this->temp['is_mobile'];

    // Set up OPTIONS page (Advanced Custom Fields)
    if( function_exists('get_fields') ){
      $this->acf = get_fields('options');
    }

    $this->menu = array();

    if( $this->temp['menu'] )
    {
      foreach ($this->temp['menu'] AS $value) {
        $menu_name = strtolower(str_replace(' ', '_', $value) );
        $this->menu[ $menu_name ] = new TimberMenu( $menu_name );
      }
    }

    unset($this->temp);

    $context['site'] = $this;
    return $context;
  }

  function add_to_twig($twig) {
    $twig->addExtension(new Twig_Extension_StringLoader());

    $twig->addFunction( new Twig_SimpleFunction( 'get_categories', function ( $context ) {
      $args = func_get_args();
      array_shift( $args );
      $categories = get_categories(current($args));

      $return = array();
      foreach ($categories AS $category) {
        $category->id     = $category->term_id;
        $category->title  = $category->name;
        $category->link   = get_category_link($category->term_id);
        $return[]         = $category;
      }

      return $return;
    }, array( 'needs_context' => true ) ) );

    $twig->addFunction( new Twig_SimpleFunction( 'get_posts', function ( $context ) {
      $args = func_get_args();
      array_shift( $args );

      // For pagination, need update WP_Queyr
      if( is_category() ) {
        global $wp_query;
        // $wp_query->set(current($args));
        // $wp_query->set('posts_per_page', 1);
        // $wp_query->query($wp_query->query_vars);
        $wp_query = new WP_Query( array_merge($wp_query->query, current($args)) );
        $posts = get_posts($wp_query->query);

      } else {
        $posts = get_posts( current($args) );
      }
      
      $return = array();
      foreach ($posts AS $post) {
        $return[] = new TimberPost($post->ID);
      }
      wp_reset_postdata();

      return $return;
    }, array( 'needs_context' => true ) ) );

    $twig->addFunction( new Twig_SimpleFunction( 'get_post', function ( $context ) {
      $args = func_get_args();
      array_shift( $args );

      $post_id = current($args);
      
      return new TimberPost($post_id);
    }, array( 'needs_context' => true ) ) );

    $twig->addFunction( new Twig_SimpleFunction( 'get_sidebar', function ( $context ) {
      $args = func_get_args();
      array_shift( $args );
      $file = current($args);
      return Timber::compile($file.'.twig', $context);
    }, array( 'needs_context' => true ) ) );
    
    return $twig;
  }

  /*
  *  Gallery WordPress (altera o padrao)
  */
  function gbGallery($output, $attr) {
    global $post;

    if( isset($attr['orderby']) ) {
      $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
      if( !$attr['orderby'] ) { unset($attr['orderby']); }
    }

    extract(shortcode_atts(array(
      'order'       => 'ASC',
      'orderby'     => 'menu_order ID',
      'id'          => $post->ID,
      'itemtag'     => 'dl',
      'icontag'     => 'dt',
      'captiontag'  => 'dd',
      'columns'     => 3,
      'size'        => 'thumbnail',
      'link'        => 'full',
      'include'     => '',
      'exclude'     => ''
    ), $attr));

    $id = intval($id);
    if( 'RAND' == $order ) { $orderby = 'none'; }

    if( !empty($include) ) {
      $include = preg_replace('/[^0-9,]+/', '', $include);
      $_attachments = get_posts(array(
        'include'           => $include,
        'post_status'       => 'inherit',
        'post_type'         => 'attachment',
        'post_mime_type'    => 'image',
        'order'             => $order,
        'orderby'           => $orderby
      ));

      $attachments = array();
      foreach( $_attachments AS $key => $val ) { $attachments[$val->ID] = $_attachments[$key]; }
    }

    if( empty($attachments) ) { return ''; }

    $output = "<div class=\"gb-gallery\">\n";
    $output .= "<div class=\"preloader\"></div>\n";
    $output .= "<ul>\n";

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
      $full = wp_get_attachment_image_src($id, 'full');
      $img = wp_get_attachment_image_src($id, 'thumbnail');
      
      $output .= "<li>\n";
      if( $attr['link']!='none' ) {
        $output .= "<a class=\"fancybox\" rel=\"gallery\" href=\"{$full[0]}\">\n";
          $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />\n";
          if (!empty($attachment->post_excerpt)) {
            $output .= "<figcaption class=\"wp-caption-text\">{$attachment->post_excerpt}</figcaption>\n";
          }
        $output .= "</a>\n";
      } else {
        $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />\n";
        if (!empty($attachment->post_excerpt)) {
          $output .= "<figcaption class=\"wp-caption-text\">{$attachment->post_excerpt}</figcaption>\n";
        }
      }
      $output .= "</li>\n";
    }

    $output .= "</ul>\n";
    $output .= "</div>\n";

    return $output;
  }

}
