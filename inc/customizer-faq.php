<?php
add_action( 'customize_register', function ( $wp_customize ) {

	$section = 'askgrace_faq';

	$wp_customize->add_section( $section, [
		'title'    => __( 'FAQ Section', 'askgrace' ),
		'priority' => 45,
	] );

	$wp_customize->add_setting( 'faq_heading', [
		'default'           => __( 'More questions?', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'faq_heading', [
		'label'   => __( 'Section heading', 'askgrace' ),
		'section' => $section,
	] );

	$wp_customize->add_setting( 'faq_lead', [
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp_customize->add_control( 'faq_lead', [
		'label'   => __( 'Optional sub-heading', 'askgrace' ),
		'type'    => 'textarea',
		'section' => $section,
	] );
} );
