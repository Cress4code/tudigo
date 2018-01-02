<?php
/**
 * Created by PhpStorm.
 * User: georgescress
 * Date: 30/06/2017
 * Time: 22:37
 */

function admin_styleloop()
{

    $styles=[
        'datatable'=>'css/jquery.dataTables.min.css',
        'buttons'=>'css/buttons.dataTables.min.css',
        'style'=>'css/style.css',


    ];

    foreach ($styles as $key=>$style){
        wp_register_style($key , get_template_directory_uri()."/core/admin/" .$style , array(), '1.0', 'all');
        wp_enqueue_style($key); // Enqueue it!

    }


}


add_action('admin_enqueue_scripts', 'admin_styleloop'); // Add Theme Stylesheet


function admin_scriptloop()
{

    $scripts=[


        'datatable'=>'/js/jquery.dataTables.min.js',
        'buttons'=>'/js/dataTables.buttons.min.js',
        'flash'=>'/js/buttons.flash.min.js',
        'jszip'=>'/js/jszip.min.js',
        'pdfmake'=>'/js/pdfmake.min.js',
        'vfs_fonts'=>'/js/vfs_fonts.js',
        'html5'=>'/js/buttons.html5.min.js',
        'print'=>'/js/buttons.print.min.js',
        'script'=>'/js/scripts.js',




    ];

    foreach ($scripts as $key=>$style){
        wp_register_script($key , get_template_directory_uri()."/core/admin/" .$style , array(), ' ', 'true');
        wp_enqueue_script($key); // Enqueue it!

    }



}

add_action('admin_enqueue_scripts', 'admin_scriptloop'); // Add Theme Stylesheet

