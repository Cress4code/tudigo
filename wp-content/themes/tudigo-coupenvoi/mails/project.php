
<?php
$currentUser=wp_get_current_user();
?>
<!<!DOCTYPE>
<html>
<head>
    <title>

    </title>
    <style>
        body{
            font-family: Helvetica;
        }
        table{
            font-family: Helvetica;
            width: 100%;
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .img-responsive{
            width: 100%
        }
        .tudigo-btn{
            background: #004182;
            color: #FFF;
            padding: 20px 30px;
            border-radius: 30px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            margin: 0 auto;
        }
        .footer{
            padding: 50px 0;
            color: #FFF;
            background: #ff4b68;

        }
        a{
            text-decoration: none;
            color:#FFF
        }
        p{
            padding: 10px 30px;
        }
        td{
            width: 33%;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <td class="text-left"><img style="width: 100px ; " src="<?php echo get_field("site_logo_csudh", "option") ?>"></td>
        <td class="text-center"><img class="img-responsive" src="<?php echo get_field("site_logo_application", "option") ?>"></td>
        <td class="text-right" ><img style="width: 100px ; " src="<?php echo get_field("site_logo_tudigo", "option") ?>"></td>
    </tr>
    <tr>

        <td colspan="3"><img src="<?php echo get_field("site_logo_mail_registration", "option") ?>" class="text-center img-responsive"></td>

    </tr>
    <tr>
        <td colspan="3">

            <p>	Hello <?php echo  $currentUser->first_name.'  '.$currentUser->last_name?>

            </p>
            <?php

            $args = array(
                'post_type' => 'project',
                'post_status' => 'any',
                'posts_per_page' => 1,
                'author' => $currentUser->ID,

            );
            $post=get_posts($args);
            $post=(object)$post[0];


            ?>
            <h3>Project : <?php echo $post->post_title ;?></h3>

            <?php
            echo get_field("mail_submission_text","option")
                ?>



        </td>
    </tr>

    <tr>
        <td colspan="3">

             </td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="text-center footer">

                <p>
                    Thank you .<br>
                    <a href="#">CSUDH</a>
                    <span>&</span>
                    <a href="#">TUDIGO</a>
                </p>
                <br>
            </div>
        </td>


    </tr>

</table>
</body>
</html>