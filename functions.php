<?php
add_action('wp_enqueue_scripts', 'mjb_enqueue_styles');
function mjb_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }
    $filetype = wp_check_filetype($filename, $mimes);
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename'],
    ];
}, 10, 4);
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
function fix_svg()
{
    echo '';
}
add_action('admin_head', 'fix_svg');

// post title shortcode
function post_title_shortcode()
{
    global $post;
    return $post->post_title;
}
add_shortcode('post_title', 'post_title_shortcode');

// Testimonial post type

if (!function_exists('custom_post_type')) {

// Register Custom Post Type
    function custom_post_type()
    {

        $labels = array(
            'name'                  => _x('Testimonials', 'Post Type General Name', 'testimonials'),
            'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'testimonials'),
            'menu_name'             => __('Testimonials', 'testimonials'),
            'name_admin_bar'        => __('Testimonial', 'testimonials'),
            'archives'              => __('Item Archives', 'testimonials'),
            'attributes'            => __('Item Attributes', 'testimonials'),
            'parent_item_colon'     => __('Parent Item:', 'testimonials'),
            'all_items'             => __('All Items', 'testimonials'),
            'add_new_item'          => __('Add New Item', 'testimonials'),
            'add_new'               => __('Add New', 'testimonials'),
            'new_item'              => __('New Item', 'testimonials'),
            'edit_item'             => __('Edit Item', 'testimonials'),
            'update_item'           => __('Update Item', 'testimonials'),
            'view_item'             => __('View Item', 'testimonials'),
            'view_items'            => __('View Items', 'testimonials'),
            'search_items'          => __('Search Item', 'testimonials'),
            'not_found'             => __('Not found', 'testimonials'),
            'not_found_in_trash'    => __('Not found in Trash', 'testimonials'),
            'featured_image'        => __('Featured Image', 'testimonials'),
            'set_featured_image'    => __('Set featured image', 'testimonials'),
            'remove_featured_image' => __('Remove featured image', 'testimonials'),
            'use_featured_image'    => __('Use as featured image', 'testimonials'),
            'insert_into_item'      => __('Insert into item', 'testimonials'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'testimonials'),
            'items_list'            => __('Items list', 'testimonials'),
            'items_list_navigation' => __('Items list navigation', 'testimonials'),
            'filter_items_list'     => __('Filter items list', 'testimonials'),
        );
        $args = array(
            'label'               => __('Testimonial', 'testimonials'),
            'description'         => __('Post type for testimonials', 'testimonials'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor'),
            'taxonomies'          => array('category', 'post_tag'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-star-half',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type('testimonial', $args);

    }
    add_action('init', 'custom_post_type', 0);

}