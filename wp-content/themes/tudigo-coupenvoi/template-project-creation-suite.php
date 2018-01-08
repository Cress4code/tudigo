



<?php /* Template Name: Project Creation suite*/
get_header(); ?>
<?php

global $activePhase;
if($activePhase >= 1){
    wp_redirect(home_url());
}

if (is_user_logged_in()) {
    $user_id = get_current_user_id();

    $args = array(
        'post_type' => 'project',
        'post_status' => 'any',
        'posts_per_page' => 1,
        'author' => $user_id,

    );

    $wp_query = new WP_Query($args);
    $posts = $wp_query->get_posts();

    if (!empty($posts)) {
        $posts = (object)$wp_query->get_posts()[0];
        //print_r($posts);
    } else {
        wp_redirect(home_url('project-creation'));
    }


} else {
    wp_redirect(home_url('project-login'));
}


if (isset($_POST) && !empty($_POST)) {
    $rsocial = (object)$_POST['rsocial'];
    $data = (object)$_POST;
       echo  $postStatus=(isset($data->canPublish))?"publish":"draft";

    $defaults = array(


        'ID' => $posts->ID,

        'post_status' => $postStatus,

        'post_content' => $data->post_content,
        'post_type' => 'project',

    );

    $projectId=wp_update_post($defaults, false);


if ($postStatus==="publish")
{
    //wp_mail("cressblaz@gmail.com","Published Project","Salut");

    $currentusert=wp_get_current_user();

    ob_start();
    get_template_part("mails/project");
    $message = ob_get_contents();
    ob_end_clean();
   if( wp_mail($currentusert->user_email,"Published Project",$message)){
       echo "success";

   }else{
      // die();
   }


}else{
    echo "erreur";
    //die();
}
    if (!add_post_meta($posts->ID, 'rssocial-youtube', $rsocial->post_youtube, true)) {
        update_post_meta($posts->ID, 'rssocial-youtube', $rsocial->post_youtube);
    }


    if (!add_post_meta($posts->ID, 'rssocial-facebook', $rsocial->post_facebook, true)) {
        update_post_meta($posts->ID, 'rssocial-facebook', $rsocial->post_facebook);
    }

    wp_redirect(home_url("/project-suite/"));


}

//die();
?>

<div class=" default-padding-section"
     style="background: url(<?php echo get_template_directory_uri() . "/img/background.jpg" ?>); ">
    <div class=" ">

        <div class=" ">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <h3 class="title-3 main-color text-center">
              Content of project
            </h3>
            <br>
            <br>

            <div class="row">
                <div class="col s12 m3"></div>
                <div class="col s12 m6">
                    <?php
                    if ( $posts->post_status== "publish") {
                        ?>
                        <div class="row">
                            <div class="col s12">
                                <div class="  white-color  succes section" style=" background-color: #4caf50">
                                    <p class="text-center">

                                        Your project is well updated and published.<br><br>
                                        You can update it when you want before the call for application deadline.<br><br>
                                        <a class=" white-bg btn-tudigo main-color"
                                           href="<?php echo get_the_permalink($posts->ID)?>">
                                            Preview
                                        </a>

                                    </p>


                                </div>

                            </div>

                        </div>
                        <?php

                    }
                    ?>

                    <form class="white-bg form-corver" method="post" action="#" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="url"
                                       value="<?php echo get_post_meta($posts->ID, 'rssocial-youtube',true) ; ?>"
                                       name="rsocial[post_youtube]" placeholder="Votre lien youtube">
                                <label for="post_title"> Youtube Link</label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="input-field col s12">

                                <input type="url"
                                       value="<?php echo get_post_meta($posts->ID, 'rssocial-facebook',true) ; ?>"
                                       name="rsocial[post_facebook]" placeholder="Votre lien facebook">
                                <label for="excerpt"> Facebook Link</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <?php $content = isset($posts->post_content) ? $posts->post_content : ""; ?>
                                <?php wp_editor($content, "post_content", $settings = array(
                                    'editor_height' => 500,
                                    'textarea_rows' => 20
                                ));
                                ?>
                                <label for="post_categoryProject">Content </label>
                            </div>
                        </div>


                        <div class="inline clearfix">
                            <?php $content = isset($posts->post_content) ? $posts->post_content : "";?>
                            <?php
                             echo  (!empty($content))?"<input type='hidden' name='canPublish' value='true' />" :"";
                            ?>
                            <button type="submit" value="Send Messager" class=" main-bg btn-tudigo">Save  <?php echo  (!empty($content))?"&  Publish":""; ?></button>

                            <?php
                            if (!empty($content)) {
                                ?>

                                <a href="<?php echo get_the_permalink($posts->ID) ?>" class=" second-bg btn-tudigo">
                                    Preview</a>
                                <?php
                            }
                            ?>

                        </div>

                    </form>
                </div>
                <div class="col s12 m3"></div>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
