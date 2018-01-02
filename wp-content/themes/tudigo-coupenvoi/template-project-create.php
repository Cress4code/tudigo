
<?php /* Template Name: Project Creation */
get_header(); ?>
<?php
global $activePhase;

 if($activePhase >= 1){
    wp_redirect(home_url());
}
?>
<?php
if (is_user_logged_in()) {

    $user_id = get_current_user_id();
    //print_r(wp_get_current_user()); die();


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
    }

    $terms=wp_get_post_terms($posts->ID,'categories-project' );
    $terms=$terms[0];


} else {
    wp_redirect(home_url('project-login'));
}


if (isset($_POST) && !empty($_POST)) {
    $data=(object)$_POST;

    $defaults = array(
        'ID'           => $posts->ID,
        'post_title' => $data->post_title,
        'post_excerpt' => $data->post_excerpt,
        'post_type' => 'project',
        'post_author' => $user_id ,

    );

    $post_id = wp_update_post($defaults);


    if (isset($_FILES['featuredImage']) && !empty($_FILES)) {
        $upload_dir = wp_upload_dir();
        $upload_dir=$upload_dir['basedir']."/projectsfiles/";
        if(!file_exists($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }


        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');

        $extension_upload = strtolower(substr(strrchr($_FILES['featuredImage']['name'], '.'), 1));
        $fileName=$upload_dir."featuredImage".$post_id.".".$extension_upload;
        if (in_array($extension_upload, $extensions_valides)) {
            if (move_uploaded_file($_FILES["featuredImage"]["tmp_name"], $fileName )) {
                echo "The file " . basename($_FILES["featuredImage"]["name"]) . " has been uploaded.";
                generate_Featured_Image( $fileName,   $post_id );

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }



    }

    wp_set_object_terms($post_id, $data->post_categoryProject, 'categories-project');

    wp_redirect(home_url("/project-suite/"));



}
?>
<div class=" default-padding-section" style="background: url(<?php echo get_template_directory_uri()."/img/background.jpg"?>); ">
    <div class="content">

        <div class=" " >
            <br>
            <br>
            <br>
            <br>
        <h3 class="title-3 text-center">
                    Project creation
                </h3>
            <br>
            <br>
            <br>

            <div class="row">
                <div class="col s12 m3"></div>
                <div class="col s12 m6">

                    <form class="white-bg form-corver"method="post" action="#" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="post_title" type="text" class="validate"
                                       value="<?php echo isset($posts->post_title) ? $posts->post_title : ""; ?>"
                                       name="post_title">

                                <label for="post_title">Your company or project name </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="input-field col s12">

                                <textarea rows="4" class="materialize-textarea" id="excerpt" class="validate mustCounted" data-length="150" required
                                          name="post_excerpt"><?php echo isset($posts->ID) ? $posts->post_excerpt : ""; ?></textarea>

                                <label for="excerpt">Project short description </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">

                                <select id="post_categoryProject" name="post_categoryProject" class="validate"
                                        required="required">

                                    <?php
                                    $settedcat=(isset($error) && !empty($error))?$terms->categoryProject:$terms->slug;
                                    getTermsListSelectWithlastSetValue('categories-project',$settedcat)
                                    ?>
                                </select>
                                <label for="post_categoryProject">Categories  </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <?php $imageUle= isset($posts->ID) ? get_image_url($posts->ID, "full") : "" ?>
                                <input type="file" id="file" name="featuredImage" class="dropify" data-min-height="350" <?php echo empty($imageUle) ? "required" : "" ?> class="validate"
                                       data-min-width="400"
                                       data-default-file="<?php echo isset($posts->ID) ? get_image_url($posts->ID, "full") : "" ?>"/>

                                <label for="file">Project main picture (min: 400 X 350)</label>
                            </div>
                        </div>


                        <div class="inline clearfix">
                            <button type="submit" value="Send Messager" class=" main-bg btn-tudigo">Continue</button>
                        </div>

                    </form>
                </div>
                <div class="col s12 m3"></div>

            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
