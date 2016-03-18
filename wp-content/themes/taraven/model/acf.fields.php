<?php

/*
* ACF
*/
  $especialidades = get_field('especialidades', 50);
  $field_especialidades = array();
  if( !empty($especialidades) ):
    foreach ($especialidades AS $especialidade) {
      $field_especialidades[base64_encode($especialidade['especialidade'])] = $especialidade['especialidade'];
    }
  endif;

  $exames = get_field('exames', 51);
  $field_exames = array();
  if( !empty($exames) ):
    foreach ($exames AS $exame) {
      $field_exames[base64_encode($exame['exame'])] = $exame['exame'];
    }
  endif;

  if( function_exists('register_field_group') ):

  register_field_group(array (
    'key' => 'group_54ede48544453',
    'title' => 'Unidade',
    'fields' => array (
      array (
        'key' => 'field_54ede5b34679f',
        'label' => 'Dados',
        'name' => '',
        'prefix' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
      ),
      array (
        'key' => 'field_54ede4e1bfe99',
        'label' => 'Telefone 1',
        'name' => 'telefone_1',
        'prefix' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_54ede4f5bfe9a',
        'label' => 'Telefone 2',
        'name' => 'telefone_2',
        'prefix' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_54ede554bfe9e',
        'label' => 'Endereço',
        'name' => 'endereco',
        'prefix' => '',
        'type' => 'textarea',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'new_lines' => 'wpautop',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_54ede561bfe9f',
        'label' => 'Horário Atendimento',
        'name' => 'horario',
        'prefix' => '',
        'type' => 'textarea',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'new_lines' => 'wpautop',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_54ef14f1c0785',
        'label' => 'Email',
        'name' => 'email',
        'prefix' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => true,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_54ede5bc467a0',
        'label' => 'Banner',
        'name' => '',
        'prefix' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
      ),
      array (
        'key' => 'field_5620ec77d9480',
        'label' => '',
        'name' => 'include_banner_home',
        'prefix' => '',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'message' => 'Marque para não incluir os banners da home',
        'default_value' => 0,
      ),
      array (
        'key' => 'field_54ede4febfe9b',
        'label' => 'Galeria',
        'name' => 'galeria',
        'prefix' => '',
        'type' => 'gallery',
        'instructions' => 'Imagens dever ter exclusivamente as dimensões de 940x300',
        'required' => 0,
        'conditional_logic' => 0,
        'min' => '',
        'max' => '',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
      array (
        'key' => 'field_54ede5e5467a1',
        'label' => 'Especialidades',
        'name' => '',
        'prefix' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
      ),
      array (
        'key' => 'field_54ede519bfe9c',
        'label' => '',
        'name' => 'especialidades',
        'prefix' => '',
        'type' => 'checkbox',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'choices' => $field_especialidades,
        'default_value' => array (
        ),
        'layout' => 'vertical',
      ),
      array (
        'key' => 'field_54ede5f1467a2',
        'label' => 'Exames',
        'name' => '',
        'prefix' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
      ),
      array (
        'key' => 'field_54ede532bfe9d',
        'label' => '',
        'name' => 'exames',
        'prefix' => '',
        'type' => 'checkbox',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'choices' => $field_exames,
        'default_value' => array (
        ),
        'layout' => 'vertical',
      ),
      array (
        'key' => 'field_54ede60f467a3',
        'label' => 'Mapa',
        'name' => '',
        'prefix' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
      ),
      array (
        'key' => 'field_54ede577bfea0',
        'label' => '',
        'name' => 'mapa',
        'prefix' => '',
        'type' => 'google_map',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'center_lat' => '',
        'center_lng' => '',
        'zoom' => '',
        'height' => '',
      ),
      array (
        'key' => 'field_54ede615467a4',
        'label' => 'Social Midia',
        'name' => '',
        'prefix' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
      ),
      array (
        'key' => 'field_54ede583bfea1',
        'label' => 'Facebook',
        'name' => 'facebook',
        'prefix' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_54ede58dbfea2',
        'label' => 'Twitter',
        'name' => 'twitter',
        'prefix' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),
      array (
        'key' => 'field_54ede592bfea3',
        'label' => 'Instagram',
        'name' => 'instagram',
        'prefix' => '',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
        'readonly' => 0,
        'disabled' => 0,
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_category',
          'operator' => '==',
          'value' => 'category:unidades',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'acf_after_title',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array (
      0 => 'permalink',
      1 => 'the_content',
      2 => 'excerpt',
      3 => 'custom_fields',
      4 => 'discussion',
      5 => 'comments',
      6 => 'revisions',
      7 => 'author',
      8 => 'format',
      9 => 'page_attributes',
      10 => 'tags',
      11 => 'send-trackbacks',
    ),
  ));

  endif;
