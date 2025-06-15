<?php
/**  AskGrace Child Theme  **/

require get_stylesheet_directory() . '/inc/customizer-roi.php';
require get_stylesheet_directory() . '/inc/cpt-steps.php';
require get_stylesheet_directory() . '/inc/customizer-ask.php';
require get_stylesheet_directory() . '/inc/cpt-faq.php';
require get_stylesheet_directory() . '/inc/customizer-faq.php';
require get_stylesheet_directory() . '/inc/customizer-cta.php';

add_theme_support( 'menus' );

/* 1 ▸ Theme setup */
add_action( 'genesis_setup', function () {
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'script', 'style',
    ] );
    add_theme_support( 'genesis-responsive-viewport' );
}, 15 );

/* 2 ▸ Assets */
add_action( 'wp_enqueue_scripts', function () {
    $ver = wp_get_theme()->get( 'Version' );

    wp_enqueue_style( 'askgrace-child',
        get_stylesheet_directory_uri() . '/style.css',
        [], $ver
    );

    /* video.js in <head> so DOMContentLoaded fires */
    wp_enqueue_script( 'askgrace-video',
        get_stylesheet_directory_uri() . '/assets/js/video.js',
        [], $ver, false
    );

    if ( is_front_page() ) {
        wp_enqueue_style( 'askgrace-inter',
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap'
        );
    }
} );

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'askgrace-header',
        get_stylesheet_directory_uri() . '/assets/js/header.js',
        [],
        null,
        true
    );
} );



add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_script(
		'ag-faq',
		get_stylesheet_directory_uri() . '/assets/js/faq.js',
		[],
		null,
		true
	);
} );



/** -----------------------------------------------------------------
 *  Theme set-up  (runs after parent + child are loaded)
 *  ---------------------------------------------------------------- */
add_action( 'after_setup_theme', 'askgrace_theme_setup', 15 );
function askgrace_theme_setup() {

	/* 1 ▸ core supports */
	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list',
		'gallery', 'caption', 'script', 'style',
	] );
	add_theme_support( 'genesis-responsive-viewport' );

    // Logo uploader appears in Site Identity
	add_theme_support( 'custom-logo', [
		'height'      => 60,
		'width'       => 180,
		'flex-width'  => true,
		'flex-height' => true,
	] );

	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'askgrace' ),
		'footer_pages' => __( 'Footer – Pages',       'askgrace' ),
		'footer_info'  => __( 'Footer – Information', 'askgrace' ),
	] );
}

/* ------------------------------------------------------------------
 * Clear Genesis‐supplied inner bits
 * -----------------------------------------------------------------*/
add_action( 'genesis_setup', function () {
    // kill the title-area + site description
    remove_action( 'genesis_header', 'genesis_do_header' );
    // we’ll relocate the nav into header, so remove it from after_header
    remove_action( 'genesis_after_header', 'genesis_do_nav' );
    remove_action( 'genesis_after_header', 'genesis_do_subnav' );
}, 15 );      // run *after* the framework attaches its callbacks

add_action( 'genesis_header', 'askgrace_custom_header_inner' );
function askgrace_custom_header_inner() {

    $cta_label = get_theme_mod( 'header_cta_label', __( 'Get Started', 'askgrace' ) );
    $cta_url   = get_theme_mod( 'header_cta_url', '#cta' );
    ?>
    <div class="container header-inner">
        <!-- Logo -->
        <div class="site-branding">
            <?php
            if ( has_custom_logo() ) {
                echo get_custom_logo();            // prints <a><img></a>
            } else {
                echo '<a class="site-title" href="' . esc_url( home_url( '/' ) ) . '">' .
                     esc_html( get_bloginfo( 'name' ) ) . '</a>';
            }
            ?>
        </div>

        <!-- Burger -->
        <button class="nav-toggle" aria-label="<?php esc_attr_e( 'Open main menu', 'askgrace' ); ?>">
            <span class="nav-toggle__bar"></span>
        </button>

        <!-- Nav + CTA -->
        <nav class="site-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'askgrace' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_class'     => 'header-menu',
                'depth'          => 1,
            ] );
            if ( $cta_label && $cta_url ) :
            ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn--primary header-cta">
                    <?php echo esc_html( $cta_label ); ?>
                </a>
            <?php endif; ?>
        </nav>
    </div>
    <?php
}


