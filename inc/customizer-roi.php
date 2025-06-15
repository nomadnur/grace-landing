<?php
// inc/customizer-roi.php
add_action( 'customize_register', function( $wp_customize ) {

	$section = 'askgrace_roi';

	$wp_customize->add_section( $section, [
		'title'      => __( 'ROI Banner', 'askgrace' ),
		'priority'   => 35,
	] );

	// Heading
	$wp_customize->add_setting( 'roi_heading', [
		'default'           => __( 'At AskGrace, we focus on speed to ROI.', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'roi_heading', [
		'label'   => __( 'Heading', 'askgrace' ),
		'section' => $section,
	] );

	// Sub-heading
	$wp_customize->add_setting( 'roi_copy', [
		'default'           => __( 'Our AI chat agents learn your product, speak your brand voice, and turn every conversation into a growth opportunity.', 'askgrace' ),
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp_customize->add_control( 'roi_copy', [
		'label'   => __( 'Description', 'askgrace' ),
		'type'    => 'textarea',
		'section' => $section,
	] );

	// Button label/link
	$wp_customize->add_setting( 'roi_button_label', [
		'default'           => __( 'Book a 15-min call', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'roi_button_label', [
		'label'   => __( 'Button text', 'askgrace' ),
		'section' => $section,
	] );

	$wp_customize->add_setting( 'roi_button_url', [
		'default'           => '#book',
		'sanitize_callback' => 'esc_url_raw',
	] );
	$wp_customize->add_control( 'roi_button_url', [
		'label'   => __( 'Button link', 'askgrace' ),
		'section' => $section,
	] );
} );
