<?php /* Template Name: Account Detail Template */
get_header();

global $activePhase;
if ($activePhase >= 1) {
    wp_redirect(home_url());
}

if (is_user_logged_in()) {
    $currentUser = wp_get_current_user();

    $userMeta = get_user_meta($currentUser->ID, 'userData', true);
    $userMeta = json_decode($userMeta);


}


?>

<?php

if (isset($_POST) && !empty($_POST)) {


    $data = (object)$_POST;
    $error = [];

    $WP_array = array(


        'ID' => $currentUser->ID,
        'first_name' => $data->first_name,
        'last_name' => $data->last_name

    );
    $userMeta = array(
        'street' => $data->street,
      //  'city' => $data->city,
        'othercity' => $data->othercity,

        'zipCode' => $data->zipcode,
    );


    $user_id = wp_update_user($WP_array);


    if ($user_id && !is_wp_error($user_id)) {
        update_user_meta($user_id, 'userData', html_entity_decode(json_encode($userMeta)));
        wp_redirect(home_url("account-detail"));

    } else {

        $error ['usercreation'] = $user_id->get_error_message();


    }
}
global $activePhase;


?>
<div>


    <div class=" default-padding-section">
        <div class="content">

            <div class="to-win form-corver"
                 style="background: url(<?php echo get_template_directory_uri() . "/img/background.jpg" ?>); ">

                <br>
                <br>
                <h3 class="title-3">
                    Account Detail
                </h3>
                <br>


                <div class="row">
                    <div class="col s12 m3"></div>
                    <div class="col s12 m6">
                        <form method="post" class="white-bg form-corver" action="#">
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
                                <div class="input-field col s12 m6">
                                    <input type="text" id="first_name" name="first_name" required
                                           value="<?php echo $currentUser->user_firstname ?>"
                                           class="validate">
                                    <label for="first_name">First Name</label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <input type="text" id="last_name" name="last_name" required
                                           value="<?php echo $currentUser->last_name ?>"
                                           class="validate">
                                    <label for="last_name">Last Name</label>
                                </div>
                            </div>


                            <!--<div class="row">


                                <div class="input-field col m6 s12">
                                    <input type="text" id="city" name="city" required
                                           value="<?php /*echo $userMeta->city */?>"
                                           class="validate"">
                                    <label for="city">City </label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input type="text" id="othercity" name="othercity"

                                           value="<?php /*echo $userMeta->othercity */?>"
                                           class="validate"">
                                    <label for="othercity">Other City </label>
                                </div>
                            </div>-->

                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input type="text" id="street" name="street"
                                           value="<?php echo $userMeta->street ?>"
                                           required
                                           class="validate">
                                    <label for="street">Street</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input type="text" id="zip" name="zipcode"
                                           value="<?php echo $userMeta->zipCode ?>"
                                           required
                                           class="validate">
                                    <label for="zip">zipCode</label>
                                </div>


                            </div>


                            <div class="inline clearfix">
                                <button type="submit" value="Send Messager" class=" main-bg btn-tudigo">Update
                                </button>

                            </div>

                        </form>
                    </div>

                    <div class="col s12 m3"></div>
                </div>


            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
