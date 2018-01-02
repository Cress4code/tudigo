<div class=" second-bg default-padding-section"  style="background: url(<?php echo  get_template_directory_uri().'/img/default-bg.png'?>);">
    <h2 class="title-2 default-padding-title text-center">
        <?php
        echo get_field("reason_title", "option");
        ?>
    </h2>

    <div class="container">
        <div class="row">
            <?php
            $reasons = get_field("site_reasons", "option");
            if (!empty($reasons)) {
                foreach ($reasons as $reason) {
                    $reason = (object)$reason;
                    ?>
                    <div class=" col s12 m4  ">
                        <div class="text-center ">
                            <div class=" "><img class="reason-img"
                                                src="<?php echo $reason->reason_logo ?>"
                                                alt="<?php echo $reason->reasons_title ?>">
                            </div>


                            <h4 class=" reason-title"><?php echo $reason->reasons_title ?></h4>

                            <p class="white-color"><?php echo $reason->reason_descriptiion ?></p>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>


</div>