/** -----------------------------------------------------------------
 *  Custom footer markup
 *  ---------------------------------------------------------------- */
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'askgrace_custom_footer' );
function askgrace_custom_footer() {

	$logo_markup = get_custom_logo();                // <a><img></a> or ''
	$home        = home_url( '/' );
	$name        = get_bloginfo( 'name' );
	$tagline     = get_bloginfo( 'description' );
	?>
	<div class="container footer-grid"><!-- Genesis provides <footer …> -->
		<div class="footer-col brand">
			<?php
			echo $logo_markup
			     ?: '<a href="' . esc_url( $home ) . '" class="brand-link"><h3 class="footer-site-title">'
				 . esc_html( $name ) . '</h3></a>';
			?>
			<p class="footer-tagline"><?php echo esc_html( $tagline ); ?></p>
		</div>

		<nav class="footer-col">
			<h4><?php _e( 'Pages', 'askgrace' ); ?></h4>
			<?php wp_nav_menu( [
				'theme_location' => 'footer_pages',
				'menu_class'     => 'footer-menu',
				'depth'          => 1,
			] ); ?>
		</nav>

		<nav class="footer-col">
			<h4><?php _e( 'Information', 'askgrace' ); ?></h4>
			<?php wp_nav_menu( [
				'theme_location' => 'footer_info',
				'menu_class'     => 'footer-menu',
				'depth'          => 1,
			] ); ?>
		</nav>
	</div>
	<?php
}




/* 3 ▸ Meta field (single registration) */
add_action( 'init', function () {
    register_post_meta( 'page', 'ag_hero_youtube', [
        'single' => true, 'type' => 'string',
        'show_in_rest' => true, 'auth_callback' => '__return_true',
    ] );
} );

/* 4 ▸ Simple metabox UI */
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'ag_hero_meta', 'Hero YouTube Video ID', function ( $post ) {
        $v = get_post_meta( $post->ID, 'ag_hero_youtube', true );
        echo '<p><label for="ag_hero_youtube">Paste YouTube ID:</label><br>
              <input id="ag_hero_youtube" name="ag_hero_youtube" value="' .
              esc_attr( $v ) . '" style="width:100%"></p>';
    }, 'page', 'side' );
} );
add_action( 'save_post_page', function ( $id ) {
    if ( isset( $_POST['ag_hero_youtube'] ) ) {
        update_post_meta( $id, 'ag_hero_youtube',
            sanitize_text_field( $_POST['ag_hero_youtube'] ) );
    }
} );

/* 5 ▸ Hero video renderer */
function ag_hero_video() {
    $yt = get_post_meta( get_the_ID(), 'ag_hero_youtube', true );
    if ( ! $yt ) { return; }
    $poster = has_post_thumbnail()
        ? get_the_post_thumbnail_url( get_the_ID(), 'large' )
        : get_stylesheet_directory_uri() . '/assets/img/VSL.png';
    ?>
    <figure class="hero__media video-wrapper"
            data-youtube-id="<?php echo esc_attr( $yt ); ?>">
        <div class="video-poster">
            <img src="<?php echo esc_url( $poster ); ?>" alt="Video cover" loading="lazy">
            <button class="video-poster__play" aria-label="Play video"></button>
        </div>
        <div class="video-iframe" aria-hidden="true"></div>
    </figure>
    <?php
}

/*  ── CPT ▸ Partner Logos ────────────────────────────── */
add_action( 'init', function () {

	register_post_type( 'partner_logo', [
		'labels'       => [
			'name'          => 'Partner Logos',
			'singular_name' => 'Partner Logo',
			'add_new_item'  => 'Add New Logo',
		],
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-images-alt2',
		'supports'     => [ 'title', 'thumbnail' ],
		'show_in_rest' => true,
	] );

	// Optional: custom field for outbound link
	register_post_meta(
		'partner_logo',
		'ag_logo_url',
		[ 'single' => true, 'type' => 'string', 'show_in_rest' => true ]
	);
} );

