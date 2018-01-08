<?php
/**
 * Created by PhpStorm.
 * User: georgescress
 * Date: 30/06/2017
 * Time: 22:35
 */
global $candidat;
$candidat = "candidat";
//Acf
if (function_exists('acf_add_options_page')) {
    // Page principale
    $parent = acf_add_options_page(array(
        'page_title' => 'Options',
        'menu_title' => "Options",
        'menu_slug' => 'options-generales',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
    /* acf_add_options_sub_page(array(
         'page_title' => 'Slide',
         'menu_title' => 'Slide',
         'parent_slug' => $parent['menu_slug'],
     ));
     acf_add_options_sub_page(array(
         'page_title' => 'Equipe de  travail',
         'menu_title' => 'Equipe de travail',
         'parent_slug' => $parent['menu_slug'],
     ));*/
}


//  acf function

function get_all_partenaires()
{
    $partenaires = get_field('site_gallery_partenaire', 'option');
    if (!empty($partenaires)):
        foreach ($partenaires as $key => $partenaire_info) :
            $partenaire [] = array(
                'title' => $partenaire_info['title'],
                'url' => $partenaire_info['url'],
                'description' => $partenaire_info['description']
            );
        endforeach;
        unset($partenaires);
        return $partenaire;
    endif;
}

function get_all_rsocial_link()
{
    return (object)array(
        'facebook' => get_field('site_facebook', 'option'),
        'twitter' => get_field('site_twitter', 'option'),
    );
}

function get_all_image()
{
    return array(
        'logo' => get_field('site_logo', 'option'),
        'favicon' => get_field('site_favicon', 'option'),
        'banniere' => get_field('site_banniere', 'option'),
    );
}


function get_all_adresse_info()
{
    return array(
        'adresse' => get_field('site_adresse_physique', 'option'),
        'telephone1' => get_field('site_telephone_1', 'option'),
        'telephone2' => get_field('site_telephone_2', 'option'),
        'mail' => get_field('site_mail', 'option'),
        'longitude' => get_field('site_longitude', 'option'),
        'lattitude' => get_field('site_latitude', 'option'),
    );
}

function get_site_couleurs()
{
    return array(
        'principal' => get_field('site_main_color', 'option'),
        'secondaire' => get_field('site_secondary_color', 'option'),
    );
}

// taille des images

add_image_size('horizontal', 664, 498, true); // Large Thumbnail
add_image_size('vertical', 312, 211, true); // Large Thumbnail
add_image_size('post-image', 570, 350, true); // Large Thumbnail
add_image_size('small-post-image', 350, 228, true); // Large Thumbnail

function get_image_url($postID, $desiredSize)
{
    $thumbnailID = get_post_thumbnail_id($postID);
    return $attachement = wp_get_attachment_image_url($thumbnailID, $desiredSize);


}

function tokenTruncate($string, $your_desired_width)
{
    $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
    $parts_count = count($parts);

    $length = 0;
    $last_part = 0;
    for (; $last_part < $parts_count; ++$last_part) {
        $length += strlen($parts[$last_part]);
        if ($length > $your_desired_width) {
            break;
        }
    }

    return implode(array_slice($parts, 0, $last_part));
}


function footer_nav()
{
    wp_nav_menu(
        array(
            'theme_location' => 'header-menu',
            'menu' => '',
            'container' => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul class="list-inline"">%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        )
    );
}

function changedate($date)
{

    $date = new DateTime($date);
    return $date->format('F j, Y'); // 31.07.2012

}

function changedateWithoutYear($date)
{

    $date = new DateTime($date);
    return $date->format('F j '); // 31.07.2012

}

function getToken()
{
//session_start();

    return $_SESSION['token'];


}

function setToken()
{
    //   session_start();

    $_SESSION['token'] = wp_hash_password(bloginfo("info") . 'tudidoOmeganumericDev');
}

function my_login_redirect($redirect_to, $request, $user)
{
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        //check for admins
        if (in_array('administrator', $user->roles)) {
            // redirect them to the default place
            return $redirect_to;
        } else {
            $role = get_role('candidat');
            $role->remove_cap("delete_others_pages", "delete_others_posts", "delete_pages", "delete_posts");
            return home_url('project-creation');
        }
    } else {
        return $redirect_to;
    }
}

add_filter('login_redirect', 'my_login_redirect', 10, 3);


/*function disable_new_posts()
{
    global $candidat;
    $currentUser = wp_get_current_user();
    $args = array(
        'author' => $currentUser->ID, // user ID here
        'posts_per_page' => -1, // retrieve all
        'post_type' => 'project', // post type (change to your PT)
        'post_status' => 'any' // any status
    );

    $posts = get_posts($args);


      $countUserPost = count($posts);

    if ($currentUser->roles[0] == $candidat && $countUserPost >= 1) {

        // Hide sidebar link
        global $submenu;
        unset($submenu['edit.php?post_type=project'][10]);

// Hide link on listing page
        if (isset($_GET['post_type']) && $_GET['post_type'] == 'project') {
            echo '<style type="text/css">
    #favorite-actions, .add-new-h2, .tablenav ,.page-title-action{ display:none; }
    </style>';
        }
    }


}

add_action('admin_menu', 'disable_new_posts');*/


function applicationCurrentState()
{
    $callforapp = new DateTime(get_post_field("project_call_for_applications", "option"));
    $voting = new DateTime(get_post_field("project_call_for_applications", "option"));
    $results = new DateTime(get_post_field("project_annoncement_result", "option"));
    $today_dt = new DateTime("now");
    $applicationProdeure = 0;
    if ((int)$callforapp->diff($today_dt)->format('%R%a') < 0) {
        $applicationProdeure = 1;
    }
    if ((int)$voting->diff($today_dt)->format('%R%a')) {
        $applicationProdeure = 2;
    }

    if ((int)$results->diff($today_dt)->format('%R%a')) {
        $applicationProdeure = 3;
    }
    return $applicationProdeure;
}

function cleanSpaceAccent($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/', '', $string));
}

function getCountriesList()
{
    // Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://restcountries.eu/rest/v2/all',
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources
    curl_close($curl);
    return json_decode($resp);
}

function getPostTerm($postID, $taxonomies = "category")
{
    $cats = [];
    $categories = get_the_terms($postID, $taxonomies);
    if (!empty($categories)) {
        foreach ($categories as $key => $categorie) {

            $cats = [
                'slug' => $categorie->slug,
                'name' => $categorie->name
            ];
        }

    }

    return $cats;
}

function getPostTermsList($postID, $taxonomies = "category", $linkClass = "", $iconClass = "")
{
    $categories = get_the_terms($postID, $taxonomies);

    if (!empty($categories)) {
        foreach ($categories as $key => $categorie) {

            ?>

            <a class="<?php echo "" ?>" href="<?php echo get_term_link($categorie->term_id) ?>">

                <i class="<?php echo $iconClass ?>"> </i> <?php echo $categorie->name ?>
            </a>

            <?php
        }
    }
}

function getPostTermsListOnlyText($postID, $taxonomies = "category", $linkClass = "", $iconClass = "")
{
    $categories = get_the_terms($postID, $taxonomies);
    $txt = "";
    if (!empty($categories)) {
        foreach ($categories as $key => $categorie) {
            $txt = $categorie->name;

        }
    }
    return $txt;
}

function getTermsList($taxonomies = "category")
{
    $args = ['taxonomy' => $taxonomies,
        'hide_empty' => false];
    $categories = get_terms($args);
    // print_r($categories);
    if (!empty($categories)) {

        foreach ($categories as $key => $categorie) {
            //  print_r($categorie);
            ?>

            <div class="col m3 s6 project-category-item"><a class="main-bg white-color "
                                                            href="<?php echo get_term_link($categorie->term_id) ?>">

                    <?php echo $categorie->name ?>
                </a></div>

            <?php


        }
    }

}


function getTermsListSelect($taxonomies = "category", $cats = [])
{
    $args = ['taxonomy' => $taxonomies,
        'hide_empty' => false];
    $categories = get_terms($args);
    //echo   $slug=$cats=['slug'];
    if (!empty($categories)) {
        foreach ($categories as $key => $categorie) {


            ?>

            <option value="<?php echo $categorie->slug ?>">

                <?php echo $categorie->name ?>
            </option>

            <?php

        }
    }
}

function getTermsListSelectID($taxonomies = "category", $cats = [])
{
    $args = ['taxonomy' => $taxonomies,
        'hide_empty' => false];
    $categories = get_terms($args);
    //echo   $slug=$cats=['slug'];
    if (!empty($categories)) {
        foreach ($categories as $key => $categorie) {


            ?>

            <option value="<?php echo $categorie->term_id ?>">

                <?php echo $categorie->name ?>
            </option>

            <?php

        }
    }
}

function getTermsListSelectWithlastSetValue($taxonomies = "category", $lastsetvalue = "")
{
    $args = ['taxonomy' => $taxonomies,
        'hide_empty' => false];


    $categories = get_terms($args);

    $optionsTags = "";
    $firstoptionTags = "";
    //echo   $slug=$cats=['slug'];
    if (!empty($categories)) {
        foreach ($categories as $key => $categorie) {

            if ($categorie->slug != $lastsetvalue) {
                $optionsTags .= "<option value='$categorie->slug'> $categorie->name  </option> ";
            } else {
                $firstoptionTags .= "<option value='$categorie->slug'> $categorie->name  </option> ";
            }


        }
        echo $firstoptionTags;
        echo $optionsTags;

    }
}

function login_with_email_address(&$username)
{
    $user = get_user_by('email', $username);
    if (!empty($user->user_login))
        $username = $user->user_login;
    return $user;
}

add_action('wp_authenticate', 'login_with_email_address');

/**
 * Programmatically logs a user in
 *
 * @param string $username
 * @return bool True if the login was successful; false if it wasn't
 */
function programmatic_login($username)
{

    if (is_user_logged_in()) {
        wp_logout();
    }

    add_filter('authenticate', 'allow_programmatic_login', 10, 3);    // hook in earlier than other callbacks to short-circuit them
    $user = wp_signon(array('user_login' => $username));
    remove_filter('authenticate', 'allow_programmatic_login', 10, 3);

    if (is_a($user, 'WP_User')) {

        wp_set_current_user($user->ID, $user->user_login);

        if (is_user_logged_in()) {
            return true;
        }
    }

    return false;
}

/**
 * An 'authenticate' filter callback that authenticates the user using only the username.
 *
 * To avoid potential security vulnerabilities, this should only be used in the context of a programmatic login,
 * and unhooked immediately after it fires.
 *
 * @param WP_User $user
 * @param string $username
 * @param string $password
 * @return bool|WP_User a WP_User object if the username matched an existing user, or false if it didn't
 */
function allow_programmatic_login($user, $username, $password)
{
    return get_user_by('login', $username);
}


function generate_Featured_Image($image_url, $post_id)
{
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if (wp_mkdir_p($upload_dir['path'])) $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    $res1 = wp_update_attachment_metadata($attach_id, $attach_data);
    $res2 = set_post_thumbnail($post_id, $attach_id);
}

add_action('pre_get_posts', 'ml_restrict_media_library');

function ml_restrict_media_library($wp_query_obj)
{
    global $current_user, $pagenow;
    if (!is_a($current_user, 'WP_User'))
        return;
    if ('admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments')
        return;
    if (!current_user_can('manage_media_library'))
        $wp_query_obj->set('author', $current_user->ID);
    return;
}


function my_login_logo()
{ ?>
    <style type="text/css">
        body {
            background-image: url(<?php echo   get_template_directory_uri()."/img/background.jpg"?>) !important;
        }

        #wp-submit {
            border-radius: 30px;
            background-color: <?php echo get_field('site_main_color', 'option')  ?> !important;
        }

        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_field("site_logo_application", "option") ?>);
            position: relative;
            top: 43px;
            display: block;
            width: 100px;
            height: 100px;
    </style>
<?php }

