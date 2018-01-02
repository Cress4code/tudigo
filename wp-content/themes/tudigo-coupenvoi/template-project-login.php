<?php


if (isset($_POST) && !empty($_POST)) {

    $data = (object)$_POST;

    $error = [];
    $user = login_with_email_address($data->user_email);


    if (!empty($user)) {
        $userMeta = get_user_meta($id, "userData", false);
        $userMeta = $userMeta[0];
        if($userMeta['isconfirm']==true){
            if (wp_check_password($data->user_pass, $user->user_pass, $user->ID)) {

                if (programmatic_login($user->user_login)) {
                    wp_redirect(home_url("project-creation"));
                }
            } else {
                $error['password'] = "Verify your password";
            }
        }else{

            global $emailData;


            echo   $tokenLink= home_url('project-confirmation-sign-up').'?id='.$user->ID.'&token='.$userMeta['token'];
            $emailData['first_name']=$user->first_name;
            $emailData['last_name']=$user->last_name;
            $emailData['tokenLink']=$tokenLink;
            ob_start();
            get_template_part('mails/sign');
            $message = ob_get_contents();
            ob_end_clean();
            wp_mail($user->user_email,"Confirm your email",$message);

            $error['confirmation'] = "Account not confirmed . We just sent you new confirm email";
        }






    } else {
        $error['email'] = " Email is incorrect";
    }


}


?>

<?php /* Template Name: Project Login */
get_header();
global $activePhase;
if ($activePhase >= 1) {
    wp_redirect(home_url());
}
?>

<div>


    <div class=" default-padding-section"
         style="background: url(<?php echo get_template_directory_uri() . "/img/background.jpg" ?>); ">
        <div class=" " style="margin: 100px 0">

            <div class=" "
            >

                <h3 class="title-3 text-center">
                    Sign in
                </h3>


                <div class="row">
                    <div class="col s12 m4"></div>
                    <div class="col s12 m4">
                        <form method="post" class=" form-corver " action="#">
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


                            <div class="row">
                                <div class="input-field col s12 ">
                                    <input type="text" id="user_email" name="user_email" required
                                           class="validate">
                                    <label for="user_email">Email</label>
                                </div>
                            </div>
                            <div class="row">

                                <div class="input-field col s12  ">
                                    <input type="password" id="user_pass" name="user_pass" required
                                           class="validate">
                                    <label for="user_pass">Password</label>
                                </div>
                            </div>


                            <div class="inline clearfix">
                                <button type="submit" value="Send Messager" class=" main-bg btn-tudigo">Log in
                                </button>
                                <p style="text-align: center">Want to submit your project ?
                                    <a
                                            href="<?php echo home_url("project-sign-up") ?>">
                                        Sign up</a>
                                </p>
                            </div>

                        </form>
                    </div>

                    <div class="col s12 m4"></div>
                </div>


            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