/*  ── Metabox for Logo URL ───────────────────────────── */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'ag_logo_url_box', 'Logo link URL',
		function ( $post ) {
			$val = get_post_meta( $post->ID, 'ag_logo_url', true );
			echo '<input type="url" style="width:100%" name="ag_logo_url" value="' . esc_attr( $val ) . '">';
		},
		'partner_logo', 'normal', 'default'
	);
} );

add_action( 'save_post_partner_logo', function ( $pid ) {
	if ( isset( $_POST['ag_logo_url'] ) ) {
		update_post_meta( $pid, 'ag_logo_url', esc_url_raw( $_POST['ag_logo_url'] ) );
	}
} );

/* ── CPT ▸ Testimonials ─────────────────────────────── */
add_action( 'init', function () {

    register_post_type( 'testimonial', [
        'labels' => [
            'name'          => 'Testimonials',
            'singular_name' => 'Testimonial',
            'add_new_item'  => 'Add New Testimonial',
        ],
        'public'             => false,   // no archive, not in search
        'publicly_queryable' => true,    // …but WP_Query is allowed
        'show_ui'            => true,
        'show_in_rest'       => true,
        'supports'           => [ 'title', 'editor', 'thumbnail' ],
        'menu_icon'          => 'dashicons-format-video',
    ] );

    // meta: YouTube ID  +  role / company
    register_post_meta( 'testimonial', 'ag_yt_id', [
        'single' => true, 'type' => 'string', 'show_in_rest' => true
    ] );
    register_post_meta( 'testimonial', 'ag_role', [
        'single' => true, 'type' => 'string', 'show_in_rest' => true
    ] );
} );

/* ── Testimonial meta box ───────────────────────────── */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'ag_testi_meta', 'Testimonial Details',
		'ag_testi_meta_box',
		'testimonial', 'normal'
	);
} );

function ag_testi_meta_box( $post ) {

	$yt   = get_post_meta( $post->ID, 'ag_yt_id',   true );
	$role = get_post_meta( $post->ID, 'ag_role',    true );
	$logo = get_post_meta( $post->ID, 'ag_logo_id', true ); // attachment ID
	$logo_url = $logo ? wp_get_attachment_image_url( $logo, 'thumbnail' ) : '';

	?>
	<style>
		#ag-logo-preview img{max-height:40px}
	</style>

	<p><label>YouTube ID<br>
		<input type="text" style="width:100%" name="ag_yt_id" value="<?php echo esc_attr( $yt ); ?>">
	</label></p>

	<p><label>Role / Company<br>
		<input type="text" style="width:100%" name="ag_role" value="<?php echo esc_attr( $role ); ?>">
	</label></p>

	<p><label>Brand Logo<br></label>
		<input type="hidden" id="ag_logo_id" name="ag_logo_id" value="<?php echo esc_attr( $logo ); ?>">
		<button type="button" class="button" id="ag_logo_select">Select / Change</button>
		<button type="button" class="button" id="ag_logo_remove" style="<?php echo $logo ? '' : 'display:none'; ?>">Remove</button>
		<span id="ag-logo-preview"><?php
			if ( $logo_url ) echo '<img src="' . esc_url( $logo_url ) . '" alt="">';
		?></span>
	</p>

	<script>
	(function($){
		$('#ag_logo_select').on('click', function(e){
			e.preventDefault();
			const frame = wp.media({title:'Select Brand Logo', button:{text:'Use this logo'}, multiple:false});
			frame.on('select', function(){
				const attachment = frame.state().get('selection').first().toJSON();
				$('#ag_logo_id').val(attachment.id);
				$('#ag-logo-preview').html('<img src="'+attachment.url+'" alt="">');
				$('#ag_logo_remove').show();
			});
			frame.open();
		});
		$('#ag_logo_remove').on('click', function(){
			$('#ag_logo_id').val('');
			$('#ag-logo-preview').empty();
			$(this).hide();
		});
	})(jQuery);
	</script>
	<?php
}

