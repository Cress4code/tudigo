
<?php get_header(); ?>
<?php
global $main_color;
?>

<br>
<br>
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
                    <h1><?php echo "Error 404" ?></h1>
                </div>


            </div>
        </div>


    </div>


    <div class="default-padding-section" style="background-image: url(<?php echo get_template_directory_uri()."/img/background.jpg"?>)">
        <div class="container">
            <div class="row">
                <div class="col s12 m2"></div>
                <div class="col s12 m8">
                    <h2>
                        Oops !, Error 404!</h2>
                    <div class="button">
                        <p class="smallMargin">
                            The page you are looking for can not be displayed, Any question? Information about ?</p><br>
                        <a href="<?php  echo home_url()?>" class="btn-secondary main-border-color white-color btn-tudigo">Go back</a>

                    </div>
                </div>


                <div class="col s12 m2"></div>

            </div>

        </div>


    </div>




<?php get_footer(); ?>