<?php

add_action( 'genesis_entry_header', 'wpts_page_subtitle' );

function wpts_page_subtitle() {
  $page_subtitle = genesis_get_custom_field( '_wpts_page_setting_subtitle' );

  if ( empty($page_subtitle) ) return;

  printf('<p class="entry-subtitle">%s</p>', $page_subtitle );

}

add_filter( 'post_class', 'wpts_page_fancy_title_class');

function wpts_page_fancy_title_class( $classes ) {


  $page_fancy_title = genesis_get_custom_field( '_wpts_page_setting_fancy_title' );

  if ( $page_fancy_title == '1' ) {
    $classes[] = esc_attr(sanitize_html_class('fancy-title'));
  }
  else {
    $classes = $classes;
  }

  return $classes;
  
}

genesis();
