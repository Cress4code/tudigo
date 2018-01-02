<?php /* Template Name: All projets Template */
get_header();

global $activePhase;

if ($activePhase != 1) {
    wp_redirect(home_url());
}

?>


<br>
<br>
<br>
<br>
<div class=" default-padding-section main-bg">
    <div class=""
         style="background-image: url(<?php //  get_template_directory_uri() . '/img/background.jpg' ?>) ;  ">

        <div class="container">
            <div class="row">

                <div class="col s12   m6">
                    <div class="section-corver white-color">
                        <h1>
                            <?php
                            echo get_field("projects_banner_title");
                            ?>

                        </h1>
                        <p>
                            <?php
                            echo get_field("project_banner_description");
                            ?>

                        </p>
                    </div>


                </div>
                <div class="col s12 m6">
                    <div class="section-corver">

                        <div style="text-align: center">
                            <?php
                            get_template_part('maps')
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<div class=" ">

    <div class="container">
        <div class="row">


            <form class=" search-form-corver" method="get" action="">
                <div class="">
                    <div class="input-field col s3">

                        <select class="" name="cat">
                            <option value=""> Categories</option>
                            <?php
                            echo getTermsListSelectID('categories-project');
                            ?>
                        </select>

                    </div>
                    <div class="input-field col s3">
                        <select class=" " name="state">
                            <option value=""> County </option>
                            <?php
                            echo getTermsListSelectID('states-project');
                            ?>
                        </select>
                    </div>
                    <div class="input-field col s3">

                        <input id="icon_telephone" type="text" class="validate" name="kw">
                        <label for="icon_telephone">Key Word</label>
                    </div>
                    <div class="input-field col s3">

                        <input type="submit" value="Search" class="validate btn-tudigo second-bg  white-color hidden-xs"
                               style="margin: 0; width: 100%">
                        <button type="submit" class="btn-floating second-bg visible-xs  "><i class="material-icons ">search</i>
                        </button>
                    </div>
                </div>
            </form>


        </div>


    </div>
</div>


<div class="default-padding-section">

    <div class="container">
        <div class="row">
            <div class="col s12 ">
                <div class="categories-of-project">
                    <?php
                    getTermsList("categories-project");
                    ?>
                </div>
            </div>

        </div>


    </div>
</div>


<?php
if (isset($_GET) && !empty($_GET)) {

    ?>
    <div class=" default-padding-section">
        <h2 class="title-2 default-padding-title text-center">
            Search results
        </h2>

        <div class="container">
            <div class="row">

                <?php

                $cat = isset($_GET['cat'])?$_GET['cat']:"";
                $state =  isset($_GET['state'])?$_GET['state']:"" ;
                $keyWord =   isset($_GET['kw'])?$_GET['kw']:"" ;
                $tax = [];
                if (!empty($cat)) {
                    $tax[] = [
                        'taxonomy' => 'categories-project',
                        'field' => 'term_id',
                        'terms' => [$cat]
                    ];
                }
                if (!empty($state)) {
                    $tax[] = [
                        'taxonomy' => 'states-project',
                        'field' => 'term_id',
                        'terms' => [$state],
                    ];
                }
                // print_r($_GET);
$args=array(
    'posts_per_page' => -1,
    'post_type' => 'project',
    'post_title'=>"LIKE % $keyWord%",
    'tax_query' => $tax
);
                $posts_array = get_posts(

                );

                $the_query = new WP_Query( $args );


                ?>

                <?php if ($the_query->have_posts()) : ?>

                    <!-- start of the loop -->
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <div class="col s12 m4">
                            <div class="card">
                                <div class="card-image">
                                    <img src="<?php echo get_image_url(get_the_ID(), 'full') ?>">
                                    <span class=" category main-bg">
                                    <?php
                                    $categories = get_the_terms(get_the_ID(), 'categories-project');
                                    if (!empty($categories)) {
                                        foreach ($categories as $key => $categorie) {
                                            ?>

                                            <a href="<?php echo get_term_link($categorie->term_id) ?>"
                                               class="white-color">

                                                        <i class="fa fa-bookmark">  </i> <?php echo $categorie->name ?>
                                                    </a>

                                            <?php
                                        }
                                    }
                                    ?>

                                </span>
                                    <!--<a class="btn-floating btn-large halfway-fab waves-effect waves-light second-bg"><i
                                                class="material-icons">check</i></a>-->
                                </div>
                                <div class="card-content">
                                <span class=" category second-color">
                                    <i class="fa fa-map-marker"> </i> <?php
                                    $author = get_the_author_meta('ID');
                                    $usermeta = get_user_meta($author, "userData", false);

                                    $term=wp_get_post_terms(get_the_ID(),'states-project');
                                    $term=$term[0];

                                    if (!empty($usermeta)) {
                                        $usermeta = $usermeta[0];
                                        $usermeta = (json_decode($usermeta));
                                        echo $term->name . " - " . $usermeta->zipCode;
                                    }

                                    ?>

                                    </span>
                                    <h3 class="card-title title-4"><?php the_title(); ?></h3>
                                    <p class="text-1"><?php echo tokenTruncate(get_the_excerpt(), 100); ?> ...
                                    </p>
                                    <a href="<?php the_permalink(); ?>"
                                       title="   <?php the_title(); ?>"
                                       class="second-btn main-bg card-read-more white-color radius fixed-bottom">

                                        <span class="btn-text">Discorver project</span>
                                    </a>
                                </div>

                            </div>
                        </div>

                    <?php endwhile; ?><!-- end of the loop -->

                    <!-- put pagination functions here -->
                    <?php wp_reset_postdata(); ?>

                <?php else: ?>

                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

                <?php endif; ?>

            </div>

        </div>

        <div style="text-align: center">
            <a href="<?php echo home_url("projects") ?>" title="Tous les projets" data-label="tous les projets"
               class="btn-tudigo second-btn main-bg read-more white-color">
                All projects
            </a>
        </div>

    </div>
    <?php

} else {
    ?>


    <div class="default-padding-section">
        <div class="container">
            <div class="row">

                <?php
                get_template_part('project-loop');
                ?>

            </div>

        </div>


    </div>
    <br>
    <br>

    <?php
}
?>
<?php get_footer(); ?>
