<?php
/**
 * Created by PhpStorm.
 * User: georgescress
 * Date: 30/06/2017
 * Time: 22:37
 */

function styleloop()
{

    $styles=[
         'dropify'=>'/libs/dropify/css/dropify.css',
         'materialize'=>'/libs/materialize/css/materialize.css',
        //'desktop'=>'/css/desktop.css',
        'time'=>'/css/timelines.css',
        'font-awesome'=>'/libs/font-awesome/css/font-awesome.css',
        'carousel'=>'/libs/owl-carousel/assets/owl.carousel.css',
        'default'=>'/libs/owl-carousel/assets/owl.theme.default.css',
        'theme'=>'/libs/owl-carousel/assets/owl.theme.min.css',
        'transitions'=>'/libs/owl-carousel/assets/owl.transitions.min.css',


        'style'=>'/style.css',

    ];

    foreach ($styles as $key=>$style){
        wp_register_style($key , get_template_directory_uri() .$style , array(), '1.0', 'all');
        wp_enqueue_style($key); // Enqueue it!

    }


}


add_action('wp_enqueue_scripts', 'styleloop'); // Add Theme Stylesheet


function scriptloop()
{

    $scripts=[
       'jquery-2.2.1'=>'/js/jquery-3.2.1.js',
        //'lib'=>'/js/lib-desktop.js',
        //'app'=>'/js/app-desktop.js',
        'materialize'=>'/libs/materialize/js/materialize.js',
        'dropify'=>'/libs/dropify/js/dropify.js',
        'owl-carousel'=>'/libs/owl-carousel/owl.carousel.min.js',
        'script'=>'/js/scripts.js',




    ];
    if (is_singular('project')){
        $scripts['facebook-api']="/js/facebook.js";
    }

    foreach ($scripts as $key=>$style){
        wp_register_script($key , get_template_directory_uri() .$style , array(), ' ', 'true');
        wp_enqueue_script($key); // Enqueue it!

    }


    wp_localize_script( 'script', 'voteurscript', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));
}

add_action('wp_enqueue_scripts', 'scriptloop'); // Add Theme Stylesheet