add_action('login_enqueue_scripts', 'my_login_logo');


// Save file
function saveFile($fileInputName, $post_id)
{
    if (isset($_FILES[$fileInputName]) && !empty($_FILES[$fileInputName])) {
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'] . "/projectsfiles/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }


        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');

        $extension_upload = strtolower(substr(strrchr($_FILES[$fileInputName]['name'], '.'), 1));
        $fileName = $upload_dir . "featuredImage" . $post_id . "." . $extension_upload;
        if (in_array($extension_upload, $extensions_valides)) {
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $fileName)) {
                echo "The file " . basename($_FILES[$fileInputName]["name"]) . " has been uploaded.";
                generate_Featured_Image($fileName, $post_id);
                return true;
            } else {
                return false;
            }
        }


    } else {
        return false;
    }


}


add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession()
{
    if (!session_id()) {
        session_start();
    }
}

function myEndSession()
{
    session_destroy();
}

// RESTRICT ACCESS TO NOT ADMIN
function custom_remove_no_admin_access()
{
    if (!defined('DOING_AJAX') && !current_user_can('manage_options')) {
        wp_redirect(home_url());
        die();
    }
}

add_action('admin_init', 'custom_remove_no_admin_access', 1);


add_filter('wp_mail_content_type', 'set_html_content_type');


