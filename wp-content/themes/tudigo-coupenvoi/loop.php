<?php if (have_posts()): while (have_posts()) : the_post(); ?>

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

                                            <a href="<?php echo get_term_link($categorie->term_id) ?>" class="white-color">

                                                        <i class="fa fa-bookmark">  </i> <?php echo $categorie->name ?>
                                                    </a>

                                            <?php
                                        }
                                    }
                                    ?>

                                </span>
                <!-- <a class="btn-floating btn-large halfway-fab waves-effect waves-light second-bg">
                     <i class="material-icons">thumb_up</i></a>-->
            </div>
            <div class="card-content">
                                <span class=" category second-color">
                                    <i class="fa fa-map-marker"> </i> <?php
                                    $author = get_the_author_meta('ID');
                                    $usermeta = get_user_meta($author, "userData", false);

                                    if(!empty($usermeta)){
                                        $usermeta = $usermeta[0];
                                        $usermeta = (json_decode($usermeta));
                                        $city=explode(',',$usermeta->city);

                                        echo ' '.$city [0]. "  -   " . $usermeta->zipCode;
                                    }


                                    ?>

                                    </span>
                <h3 class="card-title title-4"><?php the_title(); ?></h3>
                <p class="text-1"><?php echo tokenTruncate(get_the_excerpt(), 100); ?> ...
                </p>
                <a href="<?php the_permalink(); ?>"
                   title="   <?php the_title(); ?>" class="second-btn main-bg card-read-more white-color radius fixed-bottom">

                    <span class="btn-text">Discover the project </span>
                </a>
            </div>

        </div>
    </div>
<?php endwhile; ?>

<?php else: ?>

    <!-- article -->
    <article>
        <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
    </article>
    <!-- /article -->

<?php endif; ?>
