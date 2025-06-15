<?php
add_action( 'customize_register', function ( $wp_customize ) {

	$section = 'askgrace_cta';

	$wp_customize->add_section( $section, [
		'title'    => __( 'Final CTA Box', 'askgrace' ),
		'priority' => 50,
	] );

	$wp_customize->add_setting( 'cta_heading', [
		'default'           => __( 'Ready to scale your support & sales to new heights?', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'cta_heading', [
		'label'   => __( 'Headline', 'askgrace' ),
		'section' => $section,
	] );

	$wp_customize->add_setting( 'cta_lead', [
		'default'           => __( 'Seamlessly hand off every chat to Grace and watch conversions soar 24/7.', 'askgrace' ),
		'sanitize_callback' => 'wp_kses_post',
	] );
	$wp_customize->add_control( 'cta_lead', [
		'label'   => __( 'Sub-headline', 'askgrace' ),
		'type'    => 'textarea',
		'section' => $section,
	] );

	$wp_customize->add_setting( 'cta_btn_label', [
		'default'           => __( 'Get Started', 'askgrace' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'cta_btn_label', [
		'label'   => __( 'Button text', 'askgrace' ),
		'section' => $section,
	] );

	$wp_customize->add_setting( 'cta_btn_url', [
		'default'           => '#cta-form',
		'sanitize_callback' => 'esc_url_raw',
	] );
	$wp_customize->add_control( 'cta_btn_url', [
		'label'   => __( 'Button link', 'askgrace' ),
		'section' => $section,
	] );
} );