function xyz_filter_wp_mail_from($email)
{

    return trim(get_field("sender_email", "option"));
}

add_filter("wp_mail_from", "xyz_filter_wp_mail_from");

function xyz_filter_wp_mail_from_name($from_name)
{
    return get_bloginfo();
}

add_filter("wp_mail_from_name", "xyz_filter_wp_mail_from_name");

function set_html_content_type()
{
    return 'text/html';
}



function searchTreat($cat, $type, $keyWord)
{
    $posts_array = get_posts(
        array(
            'posts_per_page' => -1,
            'post_type' => 'project',
            'post_title' => "LIKE %$keyWord%",
            'post_content' => "LIKE %$keyWord%",
            'tax_query' => array(
                array(
                    'taxonomy' => 'categories-project',
                    'field' => 'name',
                    'terms' => $cat,
                ),
                array(
                    'taxonomy' => 'type-sonnerie',
                    'field' => 'name',
                    'terms' => $type,
                )
            )
        )
    );

    return $posts_array;
}


function get_replacement($data = [])
{

//        var_dump($data);

    $temp = array(
        '{{first_name}}' => maybe_null_or_empty($data, 'first_name'),
        '{{last_name}}' => maybe_null_or_empty($data, 'last_name'),
        '{{project_title}}' => maybe_null_or_empty($data, 'project_title'),
    );
    if (!empty($additional)) {
        $temp = array_merge($temp, $additional);
    }
    return $temp;

}

