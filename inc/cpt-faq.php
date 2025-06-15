<?php
add_action( 'init', function () {

	register_post_type( 'ag_faq', [
		'labels' => [
			'name'          => __( 'FAQs', 'askgrace' ),
			'singular_name' => __( 'FAQ', 'askgrace' ),
		],
		'public'          => false,
		'show_ui'         => true,
		'menu_icon'       => 'dashicons-editor-help',
		'supports'        => [ 'title', 'editor', 'page-attributes' ],
	] );

} );