add_action( 'save_post_testimonial', function ( $pid ) {
	if ( isset( $_POST['ag_yt_id']   ) ) update_post_meta( $pid, 'ag_yt_id',   sanitize_text_field( $_POST['ag_yt_id'] ) );
	if ( isset( $_POST['ag_role']    ) ) update_post_meta( $pid, 'ag_role',    sanitize_text_field( $_POST['ag_role'] ) );
	if ( isset( $_POST['ag_logo_id'] ) ) update_post_meta( $pid, 'ag_logo_id', absint( $_POST['ag_logo_id'] ) );
} );



// inc/customizer-roi.php
// Fire after Testimonials (assumes testimonials are printed in the loop)
add_action( 'genesis_after_loop', 'askgrace_extra_sections', 20 );
function askgrace_extra_sections() {
if ( ! is_front_page() ) return;
	/********  ROI BANNER  ********/
	$heading = get_theme_mod( 'roi_heading', __( 'At AskGrace, we focus on speed to ROI.', 'askgrace' ) );
	$copy    = get_theme_mod( 'roi_copy', __( 'Our AI chat agents learn your product, speak your brand voice, and turn every conversation into a growth opportunity.', 'askgrace' ) );
	$btn_txt = get_theme_mod( 'roi_button_label', __( 'Book a 15-min call', 'askgrace' ) );
	$btn_url = get_theme_mod( 'roi_button_url', '#book' );

	if ( $heading && $copy ) : ?>
		<section class="roi container">
			<h2><?php echo esc_html( $heading ); ?></h2>
			<p class="section-lead"><?php echo wp_kses_post( $copy ); ?></p>
			<?php if ( $btn_txt && $btn_url ) : ?>
				<a class="btn btn--primary" href="<?php echo esc_url( $btn_url ); ?>">
					<?php echo esc_html( $btn_txt ); ?>
				</a>
			<?php endif; ?>
		</section>
	<?php endif;

	/********  3-STEP SECTION  ********/
	$steps = get_posts( [
		'post_type'      => 'ag_step',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	] );

	if ( $steps ) : ?>
		<section class="steps container">
			<h2><?php _e( 'Launch Grace in 3 simple steps', 'askgrace' ); ?></h2>
			<p class="section-lead">
				<?php _e( 'Connect your data, train the AI, and go live in minutes—', 'askgrace' ); ?>
				<em><?php _e( 'not months', 'askgrace' ); ?></em>
			</p>

			<ol class="steps__grid">
				<?php foreach ( $steps as $step ) :
					setup_postdata( $step ); ?>
					<li class="step">
						<?php if ( has_post_thumbnail( $step ) ) :
							echo get_the_post_thumbnail( $step, 'thumbnail', [
								'class' => 'step__icon',
								'alt'   => '',
							] );
						endif; ?>
						<h3><?php echo esc_html( get_the_title( $step ) ); ?></h3>
						<p><?php echo wp_kses_post( $step->post_content ); ?></p>
					</li>
				<?php endforeach; wp_reset_postdata(); ?>
			</ol>
		</section>
	<?php endif;
}
// End of inc/customizer-roi.php


