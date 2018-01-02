

<?php /* Template Name: Project Sign Up */
get_header();

global $activePhase;
if($activePhase >= 1){
    wp_redirect(home_url());
}

?>

<?php

if (isset($_POST) && !empty($_POST)) {

    $data = (object)$_POST;
    $error = [];

    $WP_array = array(
        'user_login' => cleanSpaceAccent($data->first_name . $data->last_name),
        'user_email' => $data->user_email,
        'user_pass' => $data->user_pass,

        'first_name' => $data->first_name,
        'last_name' => $data->last_name,

        'role' => "candidat"
    );
    $token = uniqid();
    $userMeta = array(
        'token' =>$token,
        'isconfirm' => false,
        'street' => $data->street,
       // 'city' => $data->city,
       // 'othercity' => $data->othercity,

        'zipCode' => $data->zipcode,
    );


    if ($data->user_pass == $data->user_pass1) {

        $user_id = wp_insert_user($WP_array);





        if ($user_id && !is_wp_error($user_id)) {
            if(add_user_meta($user_id, 'userData', json_encode($userMeta))){
                $project = [
                    'post_title' => $data->post_title,
                    'post_type' => 'project',
                    'post_status' => 'draft',
                    'post_author' => $user_id,
                ];

                $post_id = wp_insert_post($project);


                if (!empty($post_id)) {
                    wp_set_object_terms($post_id, $data->categoryProject, 'categories-project');
                    wp_set_object_terms($post_id, $data->statesProject, 'states-project');

                    global $emailData;


                    echo   $tokenLink= home_url('project-confirmation-sign-up').'?id='.$user_id.'&token='.$token;
                    $emailData['first_name']=$data->first_name;
                    $emailData['last_name']=$data->last_name;
                    $emailData['tokenLink']=$tokenLink;
                    ob_start();
                    get_template_part('mails/sign');
                    $message = ob_get_contents();
                    ob_end_clean();
                    wp_mail($data->user_email,"Confirm your email",$message);
                    $succes=true;
                }
            }else{
                $error['error']="Some errors";
            }


        } else {

            $error ['usercreation'] = $user_id->get_error_message();

        }
    } else {
        $error ['password'] = "Passwords don't match";

    }


}
global $activePhase;






?>
<div>


    <div class=" default-padding-section"  style="background: url(<?php echo get_template_directory_uri() . "/img/background.jpg" ?>); ">
        <div class="content">

            <div class=" "
                >
                <br>
                <br>
                <br>
                <h3 class="title-3 text-center">
                    Inscription
                </h3>
<br>
<br>


                <div class="row">
                    <div class="col s12 m3"></div>
                    <div class="col s12 m6">
                        <form method="post" class="white-bg form-corver" action="#">
                            <?php
                            if(isset($error) && !empty($error)){
                                ?>
                                <div class="row">
                                    <div class="col s12">
                                        <div class="  white-color error section" style=" background-color: #ff4b68">
                                            <p class="text-center">
                                                Please correct that errors .
                                            </p>
                                            <ul>
                                                <?php
                                                foreach ($error as $item=>$value){
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
                            if(isset($succes) && $succes==true){
                                ?>
                                <div class="row">
                                    <div class="col s12">
                                        <div class="  white-color  succes section" >
                                            <div class="text-center">
                                                <img src="<?php  echo get_template_directory_uri()?>/img/message-green.png" alt="Succes Email" style="100px; height: 100px;"/>
                                            </div>

                                                <p class="text-center " style=" background-color: #4caf50 ;    padding: 50px 0;">

                                                    Congratulations !</br> Please confirm your registration by clicking on the link sent to your email

                                                </p>


                                        </div>

                                    </div>

                                </div>
                       <?php  }else{
                                ?>
                                <div class="row">
                                    <div class="input-field col s12 m6">
                                        <input type="text" id="first_name" name="first_name" required
                                               value="<?php echo  (isset($error) && !empty($error))?$data->first_name:"" ?>"
                                               class="validate">
                                        <label for="first_name">First Name</label>
                                    </div>

                                    <div class="input-field col s12 m6">
                                        <input type="text" id="last_name" name="last_name" required
                                               value="<?php echo  (isset($error) && !empty($error))?$data->last_name:"" ?>"
                                               class="validate">
                                        <label for="last_name">Last Name</label>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="input-field col m12 s12">
                                        <input type="email" id="user_email" name="user_email"
                                               value="<?php echo  (isset($error) && !empty($error))?$data->user_email:"" ?>"
                                               required
                                               class="validate">
                                        <label for="user_email">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col m6 s12">
                                        <input type="password" id="user_pass" name="user_pass" required
                                               class="validate">
                                        <label for="user_pass">Password</label>
                                    </div>

                                    <div class="input-field col m6 s12">
                                        <input type="password" id="user_pass1" name="user_pass1" required
                                               class="validate">
                                        <label for="user_pass1">Confirm Password </label>
                                    </div>
                                </div>

                                <div class="row">


                                    <div class="input-field col m12 s12">
                                        <select id="post_categoryProject" name="statesProject"
                                                class="validate">

                                            <?php
                                            $settedcat=(isset($error) && !empty($error))?$data->statesProject:"";
                                            getTermsListSelectWithlastSetValue('states-project',$settedcat)
                                            ?>
                                        </select>
                                        <label>California County</label>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="input-field col m6 s12">
                                        <input type="text" id="street" name="street"
                                               value="<?php echo  (isset($error) && !empty($error))?$data->street:"" ?>"
                                               required
                                               class="validate">
                                        <label for="street">Street</label>
                                    </div>

                                    <div class="input-field col m6 s12">
                                        <input type="text" id="zip" name="zipcode"
                                               value="<?php echo  (isset($error) && !empty($error))?$data->zipcode:"" ?>"
                                               required
                                               class="validate">
                                        <label for="zip">zipCode</label>
                                    </div>


                                </div>

                                <div class="row">

                                    <div class="input-field col m12 s12">
                                        <input type="text" id="project" name="post_title"

                                               value="<?php echo  (isset($error) && !empty($error))?$data->post_title:"" ?>"

                                               class="validate mustCounted" data-length="50">
                                        <label for="project">Company or project name</label>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="input-field col s12">
                                        <select id="post_categoryProject" name="categoryProject"
                                                class="validate">

                                            <?php
                                            $settedcat=(isset($error) && !empty($error))?$data->categoryProject:"";
                                            getTermsListSelectWithlastSetValue('categories-project',$settedcat)
                                            ?>
                                        </select>
                                        <label for="post_categoryProject">Categories </label>
                                    </div>
                                </div>


                                <div class="inline clearfix">
                                    <button type="submit" value="Send Messager" class=" main-bg btn-tudigo">Continue
                                    </button>
                                    <p style="text-align: center">Already member? <a href="<?php  echo home_url('project-login')?>">Login</a>
                                    </p>
                                </div>

                                <?php
                            }
                            ?>



                        </form>
                    </div>

                    <div class="col s12 m3"></div>
                </div>


            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
