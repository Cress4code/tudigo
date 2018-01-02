<?php /* Template Name: Project Confirmation Sign Up */
get_header();

 global $activePhase;
if($activePhase >= 1){
    wp_redirect(home_url());
}

?>

<?php

if (isset($_GET, $_GET['id'], $_GET['token']) && !empty($_GET)) {
    $error = [];
    $id = (int)$_GET['id'];
    if ($id > 0) {
        $userMeta = get_user_meta($id, "userData", false);
        $userMeta = $userMeta[0];


        $userMeta = (array)json_decode($userMeta);



        if ($userMeta['token'] == trim($_GET['token'])) {

            $userMeta['isconfirm'] = true;
            $userMeta = json_encode($userMeta);


            if (update_user_meta($id, 'userData', $userMeta)) {

                $succes = true;
            } else {
                wp_redirect(home_url("project-login"));
            }

        } else {
            $error['token'] = "It's not seroius , you change the token VALUE";
        }

    } else {
        $error['changeValue'] = "It's not seroius , you change ID VALUE";
    }


} else {
    $error['accessError'] = "You can't acces to this page. Check the browser url";
}


?>
<div>


    <div class=" default-padding-section"
         style="background: url(<?php echo get_template_directory_uri() . "/img/background.jpg" ?>); ">
        <div class="content">

            <div class=" "
            >
                <br>
                <br>
                <br>
                <h3 class="title-3 text-center">
                    Account Confirmation
                </h3>
                <br>
                <br>


                <div class="row">
                    <div class="col s12 m3"></div>
                    <div class="col s12 m6">

                        <?php
                        if (isset($error) && !empty($error)) {
                            ?>
                            <div class="row">
                                <div class="col s12">
                                    <div class="  white-color error section" style=" background-color: #ff4b68">
                                        <p class="text-center">
                                            Please correct that errors .
                                        </p>
                                        <ul>
                                            <?php
                                            foreach ($error as $item => $value) {
                                                ?>
                                                <li><?php echo $value ?></li>
                                                <?php
                                            }
                                            ?>

                                        </ul>

                                    </div>

                                </div>

                            </div>
                            <?php

                        }
                        ?>
                        <?php
                        if (isset($succes) && $succes == true) {
                            ?>
                            <div class="row">
                                <div class="col s12">
                                    <div class="  white-color  succes section" style=" background-color: #4caf50">
                                        <p class="text-center">

                                            Your account has been confirmed.<br><br>
                                            <a class=" white-bg btn-tudigo main-color"
                                               href="<?php echo home_url("project-login") ?>">Log in
                                            </a>

                                        </p>


                                    </div>

                                </div>

                            </div>
                            <?php

                        }
                        ?>


                    </div>

                    <div class="col s12 m3"></div>
                </div>


            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
