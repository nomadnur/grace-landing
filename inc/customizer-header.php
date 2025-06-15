<?php
add_action( 'customize_register', function ( $c ) {
    $c->add_section( 'askgrace_header', [ 'title' => __( 'Header CTA', 'askgrace' ) ] );

    $c->add_setting( 'header_cta_label', [
        'default'           => __( 'Get Started', 'askgrace' ),
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $c->add_control( 'header_cta_label', [
        'label'   => __( 'Button text', 'askgrace' ),
        'section' => 'askgrace_header',
    ] );

    $c->add_setting( 'header_cta_url', [
        'default'           => '#cta',
        'sanitize_callback' => 'esc_url_raw',
    ] );
    $c->add_control( 'header_cta_url', [
        'label'   => __( 'Button link', 'askgrace' ),
        'section' => 'askgrace_header',
    ] );
} );
