<?php
/*
Plugin Name: Testimonials Plugin
Description: Adds a Testimonials custom post type to the website.
Version: 1.0
Author: Your Name
*/

// Register the Testimonials custom post type
function testimonials_register_post_type() {
    $labels = array(
        'name'               => _x( 'Testimonials', 'post type general name', 'textdomain' ),
        'singular_name'      => _x( 'Testimonial', 'post type singular name', 'textdomain' ),
        'menu_name'          => _x( 'Testimonials', 'admin menu', 'textdomain' ),
        'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'textdomain' ),
        'add_new'            => _x( 'Add New', 'testimonial', 'textdomain' ),
        'add_new_item'       => __( 'Add New Testimonial', 'textdomain' ),
        'new_item'           => __( 'New Testimonial', 'textdomain' ),
        'edit_item'          => __( 'Edit Testimonial', 'textdomain' ),
        'view_item'          => __( 'View Testimonial', 'textdomain' ),
        'all_items'          => __( 'All Testimonials', 'textdomain' ),
        'search_items'       => __( 'Search Testimonials', 'textdomain' ),
        'parent_item_colon'  => __( 'Parent Testimonials:', 'textdomain' ),
        'not_found'          => __( 'No testimonials found.', 'textdomain' ),
        'not_found_in_trash' => __( 'No testimonials found in Trash.', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'testimonials' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
    );

    register_post_type( 'testimonial', $args );
}
add_action( 'init', 'testimonials_register_post_type' );

// Add custom fields for Testimonials
function testimonials_add_custom_fields() {
    add_meta_box(
        'testimonials_fields',
        'Testimonial Details',
        'testimonials_render_fields',
        'testimonial',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'testimonials_add_custom_fields' );

function testimonials_render_fields( $post ) {
    $name = get_post_meta( $post->ID, '_testimonial_name', true );
    $position = get_post_meta( $post->ID, '_testimonial_position', true );
    $company = get_post_meta( $post->ID, '_testimonial_company', true );
    $testimonial_content = get_post_meta( $post->ID, '_testimonial_content', true );
    $user_image = get_the_post_thumbnail_url( $post->ID, 'thumbnail' ); // Change 'thumbnail' to the desired image size

    // Output the fields
    ?>
    <p>
        <label for="testimonial_name">Name:</label>
        <input type="text" id="testimonial_name" name="testimonial_name" value="<?php echo esc_attr( $name ); ?>" />
    </p>
    <p>
        <label for="testimonial_position">Position:</label>
        <input type="text" id="testimonial_position" name="testimonial_position" value="<?php echo esc_attr( $position ); ?>" />
    </p>
    <p>
        <label for="testimonial_company">Company:</label>
        <input type="text" id="testimonial_company" name="testimonial_company" value="<?php echo esc_attr( $company ); ?>" />
    </p>
    <p>
        <label for="testimonial_content">Testimonial Content:</label>
        <textarea id="testimonial_content" name="testimonial_content"><?php echo esc_textarea( $testimonial_content ); ?></textarea>
    </p>
    
    <?php
}


// Save custom fields data
function testimonials_save_custom_fields( $post_id ) {
    if ( isset( $_POST['testimonial_name'] ) ) {
        update_post_meta( $post_id, '_testimonial_name', sanitize_text_field( $_POST['testimonial_name'] ) );
    }

    if ( isset( $_POST['testimonial_position'] ) ) {
        update_post_meta( $post_id, '_testimonial_position', sanitize_text_field( $_POST['testimonial_position'] ) );
    }

    if ( isset( $_POST['testimonial_company'] ) ) {
        update_post_meta( $post_id, '_testimonial_company', sanitize_text_field( $_POST['testimonial_company'] ) );
    }

    if ( isset( $_POST['testimonial_content'] ) ) {
        update_post_meta( $post_id, '_testimonial_content', wp_kses_post( $_POST['testimonial_content'] ) );
    }
}
add_action( 'save_post', 'testimonials_save_custom_fields' );


// Enqueue Slick slider from a different CDN
function enqueue_slick_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_style('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array(), '1.8.1');
    wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
}
add_action('wp_enqueue_scripts', 'enqueue_slick_scripts');




// Shortcode to display testimonials
function testimonials_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'count' => -1,
            'order' => 'date', // 'date' or 'rand'
        ),
        $atts,
        'testimonials'
    );

    $args = array(
        'post_type'      => 'testimonial',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby'        => ( $atts['order'] === 'rand' ) ? 'rand' : 'date',
    );

    $testimonials_query = new WP_Query( $args );

    ob_start();

    if ( $testimonials_query->have_posts() ) :
        ?>
        <div class="testimonial-slider">
            <?php
            while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();
                ?>
                <div class="testimonial-item">
                    <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
<img src="<?php echo $url ?>" />
                    <p class="custom_test_class"><strong><?php echo esc_html( get_post_meta( get_the_ID(), '_testimonial_name', true ) ); ?></strong></p>
                    <p class="custom_test_class"><?php echo esc_html( get_post_meta( get_the_ID(), '_testimonial_position', true ) ); ?>, <?php echo esc_html( get_post_meta( get_the_ID(), '_testimonial_company', true ) ); ?></p>
                    <p class="custom_test_class"><?php echo wp_kses_post( get_post_meta( get_the_ID(), '_testimonial_content', true ) ); ?></p>
                </div>
                <?php
            endwhile;
            ?>
        </div>
        <script>
    jQuery(document).ready(function($) {
        $('.testimonial-slider').slick({
            centerMode: true,
            centerPadding: '120px', // Adjust this value as needed
            slidesToShow: 3,
            arrows: false, // Hide arrows
            autoplay: true, // Enable autoplay
            autoplaySpeed: 2000, // Set autoplay speed in milliseconds (e.g., 3000 = 3 seconds)
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });
    });
</script>

        <?php
    else :
        echo '<p>No testimonials found</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode( 'testimonials', 'testimonials_shortcode' );

