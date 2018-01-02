<?php
/**
 * Created by IntelliJ IDEA.
 * User: georgescress
 * Date: 13/12/2017
 * Time: 12:18
 */

class ProjectClasse
{


    public function saveCandidatProject($project)
    {

        $post_id = wp_insert_post($project);
        if ($post_id) {
            return $post_id;
        }
        return null;


    }

    public function setCategorieValueToPost($post_id,$caterogie){
        if(wp_set_object_terms($post_id, $caterogie, 'categories-project')){
            return true;
        }
        return false;

    }

}