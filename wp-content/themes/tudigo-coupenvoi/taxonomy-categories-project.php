
<?php get_header(); ?>

<?php

global $activePhase;
if($activePhase !=1){
    wp_redirect(home_url());
}
?>
<br>
<br>
<br>
<br>
<br>
<?php
$imgeURL=!empty(get_image_url(get_the_ID(),'full'))?get_image_url(get_the_ID(),'full'):get_field("site_banner_image","option");
?>
<div class=" default-padding-section   main-bg " style="background: url("<?php echo $imgeURL?>")">
<div class="     ">
    <div class="container">

        <div class=" white-color text-center">

            <h1><?php _e( 'All projects:  ', 'html5blank' ); single_cat_title(); ?></h1>

        </div>


    </div>
</div>


</div>




<div class="default-padding-section">
    <div class="container">
        <div class="row">

            <?php
            get_template_part('loop');
            ?>

        </div>

    </div>


</div>
<br>
<br>


<?php get_footer(); ?>
