<?php
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'ag_hero_section' );

// hero section
function ag_hero_section() {
	// pull title & subtitle from Page content
	echo '<section class="hero glow container">';
		the_content();   // title + subtitle written in block editor
		ag_hero_video();
	echo '</section>';
}

//logo section
add_action( 'genesis_after_header', 'ag_logo_strip', 15 );

function ag_logo_strip() {

	$logos = get_posts( [
		'post_type'      => 'partner_logo',
		'numberposts'    => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	] );

	if ( ! $logos ) { return; }

	echo '<section class="brands"><div class="container">';
	echo '<p class="brands__intro">You’re in good hands:</p>';
	echo '<div class="logo-marquee" aria-label="Trusted by"><div class="marquee__track">';

	/* duplicate the sequence 3× for smooth loop */
	for ( $i = 0; $i < 3; $i++ ) {
		foreach ( $logos as $logo ) {
			$img = get_the_post_thumbnail( $logo->ID, 'medium', [
				'alt' => $logo->post_title,
				'class' => $i === 0 ? '' : 'lazy-duplicate', // first pass keeps real alt text
			] );
			$url = get_post_meta( $logo->ID, 'ag_logo_url', true );
			echo $url
				? '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . $img . '</a>'
				: $img;
		}
	}

	echo '</div></div></div></section>';
}

add_action( 'genesis_after_header', 'ag_testimonials_grid', 20 );
function ag_testimonials_grid() {

    $q = new WP_Query([
        'post_type'      => 'testimonial',
        'posts_per_page' => 6,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    if ( ! $q->have_posts() ) return;

    echo '<section class="testimonials container">';
    echo '  <h2>Hear it directly from our clients</h2>';
    echo '  <p class="section-lead">See what impact Grace has on real teams.</p>';
    echo '  <div class="cards">';

    while ( $q->have_posts() ) { $q->the_post();
        $yt   = get_post_meta( get_the_ID(), 'ag_yt_id', true );
        $role = get_post_meta( get_the_ID(), 'ag_role', true );
		$logo_id     = get_post_meta( get_the_ID(), 'ag_logo_id', true );            // NEW
		$brand_logo  = $logo_id ? wp_get_attachment_image( $logo_id, 'full', false, [ 'class' => 'brand-logo' ] ) : '';


        echo '<article class="card card--testimonial">';

            /* video poster + play button */
            echo '<figure class="testimonial__media video-wrapper" data-youtube-id="' . esc_attr( $yt ) . '" aria-label="Testimonial video from ' . esc_attr( get_the_title() ) . '">';
            if ( has_post_thumbnail() ) {
                echo '  <div class="video-poster"><img src="' . esc_url( get_the_post_thumbnail_url( null, 'full' ) ) . '" alt="Testimonial from ' . esc_attr( get_the_title() ) . '"><button class="video-poster__play" aria-label="Play testimonial video"></button></div>';
            }
            echo '  <div class="video-iframe" aria-hidden="true"></div>';
            echo '</figure>';

            /* body */
            echo '<div class="card__body">';
			if ( $brand_logo ) {                                           // NEW
				echo '<h3 class="card__brand">' . $brand_logo . '</h3>';   // NEW
			}
                echo '<p>' . wp_kses_post( get_the_content() ) . '</p>';
                echo '<footer class="card__meta"><strong>' . esc_html( get_the_title() ) . '</strong>' . ( $role ? ' – ' . esc_html( $role ) : '' ) . '</footer>';
            echo '</div>';

        echo '</article>';
    }

    echo '  </div>';  /* .cards */
    echo '</section>';

    wp_reset_postdata();
}


genesis();
