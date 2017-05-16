<?php

add_action( 'customize_register', 'wptsv2_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 2.2.3
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function wptsv2_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'wptsv2_link_color',
		array(
			'default'           => wptsv2_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'wptsv2_link_color',
			array(
				'description' => __( 'Change the color of post info links, hover color of linked titles, hover color of menu items, and more.', 'wptsv2' ),
				'label'       => __( 'Link Color', 'wptsv2' ),
				'section'     => 'colors',
				'settings'    => 'wptsv2_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'wptsv2_accent_color',
		array(
			'default'           => wptsv2_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'wptsv2_accent_color',
			array(
				'description' => __( 'Change the default hovers color for button.', 'wptsv2' ),
				'label'       => __( 'Accent Color', 'wptsv2' ),
				'section'     => 'colors',
				'settings'    => 'wptsv2_accent_color',
			)
		)
	);

}
