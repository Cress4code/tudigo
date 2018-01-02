<?php

$countries = getCountriesList();
if (isset($_POST) && !empty($_POST)) {

        $data = (object)$_POST;
        $WP_array = array(
            'user_login' => $data->user_login,
            'user_email' => $data->user_email,
            'user_pass' => $data->user_pass,
            'user_url' => "",
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'nickname' => "",
            'description' => "",
            'role' => "candidat"
        );

        $userMeta = array(
            'street' => $data->street,
            'city' => $data->city,
            'bp' => $data->bp,
            'codePays' => $data->codePays,
        );

        if($data->user_pass==$data->user_pass1){
            $user_id = wp_insert_user($WP_array);



            if ($user_id && !is_wp_error($user_id)) {
                add_user_meta($user_id, 'userData', json_encode($userMeta));
                wp_authenticate(   $data->user_email, $data->user_pass );
                $code = sha1($user_id . time());

                $succes = true;
            }
        }else{
            $passwordError = false;
        }


}


?>

<?php /* Template Name: Project Submit */
get_header(); ?>

<div id="page-createDraftProject" class="imageCover">
    <div id="header-spacer"></div>

    <div class="container">
        <br>
        <nav class="ariane ariane-3">
            <ul>
                <li class="act">
                    <a href="<?php echo site_url('project-sign-up')?>">
                        <div class="number main-color">1</div>
                        <h2 class="second-color">Sign Up</h2>
                    </a>
                </li>
                <li class="">
                    <a href="<?php echo site_url('project-application')?>">
                        <div class="number main-color">2</div>
                        <h2>your project</h2>
                    </a>
                </li>
                <li class="">
                    <a href="<?php echo site_url('project-submission')?>">
                        <div class="number main-color">3</div>
                        <h2>validation</h2>
                    </a>
                </li>
            </ul>
            <div class="clearFloat">&nbsp;</div>
        </nav>

        <h2 id="page-createDraftProject-title" class="white quicksand bigHuge center light">Propose your project in 5
            minutes</h2>

        <a href="#" class="hideResp3 floatRight secondary bold block main-color" style="margin-right: 10px;"><i
                    class="fa fa-phone fa-2x"></i> &nbsp; Need help?</a>
        <div class="clearFloat">&nbsp;</div>
        <br>

        <div class="whiteTransparentBlock smallShadowed"><br>
            <?php
            if (isset($succes) && $succes) {
                ?>
                <div class="restrictCenter700 smallPadding">

                    <hr class="whiteBlock">
                    <div class="midMargin">

                    </div>
                    <div class="mainTransparentBlock bigPadding white main-bg">
                        <div class="uppercase bold stdMid">
                            Votre inscription est bien enregistrée
                        </div>
                        <br>
                        <div class="row">
                            <div class="col s12 m6">
                                <a href="<?php wp_login_url() ?>" class="btn second-bg">Connect</a>
                                <br>

                            </div>

                        </div>
                    </div>
                </div>
                <?php

            }else{
            ?>
            <h3 class="quickBoldUp stdMid main main-color">Sign Up</h3><br>
            <form name="inscription" method="post" action="#" class="form-materialize" autocomplete="off">
                <input style="display:none" type="text" name="fakeusernameremembered">
                <input style="display:none" type="password" name="fakepasswordremembered">

                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field"><input type="text" id="user_login" name="user_login"
                                                        required="required"> <label for="user_login" class="required">Your
                                nickname
                                <span class="error">*</span></label></div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field"><input type="email" id="user_email" name="user_email"
                                                        required="required"> <label for="user_email" class="required">Your
                                email
                                <span class="error">*</span></label></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field"><input type="text" id="first_name" name="first_name"
                                                        required="required"> <label for="first_name" class="required">First
                                name
                                <span class="error">*</span></label></div>
                        <div class="input-field">
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                            <div class="input-field"><input type="text" id="last_name" name="last_name"
                                                            required="required"> <label for="last_name"
                                                                                        class="required">Last name
                                    <span class="error">*</span></label></div>
                        </div>
                    </div>
                </div>

                <!--<div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                            <div class="input-field"><input type="text" id="inscription_codePostal"
                                                            name="inscription[codePostal]" required="required"> <label
                                        for="inscription_codePostal" class="required">Postal code
                                    <span class="error">*</span></label></div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                    </div>
                </div>-->
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field">
                            <div class="input-field">
                                <input type="password" id="user_pass" name="user_pass"
                                                            required="required">
                                <label for="user_pass" class="required">Password
                                    <span class="error">* <?php  isset($passwordError )?"Les mot de passe ne correspondent pas":""?></span> </label></div>
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                            <div class="input-field"><input type="password" id="user_pass1" name="user_pass1"
                                                            required="required"> <label for="user_pass1"
                                                                                        class="required">Confirm your
                                    password
                                    <span class="error">*</span></label></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field"><input type="text" id="street" name="street"
                                                        required="required"> <label for="street" class="required">Rue

                                <span class="error">*</span></label></div>
                        <div class="input-field">
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                            <div class="input-field"><input type="text" id="city" name="city"
                                                            required="required"> <label for="city"
                                                                                        class="required">City
                                    <span class="error">*</span></label></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6">
                        <div class="input-field"><input type="text" id="bp" name="bp"
                                                        required="required"> <label for="bp" class="required">PO BOX
                                <span class="error">*</span></label></div>
                        <div class="input-field">
                        </div>
                    </div>
                    <div class="col s12 m6">
                        <div class="input-field">
                            <div class="input-field">

                                <select id="codePays" name="codePays"
                                        required="required">
                                    <?php
                                    foreach ($countries as $country) {
                                        $country=(object)$country;
                                        ?>
                                        <option <?php echo $country->alpha2Code?>><?php echo $country->name?></option>
                                        <?php
                                    }
                                    ?>

                                </select>
                                <span class="error">*</span></label></div>
                        </div>
                    </div>
                </div>
                <div class="restrictCenter250 center">
                    <div class="midMargin">
                        <button type="submit" id="inscription_submit" name="submit"
                                class="btn btn-block btn-secondary main-bg">Continue
                        </button>
                    </div>
                </div>

                <div class="center smallTiny">In creating your account, you accept all<br> of our Terms and
                    Conditions
                </div>
                <br><!--
                <input type="hidden" id="token" name="token" class="valid" value="<?php /* echo getToken()*/ ?>"></form>
        -->

        </div>

        <?php

        }
        ?>


    </div>

    <div class="container">
        <div class="hugePadding white center smallStd">
            <p class="smallMargin">L’équipe de Bulb in Town reste à votre disposition pour toute question par téléphone
                au 01 85 09 06 27 ou par email ici</p>
            <p class="smallMargin">L’ensemble de ces données sont confidentielles, conformément aux Lois CNIL et vous
                pourrez à tout moment demander à les retirer en nous envoyant un email à l’adresse <a href="#">contact@bulbintown.com</a>
                ; sauf si vous vous êtes déjà engagés dans un processus d’investissement et que ce dernier n’est pas
                encore finalisé.</p>
        </div>
    </div>
</div>
<?php get_footer(); ?>
