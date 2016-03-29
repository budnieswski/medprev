<?php
require(dirname(__FILE__).'/acf.fields.php');



function the_phones($post_id)
{
  echo preg_replace("((\()+([0-9])+(\)))", "<small>\\0</small>", get_field('telefone_1', $post_id));
  echo "<br>";
  echo preg_replace("((\()+([0-9])+(\)))", "<small>\\0</small>", get_field('telefone_2', $post_id));
}

function is_unidade () {
  $a = current(get_the_category(get_the_ID()));
  if (is_single() && $a->category_parent==2 ) {
    return true;
  }
}

function get_custom_gallery()
{
  $default = get_field('default_banner', 'options');

  if( is_unidade() )
  {
    global $post;
    $gallery = get_field('galeria', $post->ID);

    // Marque para NÂO INCLUIR os banners da home
    if( !get_field('include_banner_home', $post->ID) ){
      if(!empty($gallery))
        return array_merge($gallery, $default);
      else
        return $default;
    }

    return $gallery;
  }
  
  return $default;
}

/**
 * Get all State and City
 * @return  array [Bidimensional with State and cities inside]
 */
function getUnidades()
{
  $categeries = get_categories(array(
    'child_of'  => 2,
    'orderby'   => 'name',
    'order'     => 'ASC',
    // 'hide_empty' => 0,
  ));

  $output = array();
  foreach ($categeries AS $category)
  {
    $_posts = get_posts(array(
      'category'        => $category->term_id,
      'posts_per_page'  => -1,
      'orderby'         => 'title',
      'order'           => 'ASC'
    ));

    if( !empty($_posts) )
    {
      $firstLetter = $category->name[0];
      $output[$firstLetter] = array(
        'category' => $category,
        'posts' => $_posts
      );
    }
  }

  return $output;
}

/**
 * Create a Unidades select, according the necessity
 * @param  string $atts    showvalue (email/id/url), wpcf7 (true/false), required (true/false), emptytext (text)
 * @param  string $content [description]
 * @return HTML
 */
function sc_select_unidades ($atts='', $content="")
{
  $show_value_options = array('email', 'id', 'url');

  // Check if have showvalue, if have, check if is valid (in array)
  $show_value = empty($atts['showvalue']) ? 'id' : (in_array($atts['showvalue'], $show_value_options) ? $atts['showvalue'] : 'id');
  $wpcf7_style = empty($atts['wpcf7']) ? 'false' : $atts['wpcf7'];
  $required = empty($atts['required']) ? 'false' : $atts['required'];
  $emptytext = empty($atts['emptytext']) ? '---' : $atts['emptytext'];

  $unidades = getUnidades();

  $output = "<option value=\"\">{$emptytext}</option>";
  foreach ($unidades AS $category) {
    $output .= "<optgroup label=\"{$category['category']->name}\">";

    // $_posts = get_posts(array('category'=>$category->term_id, 'posts_per_page'=>-1, 'orderby'=>'title', 'order'=>'ASC'));
    // if (empty($_posts)) {
    //   $output .= "<option value=\"\">--</option>";
    //   $output .= "</optgroup>";
    //   continue;
    // }

    foreach ($category['posts'] AS $_post) {
      $data = "";
      if($show_value=='url')
      {
        $data = get_permalink($_post->ID);
      } else if($show_value=='email')
      {
        $data = get_field('email', $_post->ID);
      } else
      {
        $data = $_post->ID;
      }

      $output .= "<option value=\"{$data}\">{$_post->post_title}</option>";
    }

    $output .= "</optgroup>";
  }

  $attr = "";
  $class = "";

  // Only if not WPCF7
  if($required!='false' && $wpcf7_style=='false')
  {
    $attr .= "required=\"required\"";
  }

  // Is WPCF7
  if($wpcf7_style!='false')
  {
    $class = "wpcf7-form-control wpcf7-select";
    $attr .= "aria-invalid=\"false\" ";
    
    if($required!='false')
    {
      $class .= " wpcf7-validates-as-required";
      $attr .= "aria-required=\"true\" ";
      $attr .= "required=\"required\"";
    }
  }  
  
  $output = "<select name=\"your-unidade\" class=\"{$class}\" {$attr}>{$output}</select>";


  if($wpcf7_style!='false')
    $output = "<span class=\"wpcf7-form-control-wrap your-unidade\">{$output}</span>";

  return $output;
}