add_action( 'genesis_after_loop', 'askgrace_demo_box', 25 );
function askgrace_demo_box() {
if ( ! is_front_page() ) return;
	$heading     = get_theme_mod( 'ask_heading', __( 'How can I help?', 'askgrace' ) );
	$lead        = get_theme_mod( 'ask_lead', __( 'Scale onboarding, support, and revenue 24/7 …', 'askgrace' ) );
	$placeholder = get_theme_mod( 'ask_placeholder', __( 'Hi, I’m Grace. Ask me anything…', 'askgrace' ) );
	$btn_label   = get_theme_mod( 'ask_btn_label', __( 'Get Started', 'askgrace' ) );
	$btn_url     = get_theme_mod( 'ask_btn_url', '#cta' );

	$theme_uri = get_stylesheet_directory_uri();
	?>
	<section class="ask container">
		<h2><?php echo esc_html( $heading ); ?></h2>
		<p class="section-lead"><?php echo wp_kses_post( $lead ); ?></p>

		<form class="ask__form" role="search">
			<!-- ① Input row -->
			<div class="ask__input-row">
				<input type="search"
				       placeholder="<?php echo esc_attr( $placeholder ); ?>"
				       aria-label="<?php echo esc_attr__( 'Ask Grace anything', 'askgrace' ); ?>">
			</div>

			<!-- ② Toggle row -->
			<div class="ask__tags">
				<label>
					<input type="radio" name="mode" value="sales" checked>
					<img src="<?php echo esc_url( $theme_uri . '/assets/sales-icon.svg' ); ?>" alt="" class="sales-icon">
					<span><?php _e( 'Sales', 'askgrace' ); ?></span>
				</label>
				<label>
					<input type="radio" name="mode" value="support">
					<img src="<?php echo esc_url( $theme_uri . '/assets/support-icon.svg' ); ?>" alt="" class="support-icon">
					<span><?php _e( 'Support', 'askgrace' ); ?></span>
				</label>
				<label>
					<input type="radio" name="mode" value="both">
					<span><?php _e( 'Both', 'askgrace' ); ?></span>
				</label>
				<button class="tag-button" type="submit" aria-label="<?php esc_attr_e( 'Send', 'askgrace' ); ?>">
					<img src="<?php echo esc_url( $theme_uri . '/assets/submit-icon.svg' ); ?>" alt="" class="submit-icon">
				</button>
			</div>
		</form>

		<?php if ( $btn_label && $btn_url ) : ?>
			<a class="btn btn--primary" href="<?php echo esc_url( $btn_url ); ?>">
				<?php echo esc_html( $btn_label ); ?>
			</a>
		<?php endif; ?>
	</section>
	<?php
}
// End of inc/customizer-ask.php

// FAQ customizer
add_action( 'genesis_after_loop', 'askgrace_faq_section', 30 );
function askgrace_faq_section() {
if ( ! is_front_page() ) return;
	$heading = get_theme_mod( 'faq_heading', __( 'More questions?', 'askgrace' ) );
	$lead    = get_theme_mod( 'faq_lead', '' );

	$faqs = get_posts( [
		'post_type'      => 'ag_faq',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	] );

	if ( ! $faqs ) {
		return; // nothing to show yet
	}
	?>
	<section class="faq container">
		<?php if ( $heading ) : ?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $lead ) : ?>
			<p class="section-lead"><?php echo wp_kses_post( $lead ); ?></p>
		<?php endif; ?>

		<ul class="faq__list">
			<?php foreach ( $faqs as $faq ) :
				setup_postdata( $faq ); ?>
				<li class="faq__item">
					<button class="faq__question" aria-expanded="false">
						<span><?php echo esc_html( get_the_title( $faq ) ); ?></span>
						<span class="faq__icon" aria-hidden="true">+</span>
					</button>
					<div class="faq__answer" hidden>
						<?php echo wpautop( wp_kses_post( $faq->post_content ) ); ?>
					</div>
				</li>
			<?php endforeach; wp_reset_postdata(); ?>
		</ul>
	</section>
	<?php
}
// End of inc/customizer-faq.php


// Final CTA
add_action( 'genesis_after_loop', 'askgrace_final_cta', 40 );
function askgrace_final_cta() {
if ( ! is_front_page() ) return;
	$heading = get_theme_mod(
		'cta_heading',
		__( 'Ready to scale your support & sales to new heights?', 'askgrace' )
	);
	$lead    = get_theme_mod(
		'cta_lead',
		__( 'Seamlessly hand off every chat to Grace and watch conversions soar 24/7.', 'askgrace' )
	);
	$btn_txt = get_theme_mod( 'cta_btn_label', __( 'Get Started', 'askgrace' ) );
	$btn_url = get_theme_mod( 'cta_btn_url', '#get-started' );

	?>
	<!-- ===================================
	     CTA BANNER  (matches static HTML)
	=================================== -->
	<section id="cta" class="cta glow-panel container">
		<div>
			<h2><?php echo esc_html( $heading ); ?></h2>
			<p><?php echo wp_kses_post( $lead ); ?></p>
			<?php if ( $btn_txt && $btn_url ) : ?>
				<a class="btn btn--primary" href="<?php echo esc_url( $btn_url ); ?>">
					<?php echo esc_html( $btn_txt ); ?>
				</a>
			<?php endif; ?>
		</div>
	</section>
	<?php
}