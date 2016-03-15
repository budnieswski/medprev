<?php

// Set up page data
if ( is_singular() ) :
  $data = Timber::get_context();
  $data['post'] = new TimberPost();
else :
  $data = Timber::get_context();
  $data['posts'] = Timber::get_posts();
endif;

/*
* Chose Wordpress template (single, category, page ...)
*/
if ( is_single() ) :
  $data['page']                   = 'single';
  $template                       = taraven_get_single_template();

elseif ( is_page() ) :
  $data['page']                   = 'page';
  $template                       = taraven_get_page_template();

elseif ( is_home() ) :
  $data['page']                   = 'home';
  $template                       = 'index';

elseif ( is_category() ) :
  $data['archive_title']          = get_cat_name( get_query_var('cat') );
  $data['archive_description']    = term_description();
  $data['page']                   = 'archive';
  $template                       = taraven_get_archive_template();

elseif ( is_search() ) :
  $data['page']                   = 'post';
  $template                       = 'search';

elseif ( is_404() ) :
  $data['page']                   = 'post';
  $template                       = '404';

elseif ( is_tag() ) :
  $data['archive_title']          = get_term_name( get_query_var('tag_id') );
  $data['archive_description']    = term_description();
  $data['page']                   = 'archive';
  $template                       = 'archive';

elseif ( is_author() ) :
  $data['archive_title']          = get_the_author();
  $data['page']                   = 'archive';
  $template                       = 'archive';

endif;
// End chose

// Set up current category
$data['current_cat'] = taraven_get_current_category();

// Setting user data available at TWIG
$user = wp_get_current_user();
$user = $user->data;
if( !empty($user) ) {
  $data['user'] = (array) $user;
}

// render using Twig template index.twig
try {
  Timber::render( "views/{$template}.twig", $data );
} catch (Exception $e) {
  die( $e->getMessage() );
}

?> 
