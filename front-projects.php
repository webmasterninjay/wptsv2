<?php

// Security
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// WP_Query arguments
$args = array(
	'post_type' => array( 'wpts_projects' ),
	'post_status' => array( 'publish' ),
	'meta_query' => array( array( 'key' => '_wpts_projects_project_featured', 'value' => '1' ) )
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
	echo "<div class='project-wrapper'>";

		$count = 0;

		while ( $query->have_posts() ) : $query->the_post(); $count++;
		// do something
    ?>
      <div class="entry-project">
				<div class="project-thumbnail">
					<?php
					$args = array(
						'class'=>'project-preview',
						'title'=> the_title_attribute('echo=0'),
						'alt'=> the_title_attribute('echo=0'),
					);
					the_post_thumbnail( 'project-image', $args );
					?>
				</div>
	      <div class="project-feedback">
					<?php
					$current_project_owner      = get_post_meta( $post->ID, '_wpts_projects_project_owner', true );
				  $current_project_feedback   = get_post_meta( $post->ID, '_wpts_projects_project_feedback', true );
					echo wpautop($current_project_feedback);
					?>
					<p class="project-owner">&ndash; <?php echo $current_project_owner; ?></p>
	      </div>
			</div>
    <?php if ( $count >= 3 ) { $count = 0; } endwhile;
	echo '</div>';

} else {
	// no posts found
  printf('<p>No project to display.</p>');
}

// Restore original Post Data
wp_reset_postdata();

// WP_Query arguments
$args = array(
	'post_type' => array( 'wpts_projects' ),
	'post_status' => array( 'publish' ),
	'orderby' => 'date',
	'order'   => 'ASC',
	'meta_query' => array( array( 'key' => '_wpts_projects_project_featured', 'value' => '1' ) )
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
	echo "<div class='project-wrapper-2'>";

		$count = 0;

		while ( $query->have_posts() ) : $query->the_post(); $count++;
		// do something
    ?>
      <div class="entry-project">
	      <div class="project-feedback">
					<?php
					$current_project_owner      = get_post_meta( $post->ID, '_wpts_projects_project_owner', true );
				  $current_project_feedback   = get_post_meta( $post->ID, '_wpts_projects_project_feedback', true );
					echo wpautop($current_project_feedback);
					?>
					<p class="project-owner">&ndash; <?php echo $current_project_owner; ?></p>
	      </div>
				<div class="project-thumbnail">
					<?php
					$args = array(
						'class'=>'project-preview',
						'title'=> the_title_attribute('echo=0'),
						'alt'=> the_title_attribute('echo=0'),
					);
					the_post_thumbnail( 'project-image', $args );
					?>
				</div>
			</div>
    <?php if ( $count >= 3 ) { $count = 0; } endwhile;
	echo '</div>';

} else {
	// no posts found
  printf('<p>No project to display.</p>');
}

// Restore original Post Data
wp_reset_postdata();
