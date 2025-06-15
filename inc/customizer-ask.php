<?php
add_action( 'customize_register', function ( $wp_customize ) {

	$section = 'askgrace_demo';

	$wp_customize->add_section( $section, [
		'title'    => __( 'Ask-Grace Demo Box', 'askgrace' ),
		'priority' => 40,
	] );

	// Heading
	$wp_customize->add_setting( 'ask_heading', [
		'default'           => __( 'How can I help?', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'ask_heading', [
		'label'   => __( 'Heading', 'askgrace' ),
		'section' => $section,
	] );

	// Sub-heading
	$wp_customize->add_setting( 'ask_lead', [
		'default'           => __( 'Scale onboarding, support, and revenue 24/7 …', 'askgrace' ),
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp_customize->add_control( 'ask_lead', [
		'label'   => __( 'Description', 'askgrace' ),
		'type'    => 'textarea',
		'section' => $section,
	] );

	// Placeholder text
	$wp_customize->add_setting( 'ask_placeholder', [
		'default'           => __( 'Hi, I’m Grace. Ask me anything…', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'ask_placeholder', [
		'label'   => __( 'Input placeholder', 'askgrace' ),
		'section' => $section,
	] );

	// CTA button label / link
	$wp_customize->add_setting( 'ask_btn_label', [
		'default'           => __( 'Get Started', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'ask_btn_label', [
		'label'   => __( 'Button text', 'askgrace' ),
		'section' => $section,
	] );

	$wp_customize->add_setting( 'ask_btn_url', [
		'default'           => '#cta',
		'sanitize_callback' => 'esc_url_raw',
	] );
	$wp_customize->add_control( 'ask_btn_url', [
		'label'   => __( 'Button link', 'askgrace' ),
		'section' => $section,
	] );
} );
