<?php
add_action( 'init', function() {

	register_post_type( 'ag_step', [
		'labels'      => [
			'name'          => __( 'Launch Steps', 'askgrace' ),
			'singular_name' => __( 'Step', 'askgrace' ),
		],
		'public'      => false,
		'show_ui'     => true,
		'supports'    => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
		'menu_icon'   => 'dashicons-editor-ol',
	] );

} );
