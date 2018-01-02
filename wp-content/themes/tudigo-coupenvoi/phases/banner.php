<div class="main-wrapper  ">

    <div class=" main-bg mywraper-bg"
         style="background: url(<?php echo get_template_directory_uri() . '/img/default-bg.png' ?>);">
        <div class="container">
            <div class="row ">
                <div class="col s12 m6">
                    <div class=" white-color">
                        <div class="small-padding">
                            <?php
                            global $phases;
                            global $activePhase;
                            $currentPhases = (object)$phases[$activePhase];


                            ?>
                            <p class="title-4">
                                FROM <?php echo changedateWithoutYear($currentPhases->start_phase_date) ?>
                                TO <?php echo changedate($currentPhases->end_phase_date) ?></p>
                            <h1 class="title-1 tudigo-title-banner">
                                <?php _e($currentPhases->site_home_title) ?>
                            </h1>

                            <p class="text-1  tudigo-descriptio">
                                <?php _e($currentPhases->site_small_description) ?></p>

                            <?php
                            if (!empty($currentPhases->phase_buttons_repeteur)) {
                                foreach ($currentPhases->phase_buttons_repeteur as $button) {
                                    $button = (object)$button;


                                    $class = ($button->is_main_color_button == "true") ? "btn-tudigo  second-border-color  second-bg" : "btn-tudigo  white-border-color tudigo-white-btn";
                                    $applwhite = ($button->is_main_color_button != "true") ? ' style=" border: 1px solid white !important" ' : "";
                                    ?>
                                    <a href="<?php echo $button->link_of_redirection ?>" <?php echo $applwhite ?>
                                       class="<?php echo $class ?>"
                                    ><?php _e($button->button_name) ?></a>


                                    <?php

                                }

                            }
                            ?>

                        </div>

                    </div>


                </div>

                <div class="col s12 m6">
                    <div class="working-duration second-bg white-color">
                        <?php
                        echo get_field("site_current_edition","option")
                        ?>
                    </div>
                    <div class="small-padding">
                        <?php
                        if (!empty($currentPhases->site_banner_image)) {
                            ?>

                            <img  width="100%" class="responsive-img"
                                 src="<?php echo $currentPhases->site_banner_image ?>"
                                 alt="<?php echo bloginfo('name');?>"/>
                            <?php

                        } else {
                            ?>
                            <iframe class="responsive-img"
                                    style="background-image: url('<?php echo get_image_url(get_the_ID(), "full") ?>')"
                                    width="100%" height="400px"
                                    src="<?php echo str_replace("watch?v=","embed/",$currentPhases->site_banner_phase_video_link ). '?autoplay=0&showinfo=0&controls=0'; ?>"
                                    frameborder="0" allowfullscreen>


                            </iframe>

                            <?php

                        }

                        ?>

</div>



                </div>

            </div>
        </div>
    </div>
</div>
