<div id="page-lancerProjet">


    <div class="white-bg"><br><br>


        <div class="container">
            <h2 class="mid quickBoldUp midMargin center">Important Date</h2><br><br>


            <div>
                <div id="don" class="calendarStep calendarStep-main">
                    <div class="element">
                        <h3 class="main-color">
                            Call for application
                        </h3>

                        <p>
                            <strong class="second-color"><?php
                                echo changedate(get_field("project_call_for_applications", "option"))
                                ?></strong>
                        </p>
                        <p>

                            <?php

                            echo get_field("project_call_for_applications_desc", "option")
                            ?>
                        </p>

                        <div class="imgContainer img-calendar"><img
                                src="<?php echo get_template_directory_uri() . "/img/003-calendar-3.png" ?>"
                                alt="">
                        </div>
                    </div>

                    <div class="element">
                        <h3 class="main-color">
                            Online Voting
                        </h3>

                        <p>
                            <strong class="second-color"><?php
                                echo changedate(get_field("project_vote", "option"));
                                ?></strong>
                        </p>
                        <p>

                            <?php
                            echo get_field("project_vote_dec", "option")
                            ?>
                        </p>

                        <div class="imgContainer img-calendar"><img
                                src="<?php echo get_template_directory_uri() . "/img/003-calendar-3.png" ?>"
                                alt="">
                        </div>
                    </div>

                    <div class="element">
                        <h3 class="main-color">
                            Announcement of results
                        </h3>

                        <p>
                            <strong class="second-color"><?php
                                echo changedate(get_field("project_annoncement_result", "option"));
                                ?></strong>
                        </p>
                        <p>

                            <?php
                            echo get_field("project_annoncement_result_desc", "option")
                            ?>
                        </p>

                        <div class="imgContainer img-calendar"><img
                                src="<?php echo get_template_directory_uri() . "/img/003-calendar-3.png" ?>"
                                alt="">
                        </div>
                    </div>


                </div>

            </div>
        </div>
        <br><br><br>
    </div>


</div>