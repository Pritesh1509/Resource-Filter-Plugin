<?php
/*
Plugin Name: Resource filter
Description: This plugin is used for filter resouces type and topcis based on taxonomy
Version: 1.0
Author: Pritesh Rajpura
*/

/******* Custom post type of Resource *********/

function custom_resource_type() {
    $labels = array(
        'name' => __('Resources'),
        'singular_name' => __('Resource'),
        'add_new' => __('Add New'),
        'add_new_item' => __('Add New Resource'),
        'edit_item' => __('Edit Resource'),
        'new_item' => __('New Resource'),
        'view_item' => __('View Resource'),
        'search_items' => __('Search Resource'),
        'not_found' => __('No books found'),
        'not_found_in_trash' => __('No books found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => __('Resource')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'resources'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );

    register_post_type('resource', $args);
}
add_action('init', 'custom_resource_type');


/******* Custom taxonomty of Resource Type  *********/

function resource_type_taxonomy() {
    $labels = array(
        'name' => _x('Resource Type', 'taxonomy general name'),
        'singular_name' => _x('Resource Type', 'taxonomy singular name'),
        'search_items' => __('Search Resource Type'),
        'all_items' => __('All Resource Type'),
        'parent_item' => __('Parent Resource Type'),
        'parent_item_colon' => __('Parent Resource Type:'),
        'edit_item' => __('Edit Resource Type'),
        'update_item' => __('Update Resource Type'),
        'add_new_item' => __('Add New Resource Type'),
        'new_item_name' => __('New Resource Type'),
        'menu_name' => __('Resource Type')
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'resource_type')
    );

    register_taxonomy('resource_type', array('resource'), $args);
}
add_action('init', 'resource_type_taxonomy');


/******* Custom taxonomty of Resource Topic  *********/

function resource_topic_taxonomy() {
    $labels = array(
        'name' => _x('Resource Topic', 'taxonomy general name'),
        'singular_name' => _x('Resource Topic', 'taxonomy singular name'),
        'search_items' => __('Search Resource Topic'),
        'all_items' => __('All Resource Topic'),
        'parent_item' => __('Parent Resource Topic'),
        'parent_item_colon' => __('Parent Resource Topic:'),
        'edit_item' => __('Edit Resource Topic'),
        'update_item' => __('Update Resource Topic'),
        'add_new_item' => __('Add New Resource Topic'),
        'new_item_name' => __('New Resource Topic'),
        'menu_name' => __('Resource Topic')
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'resource_topic')
    );

    register_taxonomy('resource_topic', array('resource'), $args);
}
add_action('init', 'resource_topic_taxonomy');


/***** Include archive php file in template folder ******/

function load_custom_templates($template) {
    if (is_post_type_archive('resource')) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/archive-resource.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}
add_filter('template_include', 'load_custom_templates');

/**** eneque the ajax Function *****/

function my_custom_enqueue_scripts() {
    wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . 'js/customjs.js', array('jquery'), null, true);
    wp_localize_script('custom-js', 'ajaxs_obj', array('ajax_url' => admin_url('admin-ajax.php'),'nonce'    => wp_create_nonce('my_custom_nonce')));
}
add_action('wp_enqueue_scripts', 'my_custom_enqueue_scripts'); // For frontend


/**** Call Ajax functionality ****/

add_action('wp_ajax_resource_data', 'resource_data');
add_action('wp_ajax_nopriv_resource_data', 'resource_data');
function resource_data(){
    $resource_type = $_request['resource_type'];
    $resource_topic = $_request['resource_topic'];

    $tax = array('relation'=>'AND');
    $res_arr = array();

    if($resource_type!=""){
        $tax[] = array(
            'taxonomy'=>"resource_type",
            'field'=>'slug',
            'terms'=>$resource_type,
        );
        array_push($tax,$res_arr);
    }
    
    $args = array(
        'post_type' => 'resource',
        'posts_per_page' => -1,
        'tax_query' => $tax,
    );

    $query = new WP_Query($args);

    if($query->have_posts()){
        while($query->have_posts()){ 
         $query->the_post();
         echo get_the_title();
        }
    }
    die();
}