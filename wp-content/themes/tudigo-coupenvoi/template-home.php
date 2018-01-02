<?php /* Template Name: Home */
get_header(); ?>


<?php
global $activePhase;
 switch ($activePhase){
     case 0:
         get_template_part('phases/phase-one');
         break;
     case 1:
         get_template_part('phases/phase-two');
         break;
     case 2:
         get_template_part('phases/phase-three');
         break;
 }

?>

<?php get_footer() ?>