<?php get_header(); ?>
<?php
global $main_color;
?>




<?php if (have_posts()): while (have_posts()) : the_post(); ?>

<br>
<br>
<br>
<br>
<br>



    <?php
    $imgeURL=!empty(get_image_url(get_the_ID(),'full'))?get_image_url(get_the_ID(),'full'):get_field("site_banner_image","option");
    ?>
    <div class=" default-padding-section    " style="background: linear-gradient(
            rgb(0,65,130),
            rgba(0,65,130,0.92)
    ),url(<?php echo $imgeURL?>)">
        <div class="     ">
            <div class="container">

                <div class=" white-color text-center">
                    <h1><?php the_title(); ?></h1>
                </div>


            </div>
        </div>


    </div>


    <div class="default-padding-section" style="background-image: url(<?php echo get_template_directory_uri()."/img/background.jpg"?>)">
        <div class="container">
            <div class="row">
                <div class="col s12 m2"></div>
                <div class="col s12 m8">
                    <div class="text-center">
                        <?php
                        the_content();
                        ?>
                    </div>
                    </div>


                <div class="col s12 m2"></div>

            </div>

        </div>


    </div>



<?php endwhile; ?>

<?php else: ?>

    <!-- article -->
    <article>

        <h2><?php _e('Sorry, nothing to display.', 'html5blank'); ?></h2>

    </article>
    <!-- /article -->

<?php endif; ?>


<?php get_footer(); ?>
