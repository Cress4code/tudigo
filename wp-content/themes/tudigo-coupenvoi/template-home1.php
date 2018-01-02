<?php /* Template Name: Home1A */
get_header(); ?>


<div id="page-accueil">
    <div id="page-accueil-topBaniere" class="topBaniere">
        <div class="responsive-img topBaniere-img" id="page-accueil-topBaniereImg">
            <img src="<?php echo get_field("site_banner_image", 'option') ?>" alt=""/>
        </div>

        <div id="page-accueil-topBaniereContent" class="topBaniere-content">
            <h1><?php echo get_field("site_home_title", 'option') ?></h1>

            <p class="midPadding midMargin stdMid"><?php echo get_field("site_small_description", 'option') ?></p>
            <br><br>
            <div id="page-acceuil-topBaniereBtns">
                <a class="btn btn-mid btn-secondary main-bg" href="lancer-mon-projet.html">
                    <?php
                    _e("Discover the projects")
                    ?></a>
                <a class="btn btn-mid btn-secondary btn-transparent second-border-color second-color"
                   href="<?php echo site_url('project-sign-up') ?>"> <?php
                    _e("Participate")
                    ?></a> &nbsp; &nbsp;
            </div>

            <div id="page-accueil-topBaniereLogos">

                <?php
                $parterns = get_field("site_partners", 'option');
                if (!empty($parterns)) {
                    foreach ($parterns as $partern) {
                        $partern = (object)$partern;
                        ?>
                        <a title="<?php echo $partern->partners_company_name ?>"
                           href="<?php echo $partern->partners_url ?>"><img src="<?php echo $partern->partners_logo ?>"
                                                                            alt="<?php echo $partern->partners_company_name ?>"/></a>
                        <?
                    }
                }
                ?>


            </div>
        </div>
    </div>
    <div class="mainBlock white hugePadding center main-bg" id="page-lancerProjet-3points">
        <h3 class="quickBoldUp big bigMargin">Notre démarche</h3>
        <div class="container row">
            <?php
            $reasons = get_field("site_reasons", "option");
            if (!empty($reasons)) {
                foreach ($reasons as $reason) {
                    $reason = (object)$reason;
                    ?>
                    <div class="col s12 m4 center smallMargin">
                        <div class="restrictCenter250">
                            <div class="imgContainer"><img class="reason-img" src="<?php echo $reason->reason_logo ?>"
                                                           alt="<?php echo $reason->reasons_title ?>">
                            </div>
                            <br><br>

                            <h2 class="bold stdMid uppercase smallMargin"><?php echo $reason->reasons_title ?></h2>

                            <p class="smallStd"><?php echo $reason->reason_descriptiion ?></p>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>


        </div>
    </div>


</div>

<!--
Call for app
-->
<?php


switch (applicationCurrentState()){

    case 1:
        get_template_part('phases/call-for-application');
        break;
    default:
        get_template_part('phases/call-for-application');
}
?>



<div class="  second-bg">

    <div class="container">
        <br>
        <br>
        <h3 class="quickBoldUp big bigMargin center">Notre démarche</h3>
        <div class="row center">
            <div class="col s12 m3">
                <div class="imgContainer inbl middleAlign bigPadding" style="max-width: 200px;"><img style="width: 100%;" src="/bundles/bitmain/img/logo.svg" alt=""></div>
            </div>
            <div class="col s12 m3">
                <div class="imgContainer inbl middleAlign bigPadding" style="max-width: 200px;"><img style="width: 100%;" src="/bundles/bitoccigo/img/accueil/depeche.jpg" alt=""></div>
            </div>
            <div class="col s12 m3">
                <div class="imgContainer inbl middleAlign bigPadding" style="max-width: 200px;"><img style="width: 100%;" src="/bundles/bitoccigo/img/accueil/independant.jpg" alt=""></div>
            </div>
            <div class="col s12 m3">
                <div class="imgContainer inbl middleAlign bigPadding" style="max-width: 200px;"><img style="width: 100%;" src="/bundles/bitoccigo/img/accueil/midi.jpg" alt=""></div>
            </div>
        </div>
    </div>

</div>
<?php get_footer(); ?>

<?php // get_footer(); ?>
