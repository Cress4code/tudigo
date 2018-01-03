<?php
get_header();
?>
<?php
$canseePreview = false;
if (is_user_logged_in()) {
    $canseePreview = true;
}
global $activePhase;
if ($activePhase != 1 && $canseePreview == false) {
    wp_redirect(home_url());
}
?>

<br>
<br>
<br>
<br>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>


    <div class=" default-padding-section main-bg" style="padding-bottom:10px ">


        <div class=" white-color ">
            <div class="row">
                <div class="col s12 m2">
                    <div class="" style="    margin: 30px 0;">
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
    line-height: 54px;
">
                            <?php
                            the_title();
                            ?>
                        </h1>
                        <p class="title-2" style="    font-size: 27px;
    line-height: 28px;">
                            <?php
                            the_excerpt()
                            ?>
                        </p>
                        <p class="text-1 hidden-xs">
                            <span>Categorie: </span>
                            <?php
                            getPostTermsList(get_the_ID(), "categories-project")
                            ?>
                        </p>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class=" map-corver " style="
    width: 50%;
    margin: -2px auto;
">
                        <div class="hidden-xs">
                            <?php
                            get_template_part("maps")
                            ?>
                        </div>


                    </div>
                    <p class="text-1" style="padding: 10px">


                        <span class="second-color " >   <i class="fa fa-map-marker"></i></span>
                        <?php
                        $author = get_the_author_meta('ID');
                        $usermeta = get_user_meta($author, "userData", false);
                        $term = wp_get_post_terms(get_the_ID(), 'states-project');
                        $term = $term[0];


                        echo $term->name . " , CA ";


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

    <?php
    if (isset($_GET, $_GET['token']) && !empty($_GET)) {
        $token = $_GET['token'];
        $dailyVotes = new DailyVotes();


        if ($dailyVotes->validateToken($token)) {
            $votes = new Votes();
            $votes->storeVote(get_the_ID());
            get_template_part("voting/succesVote");
            echo "<script> var canShare=true </script>";

        } else {
            wp_redirect(get_the_permalink());
        }
    }

    ?>
    <div style="padding: 40px">
        <div class="visible-xs">
            <?php
            $votes = new Votes();
            $count = $votes->getPostVotes(get_the_ID());


            ?>
            <h3 class="" style="font-size: 30px">
                NUMBER OF VOTERS :
                <span class="vote-number main-color">
                            <?php
                            echo !empty($count) ? $count : 0
                            ?>
                        </span>
        </div>
    </div>

    <div class="  ">
        <div class="container">
            <div class="row">
                <div class="col s12 m8">


                    <div class=" " style="padding: 0 20px;">

                        <?php
                        if (!empty(get_post_meta(get_the_ID(), 'rssocial-facebook', true))) {
                            ?>
                            <iframe style="background-image: url('<?php echo get_image_url(get_the_ID(), "full") ?>')"
                                    frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen
                                    width="100%" height="345"
                                    src="<?php echo str_replace("watch?v=", "embed/", get_post_meta(get_the_ID(), 'rssocial-youtube', true)); ?>">


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


                        <div class="follow-section">
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
                        <h3 class="title-3 hidden-xs">
                            NUMBER OF VOTERS :
                            <span class="vote-number main-color">
                            <?php
                            echo !empty($count) ? $count : 0
                            ?>
                        </span>
                        </h3>
                        <h4 class="title-4">
                            Support this project!
                        </h4>
                        <p class="text-1">
                            You can support this project by voting for him and sharing his profile on Facebook.
                            Each action brings him an extra point.
                        </p>
                        <?php
                        // $canseePreview = false;
                        if ($canseePreview == false) {
                            ?>

                            <a data-target="modal1" title="I vote" data-id="<?php echo get_the_ID() ?>"
                               class="btn-tudigo js-vote-btn second-bg second-border-color modal-trigger voteUp"
                               style="margin: 30px 0;">
                                I vote
                            </a>
                            <a href="javascript:;" style="margin-top: 0 ;margin-bottom: 30px ;" title="I share"
                               class="btn-tudigo facebook js-facebook-btn main-bg main-border-color"
                            >
                                I share
                            </a>
                            <?php
                        }
                        ?>

                        <br>
                        <a href="<?php echo site_url("projects") ?>" title="All projects"
                           class="title-4 discover">
                            Discorver all projects
                        </a>
                        <p class="text-1">

                            By voting or sharing a project, you acknowledge having read and accepted the
                            <a href="<?php echo home_url('terms-and-conditions') ?>" class="js-rules-btn">
                                TERMS AND CONDITIONS
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
