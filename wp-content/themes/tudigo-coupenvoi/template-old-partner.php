 <?php /* Template Name: Old Partners Template */ get_header(); ?>


 <?php
 global $main_color;
 ?>




 <?php if (have_posts()): while (have_posts()) : the_post(); ?>

     <br>
     <br>
     <br>
     <br>
     <br>



     <?php
     $imgeURL=!empty(get_image_url(get_the_ID(),'full'))?get_image_url(get_the_ID(),'full'):get_field("site_banner_image","option");
     ?>
     <div class=" default-padding-section    " style="background: linear-gradient(
             rgb(0,65,130),
             rgba(0,65,130,0.92)
             ),url(<?php echo $imgeURL?>);
              background-size:cover;">
         <div class="     ">
             <div class="container">
                 <div class="row">
                     <div class="col s12 m6">
                         <div class=" white-color ">
                             <h1><?php echo the_title()?></h1>
                         </div>
                     </div>

                 </div>




             </div>
         </div>


     </div>


     <div class="default-padding-section" style="background-image: url(<?php echo get_template_directory_uri()."/img/background.jpg"?>)">
         <div class="container">
             <div class="row">
                 <div class="col s12 m1"></div>

                 <div class="col s12  m10 content-corver text-center">
                     <?php
                     $defaults = array(
                         'numberposts' => 10,
                         'post_type' => 'partner',
                     );

                     $partners=get_posts($defaults);
                     //    print_r($partners);

                     if(!empty($partners)){
                         foreach ($partners as $partner){
                             $partner=(object)$partner;
                             ?>
                             <div class="">

                                 <div class="card horizontal">
                                     <div class="partner-item-image-corver">
                                         <img src="<?php echo get_image_url($partner->ID,"full")  ?>">
                                     </div>
                                     <div class="card-stacked">
                                         <div class="card-content partner-item-content">
                                             <h3><?php echo $partner->post_title ?></h3>
                                             <br>
                                             <p><?php echo $partner->post_content ?></p>
                                         </div>

                                     </div>
                                 </div>
                             </div>

                             <?php
                         }

                     }
                     ?>




                 </div>
                 <div class="col s12 m1"></div>


             </div>

         </div>


     </div>
     <br>
     <br>


 <?php endwhile; ?>

 <?php else: ?>

     <!-- article -->
     <article>

         <h2><?php _e('Sorry, nothing to display.', 'html5blank'); ?></h2>

     </article>
     <!-- /article -->

 <?php endif; ?>


 <?php get_footer(); ?>
