<!DOCTYPE html>
<html xmlns:fb="https://www.facebook.com/2008/fbml">


<!-- Mirrored from www.bulbintown.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 03 Dec 2017 05:13:04 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>

    <title><?php echo bloginfo('name') ?></title>
    <meta name="description"
          content="<?php echo bloginfo('name') ?> <?php echo bloginfo('slogan') ?>"/>
    <meta charset="UTF-8"/>
    <meta property="fb:app_id" content="496174410407385"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="-C72etZiQhaOtYHpwmodi-l-V5LxJwY_dJGU65tMwsE"/>
    <link rel="apple-touch-icon" href="#img/logo.png"/>

    <meta property="fb:admins" content="paul.louis.bertret,alexandre.laing,stephane.vromman"/>


    <meta property="og:image" content="#img/accueil/topImg.jpg"/>

    <link rel="apple-touch-icon" sizes="57x57" href="#img/icons/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="#img/icons/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="#img/icons/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="#img/icons/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="#img/icons/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="#img/icons/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="#img/icons/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="#img/icons/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="#img/icons/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
          href="#img/icons/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="#img/icons/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="#img/icons/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="#img/icons/favicons/favicon-16x16.png">
    <link rel="manifest" href="#img/icons/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="ms-icon-144x144.html">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <?php
    wp_head();
    ?>

</head>
<body class="preload" data-spy="scroll" data-target="#navbarstatic">

<div id="wrapper">
    <div id="popups">


    </div>
    <div id="popups-overlay">&nbsp;</div>


    <div id="pre-header-tudigo"class="white-bg">
        <div class="container center">

            <img src="<?php echo get_field("site_logo_tudigo","option")?>" alt="Tudigo"  style="height: 40px;" >
           &
            <img src="<?php echo get_field("site_logo_csudh","option")?>" alt="CSUDH">

        </div>
    </div>


    <div id="header">

        <nav id="header-leftMenu">
            <ul>
                <li><a href="decouvrir-les-projets.html">Les projets</a></li>
                <li><a href="<?php echo site_url("se-financer") ?>">Se financer</a></li>
               <!-- <li><a href="#">En savoir plus</a>
                    <ul>
                        <li><a href="investissement-participatif.html">L'investissement participatif</a></li>
                        <li><a href="l-equipe.html">L'équipe</a></li>
                        <li><a href="presse.html">Presse</a></li>
                        <li><a href="recrute.html">Recrutement</a></li>
                        <li><a target="_blank" href="https://bulbintown.zendesk.com/hc/fr">Foire aux questions</a></li>
                        <li><a target="_blank" href="energie-renouvelable.html">Financement ENR</a></li>
                        <li><a target="_blank" href="http://formation-crowdfunding.bulbintown.com/">Le guide du porteur
                                de projet</a></li>
                        <li><a target="_blank" href="partenaires.html">Nos partenaires</a></li>
                    </ul>
                </li>
                <li><a href="#">Blog</a>
                    <ul>
                        <li><a href="#category/bulb-in-town-se-la-raconte/">Bulb in Town se
                                (la) raconte</a></li>
                        <li><a href="#category/jaime-mon-quartier/">J'aime mon quartier</a>
                        </li>
                        <li><a href="#category/temoignages/">Témoignages</a></li>
                        <li><a href="#category/agenda/">Agenda</a></li>
                    </ul>
                </li>-->
            </ul>
            <div class="clearFloat">&nbsp;</div>
        </nav>


        <nav id="header-rightMenu">
            <ul>



                <li><a href="index.html"
                       style="display: inline-block; overflow: hidden; padding: 0; width: 25px;position: relative; top: 4px; right: 4px;"><img
                                style="width: 100%;" src="#img/icons/us.png" alt=""></a></li>
                <li><a class="main" href="login.html#/inscription">Inscription</a></li>
                <li><a class="main" href="login.html#/connexion">Connexion</a></li>
                <li><a href="decouvrir-les-projets.html"
                       style="padding: 0 10px 0 13px; position: relative; top: 6px;"><i
                                class="bulb-loupe stdMid"></i></a></li>
            </ul>
            <div class="clearFloat">&nbsp;</div>
        </nav>

        <div id="header-handle"><i class="fa-2x fa fa-bars"></i></div>

        <div id="logo">
            <a href="<?php echo home_url()?>"">
                <img src="<?php echo get_field("site_logo_application", "option") ?>" alt="" style="height: 40px; width: auto;"/>
            </a>
        </div>


        <nav id="header-respMenu">
            <ul>
                <li><a href="decouvrir-les-projets.html">Les projets</a></li>
                <li><a href="lancer-mon-projet.html">Se financer</a></li>
                <li><a href="investissement-participatif.html">L'investissement participatif</a></li>
                <li><a href="l-equipe.html">L'équipe</a></li>
                <li><a href="#">Blog</a></li>

                <li><a class="main" href="login.html#/inscription">Inscription</a></li>
                <li><a class="main" href="login.html#/connexion">Connexion</a></li>

            </ul>
            <div class="bigMargin"><a id="closeHeaderResp" class="btn btn-small" href="#">Fermer</a></div>
        </nav>
    </div>
    <div id="flashContainer">
        <div class="container">
        </div>
    </div>

    <div id="bodyContent">