/*
 * Add Wordpress shortcode
 */
add_shortcode('select-unidades', 'sc_select_unidades');

/*
 * Add Contact form 7 shortcode
 */
function dynamic_unidades(){
  return do_shortcode('[select-unidades wpcf7="true" showvalue="email" required="true" emptytext="UNIDADE (OBRIGATÓRIO)"]');
}
wpcf7_add_shortcode('unidades', 'dynamic_unidades', true);




/*
* 
*/
function sc_utilidades ($atts='', $content="") {

  $context = Timber::get_context();
  return Timber::compile('shortcode.utilidades.twig', $context);

}
add_shortcode('utilidades', 'sc_utilidades');



/*
* Dinamic Contact form and Map together
*/
function sc_contato ($atts='', $content="") {

  if( empty($atts) || empty($atts['id']) ) return false;

  $contact_form = do_shortcode("[contact-form-7 id=\"{$atts['id']}\" title=\"Contato\"]");
  $map = do_shortcode("[mapa]");

  $html = "<div class=\"row\">";
  $html .= "<div class=\"one-half column\"> {$contact_form} </div>";
  $html .= "<div class=\"one-half column\"> {$map} </div>";
  $html .= "</div>";

  return $html;
}
add_shortcode('contato', 'sc_contato');

/*
* 
*/
function sc_exames ($atts='', $content="") {

  $filter = get_query_var('unidade_filter');
  $itens = get_field('exames');

  if (!empty($filter)) {
    // Pega do post com o filter substituindo $itens]
    $_post = get_page_by_path($filter,OBJECT,'post');
    if ($_post && !empty($_post)) {
      $nitens = get_field('exames', $_post->ID);
      if (!empty($nitens)) {
        $itens = array();
        foreach ($nitens AS $value) {
          // Interligado com o ACF, por isso esta encodado (caracteres especiais)
          $itens[]['exame'] = str_replace(':','',base64_decode($value));
        }
      }
    }
  }

  
  if( !empty($itens) ){
    asort($itens); // Ordena
    $data = array();
    foreach ($itens as $exame) {
      $firstLetter = $exame['exame'][0];
      $data[ $firstLetter ][] = $exame['exame'];
    }
    return Timber::compile('shortcode.exames.twig', array('exames'=>$data));
  } else {
    return false;
  }
}
add_shortcode('exames', 'sc_exames');


/*
* 
*/
function sc_especialidades ($atts='', $content="") {

  $filter = get_query_var('unidade_filter');
  $itens = get_field('especialidades');

  if (!empty($filter)) {
    // Pega do post com o filter substituindo $itens]
    $_post = get_page_by_path($filter,OBJECT,'post');
    if ($_post && !empty($_post)) {
      $nitens = get_field('especialidades', $_post->ID);
      if (!empty($nitens)) {
        $itens = array();
        foreach ($nitens AS $value) {

          // Interligado com o ACF, por isso esta encodado (caracteres especiais)
          $itens[]['especialidade'] = base64_decode($value);
        }
      }
    }
  }

  
  if( !empty($itens) ){
    asort($itens); // Ordena
    $data = array();
    foreach ($itens as $key => $item) {
      $firstLetter = $item['especialidade'][0];
      $item = explode(':', $item['especialidade']);
      $content = array(
        'nome'        => trim($item[0]),
        'descricao'   => trim($item[1]),
      );
      $data[ $firstLetter ][] = $content;
    }
    return Timber::compile('shortcode.especialidades.twig', array('especialidades'=>$data));
  } else {
    return false;
  }
}
add_shortcode('especialidades', 'sc_especialidades');



/*
* Remove WPSEO getting images from POST
*/
// add_filter('wpseo_pre_analysis_post_content', 'mysite_opengraph_content');
//   function mysite_opengraph_content($val) {
//   return '';
// }

// Ajax REQUEST
// function getViews() {
//   $post_id = $_GET['post_id'];
//   if (!empty($post_id)) {
//     wpb_set_post_views($post_id);
//   }
// }
// add_action("wp_ajax_nopriv_getViews", "getViews");
// add_action("wp_ajax_getViews", "getViews");
