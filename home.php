<?php

add_filter( 'body_class', 'wpts_blog_fancy_title_class');

function wpts_blog_fancy_title_class( $classes ) {

  $classes[] = esc_attr(sanitize_html_class('fancy-blog'));

  return $classes;

}

//
remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
add_action( 'genesis_before_loop', 'wpts_do_posts_page_heading' );

function wpts_do_posts_page_heading() {

	if ( ! genesis_a11y( 'headings' ) ) {
		return;
	}

	$posts_page = get_option( 'page_for_posts' );

	if ( is_null( $posts_page ) ) {
		return;
	}

	if ( ! is_home() || genesis_is_root_page() ) {
		return;
	}

	$title = get_post( $posts_page )->post_title;

	$content = get_post( $posts_page )->post_content;

  $blog_id = get_option( 'page_for_posts' );

  $subtitle =  wpautop(get_post_meta( $blog_id, '_wpts_page_setting_subtitle', true ));

	$title_output = $content_output = '';

	if ( $title ) {
		$title_output = sprintf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), get_the_title( $posts_page ) );
	}

	if ( $content ) {
		$content_output = wpautop( $content );
	}

	if ( $title || $content ) {
		printf( '<div %s>', genesis_attr( 'posts-page-description' ) );
			if ( $title ) {
				printf( '<h1 %s>%s</h1>', genesis_attr( 'archive-title' ), get_the_title( $posts_page ) );
			}
      if ( $subtitle ) {
        echo '<div class="posts-page-intro">'. $subtitle .'</div>';
      }

		echo '</div>';
	}

}

/* Code to Display Featured Image on top of the post */
add_action( 'genesis_entry_header', 'wpts_featured_post_image', 8 );
function wpts_featured_post_image() {

  if ( has_post_thumbnail() ) :
    $args = array(
      'title' => esc_attr( the_title_attribute( 'echo=0' ) ),
      'alt'   => esc_attr( the_title_attribute( 'echo=0' ) ),
      'class' => 'alignleft blog-featured-image',
    ); ?>
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php the_post_thumbnail( 'blog-featured-image', $args ); ?>
    </a>
  <?php endif;
}

// custom content
add_filter( 'genesis_pre_get_option_content_archive', 'wpts_do_full_content' );
add_filter( 'genesis_pre_get_option_content_archive_limit', 'wpts_no_content_limit' );

function wpts_do_full_content() {
	return '200';
}

// Make sure the content limit isn't set
function wpts_no_content_limit() {
	return '200';
}

add_filter( 'get_the_content_more_link', 'wpts_modify_read_more_link_text' );
function wpts_modify_read_more_link_text() {
    return '... <a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

//* Remove the entry meta in the entry header (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Remove the entry footer markup (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

genesis();
