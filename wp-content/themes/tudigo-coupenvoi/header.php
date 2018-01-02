<!DOCTYPE HTML>
<html>
<head>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>

    <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

    <?php
     $image=(object)get_all_image();

    ?>
    <link href="<?php echo $image->favicon; ?>" rel="shortcut icon">
    <link href="<?php echo $image->favicon; ?>" rel="apple-touch-icon-precomposed">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Passion+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->


    <?php
    wp_head()
    ?>
    <?php
    global $activePhase;
    global $phases;
    //$today = '2018-12-23';
    $today = date('Y-m-d');


    $activePhase = 0;
    $i = 0;
    $phases = get_field("site_home_page_repeteur", "option");
    if (!empty($phases)) {
        foreach ($phases as $phase) {


            if (($today >= $phase['start_phase_date']) && ($today <= $phase['end_phase_date'])) {
                $activePhase = $i;
            }
            $i++;
        }
    }
    define(
            "ACTIVE",$activePhase
    );


    ?>


    <?php
    global $main_color;
    $main_color = get_field("site_main_color", "option");
    $second_color = get_field("site_secondary_color", "option");

    ?>
    <style>

        .sideshow-content .button .btn-secondary:hover {
            background: <?php echo $second_color; ?> !important;
        }

        .site-main .sideshow, .page-title.background-page, .page-title.background-campaign {
            background-image: url("<?php echo get_field("site_banner_image", 'option') ?>") !important;
        }

        .current_page_item a, .current_page_item a, .current-menu-item a {
            color: <?php echo $second_color; ?> !important;
        }

        .main-bg, .timeline-marker:before, .campaign-item a.overlay, .post a.overlay {
            background-color: <?php echo $main_color; ?> !important;
        }

        .second-bg {

            background-color: <?php echo $second_color; ?> !important;
        }

        #submit {
            background: <?php echo $second_color; ?> !important;
        }

        .main-color, .menu-item a {

            color: <?php echo $main_color; ?> !important;
        }

        .second-btn:hover {
            color: #fff;
            background-color: <?php echo $second_color; ?>;
        }

        .main-btn:hover {
            color: #fff;
            border-color: <?php echo $main_color; ?> !important;
            background-color: transparent !important;
        }

        .white-btn {
            border: 1px solid white;
            color: #fff;
            background-color: transparent !important;
        }

        .second-color, header .menu-open {
            color: <?php echo $second_color; ?> !important;
        }

        .bordered {
            border: 3px solid transparent;
        }

        .main-border-color, input:focus, textarea:focus {
            border-color: <?php echo $main_color; ?> !important;
        }

        .second-border-color {
            border-color: <?php echo $second_color; ?> !important;
        }

        .white-border-color {
            border-color: #FFF !important;
        }

        .white-color {
            color: #fff !important;
        }

        .white-bg {
            background: #fff !important;
        }

        .btn.btn-transparent.btn-secondary:hover {
            background: <?php echo $second_color; ?> !important;
            border: 2px solid <?php echo $second_color; ?> !important;
            color: white !important;
        }

        .playButton {
            display: none !important;
        }

        .img-calendar {
            width: 150px !important;
        }

        textarea {
            width: 100%;
        }

        path:hover, circle:hover {
            stroke: <?php echo $second_color; ?> !important;
            stroke-width: 2px;
            stroke-linejoin: round;
            fill: <?php echo $second_color; ?> !important;
            cursor: pointer;
        }


    </style>

    <!--<script src='https://www.google.com/recaptcha/api.js'></script>-->

</head>
<body class="desktop desktop">
<header>
    <ul class="logo-list">
        <li>
            <a href="<?php echo get_field("site_csudh_web_site","option") ?>" target="_blank" title="">
                <img style="margin-top: -11px;" class="logo-sg"
                     src="<?php echo get_field("site_logo_csudh", "option") ?>" alt="">
            </a>
        </li>
        <li>
            <span style="position: relative;
    top: -8px;
    margin: 10px;
    font-size: 23px;
">&</span>
        </li>
        <li>
            <a href="<?php echo get_field("site_tudigo_web_site","option") ?>" target="_blank" title="Tudigo">
                <img class="logo-sg logo-bit " src="<?php echo get_field("site_logo_tudigo", "option") ?>" alt="Tudigo"
                      >
            </a>
        </li>
    </ul>
    <div class="title">
        <span>
            <a href="<?php echo home_url() ?>" title="<?php echo bloginfo('name');?>" rel="nofollow">
                <img class="logo-cp " src="<?php echo get_field("site_logo_application", "option") ?>"
                     alt="Coup d'Envoi">
            </a>
        </span>
        <span class="bold">
            <?php
            bloginfo('description')
            ?>
        </span>
    </div>

    <?php
    if($activePhase==0){
    if (is_user_logged_in()) {
        ?>
        <a href="<?php echo wp_logout_url(home_url()) ?>"
           class="  second-border-color  second-bg btn-logout "><i class="fa fa-power-off"></i> </a>

        <?php
    } else {
        ?>
        <a href="<?php echo home_url('project-login') ?>"
           class="  second-border-color  second-bg btn-login">Sign in </a>
        <?php
    }}
    ?>


    <div class="burger">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="menu-open ">

        <?php
        html5blank_nav("header-menu");
        ?>

    </div>
</header>




