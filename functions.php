<?php
function msftheme_enqueue_scripts() {
    wp_enqueue_style('multi-step-style', get_stylesheet_uri());
    wp_enqueue_script('multi-step-script', get_template_directory_uri() . '/script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'msftheme_enqueue_scripts');

function msftheme_add_template() {
    $post_id = -1;
    $page_title = 'Multi Step Form';
    $page_check = get_page_by_title($page_title);
    if(!isset($page_check->ID)){
        $page_id = wp_insert_post(array(
            'post_title'    => $page_title,
            'post_type'     => 'page',
            'post_status'   => 'publish',
            'post_content'  => '',
            'page_template' => 'page-multistep-form.php'
        ));
    }
}
add_action('after_setup_theme', 'msftheme_add_template');
