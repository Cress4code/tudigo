<?php
/**
 * Created by IntelliJ IDEA.
 * User: georgescress
 * Date: 12/12/2017
 * Time: 12:14
 */

class Candidat
{

    private $email;
    private $password;
    function __construct()
    {




    }

    public function insertCandidat($data){

        if($data['user_pass']==$data['user_pass1']) {
                unset($data['user_pass1']);
                $data["user_login"]=cleanSpaceAccent($data['first_name'].$data['last_name']);
            $data["role"]="candidat";
            $user_id = wp_insert_user($data);
            if ($user_id && !is_wp_error($user_id)) {
                $this->email=$data['user_email'];
                $this->password=$data['user_pass'];
                return $user_id;
            }
        }

        return null;

    }


    public function insertUserMeta($user_id,$userMeta){

            if(add_user_meta($user_id, 'userData', json_encode($userMeta))) {

                return true;
            }
                return false;

    }

    public function signOnUser($email,$password){
       if( wp_signon(array("user_email"=>$email,"user_password"=>$password))){
           return true;
       }
       return false;
    }

    public function signOnUserDefault( ){
        if( wp_signon(array("user_email"=>$this->email,"user_password"=>$this->password))){
            return true;
        }
        return false;
    }
    public function generateConfirmationlink(){

    }

    public function sendConfirmationMail ($email){


        wp_mail($email,"MAIL D'INSCRIPTION","MAIL D'INSCRIPTION");



    }

    public function redirectCandidat(){



        header('location: login-page');
    }









    public  function getCandidatByPostID(){



    }


}