function get_message($data = [], $message)
{

    $replacement = get_replacement($data);
    if (isset($replacement) && !empty($replacement)) {
        foreach ($replacement as $key => $replacer) {
            $message = str_replace($key, $replacer, $message);
        }
    }

    return $message;
}

function maybe_null_or_empty($element, $property)
{
    if (is_object($element)) {
        $element = (array)$element;
    }
    if (isset($element[$property])) {
        return $element[$property];
    } else {
        return "";
    }
}

function getFacebookContentOfPost($postID)
{
    $title = get_the_title($postID);
    $city = getPostTermsListOnlyText(get_the_ID(), "categories-project");
    return "$title is an amazing project in $city  that needs our support to win ! Check it out and vote for it if you like it as well !
";
}

// show wp_mail() errors
add_action('wp_mail_failed', 'onMailError', 10, 1);
function onMailError($wp_error)
{
    echo "<pre>";
    print_r($wp_error);
    echo "</pre>";
    die();
}

add_action('phpmailer_init', 'send_smtp_email');
function send_smtp_email($mail)
{
    // var_dump($mail);
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = get_field("sender_smtp", "option");  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = get_field("sender_email", "option");                // SMTP username
        $mail->Password = get_field("sender_password", "option");                               // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = (int)get_field("sender_port", "option");;                                    // TCP port to connect to

        /* //Recipients
         $mail->setFrom('from@example.com', 'Mailer');
         $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
         $mail->addAddress('ellen@example.com');               // Name is optional
         $mail->addReplyTo('info@example.com', 'Information');
         $mail->addCC('cc@example.com');
         $mail->addBCC('bcc@example.com');

         //Attachments
         $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
         $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

         //Content
         $mail->isHTML(true);                                  // Set email format to HTML
         $mail->Subject = 'Here is the subject';
         $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
         $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';*/

        //$mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        //echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
}