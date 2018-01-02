


<?php
get_header();
?>

<br>
<br>
<br>
<br>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>

    <div class=" default-padding-section main-bg">


        <div class=" white-color ">
            <div class="row">
                <div class="col s12 m2">
                    <div class="">
                        <div class="img-container">
                            <img src="<?php echo get_image_url(get_the_ID(), "full") ?>" class=""
                                 alt="Image du projet"/>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="middle ">
                        <h1 class="title-1" style="
    font-size: 60px;
    line-height: 55px;
">
                            <?php
                            the_title();
                            ?>
                        </h1>
                        <h2 class="title-2" style="    font-size: 27px;
    line-height: 28px;">
                            <?php
                            the_excerpt()
                            ?>
                        </h2>
                        <p class="text-1">
                            <span>Categorie: </span>
                            <?php
                            getPostTermsList(get_the_ID(), "categories-project")
                            ?>
                        </p>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class=" " style="
    width: 50%;
    margin: 45px auto;
">

                        <?php
                        get_template_part("maps")
                        ?>
                        <p class="text-1">

                            <i class="fa fa-map-marker"></i>
                            <span> </span>
                            <?php
                            $author = get_the_author_meta('ID');
                            $usermeta = get_user_meta($author, "userData", false);

                            if(!empty($usermeta)){
                                $usermeta = $usermeta[0];
                                $usermeta = (json_decode($usermeta));
                                echo $usermeta->city . "- " . $usermeta->zipCode;
                            }


                            ?>

                            <br/>

                            <?php
                            echo $author = get_the_author();


                            ?>


                        </p>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <br>
    <br>
    <br>
    <br>

    <div class="  ">
        <div class="container">
            <div class="row">
                <div class="col s12 m8">
                    <div class=" " style="padding: 0 20px;">
                        <?php
                        if (!empty(get_post_meta(get_the_ID(), 'rssocial-facebook', true))) {
                            ?>
                            <iframe style="background-image: url('<?php echo get_image_url(get_the_ID(), "full") ?>')"
                                    width="100%" height="345"
                                    src="<?php echo get_post_meta(get_the_ID(), 'rssocial-youtube', true); ?>">


                            </iframe>
                            <?php
                        }
                        ?>

                        <h2> OUR PROJECT </h2>
                        <div class="content-wrapper">
                            <?php
                            the_content()
                            ?>
                        </div>


                        <div>
                            <h3>Follow our project</h3>
                            <a target="_blank" class=" btn-floating "
                               href="<?php echo get_post_meta(get_the_ID(), 'rssocial-facebook', true); ?>"
                               style="background-color: darkblue"><i class="fa fa-facebook"></i></a>
                            <a target="_blank" class=" btn-floating "
                               href="<?php echo get_post_meta(get_the_ID(), 'rssocial-youtube', true); ?>"
                               style="background-color: red"><i class="fa fa-youtube"></i></a>
                        </div>

                    </div>
                </div>
                <div class="col s12 m4">

                    <div class="  js-part-right">
                        <?php
                        $votes = new Votes();
                        $count = $votes->getPostVotes(get_the_ID());


                        ?>
                        <h3 class="title-3">
                            Nombre de votants :
                            <span class="vote-number main-color">
                            <?php
                            echo !empty($count) ?$count:0
                            ?>
                        </span>
                        </h3>
                        <h4 class="title-4">
                            Soutenez ce projet !
                        </h4>
                        <p class="text-1">
                            Vous pouvez soutenir ce projet en votant pour lui et partageant sa fiche sur Facebook.
                            Chaque action lui rapporte un point supplémentaire.
                        </p>
                        <a data-target="modal1" title="je vote" data-id="<?php echo get_the_ID() ?>"
                           class="btn-tudigo js-vote-btn second-bg second-border-color modal-trigger voteUp"
                           data-project="115" style="margin: 30px 0;">
                            Je vote
                        </a>
                        <a href="javascript:;" style="margin-top: 0 ;margin-bottom: 30px ;" title="Je Partage"
                           class="btn-tudigo facebook js-facebook-btn main-bg main-border-color" data-project="115"
                        >
                            Je Partage
                        </a>
                        <br>
                        <a href="<?php echo site_url("projects") ?>" title="découvrir les autres projets"
                           class="title-4 discover">
                            découvrir les autres projets
                        </a>
                        <p class="text-1">
                            En votant ou partageant un projet, vous reconnaissez avoir pris connaissance et acceptez le
                            <a href="javascript:;" class="js-rules-btn">
                                règlement du concours.
                            </a>
                        </p>
                        <span class="separator"></span>


                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php else: ?>

    <!-- article -->
    <article>

        <h1><?php _e('Sorry, nothing to display.', 'html5blank'); ?></h1>

    </article>
    <!-- /article -->

<?php endif; ?>

<?php get_footer() ?>
