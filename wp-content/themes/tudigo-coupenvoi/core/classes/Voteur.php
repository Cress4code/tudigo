<?php

Class Voteur
{
    const CODESTATUS = "codeStatus";
    const NEWVOTER = 0;
    const HAVEVOTEDTODAY = 1;
    const VOTESAVED = 2;
    const SHAREVOTED = 3;
    const MESSAGE = "message";
    private $tableName;
    private $tableDailyVotes;
    private $dbObject;
    private $formData;


    function __construct()
    {
        add_action('wp_ajax_nopriv_voting_xhr', [$this, 'voting_xhr']);
        add_action('wp_ajax_voting_xhr', [$this, 'voting_xhr']);

       add_action('admin_menu', [$this, 'voterToAdminMenu']);

        global $wpdb;
        $this->dbObject = $wpdb;
        $this->tableName = $wpdb->prefix . 'voters';
        $this->tableDailyVotes = $wpdb->prefix . 'dailyVotes';


    }

    /**
     *
     */
    public function voting_xhr()
    {
        $backData = [CODESTATUS => 0, MESSAGE => MESSAGE];
        if (isset($_POST) && !empty($_POST)) {
            $postField = (object)$_POST;


            $this->formData = $formData = (object)$postField->form_data;

            switch ($postField->custom_action) {
                case "chk":
                    $voter = $this->checkEmailSaved($formData->email);

                    if (!empty($voter)) {
                        $voterTodayVoted = $this->haveVotedToday($voter->ID);

                        if (empty($voterTodayVoted)) {
                            $votesToken = $this->saveDailyVote($this->formData->post_id, $voter->ID);
                            $this->genericSendMail($this->formData->post_id, $voter->email, $votesToken);

                            $tokenLink = get_the_permalink($this->formData->post_id) . '?token=' . $votesToken;
                            $backData = [CODESTATUS => self::VOTESAVED, MESSAGE => "", "TOKENURL" => "$tokenLink"];
                            echo json_encode($backData);
                        } else {
                            $backData = [CODESTATUS => self::HAVEVOTEDTODAY, MESSAGE => "", "ACTIONDOING" => "chk1"];
                            echo json_encode($backData);
                        }


                    } else {
                        $backData = [CODESTATUS => self::NEWVOTER, MESSAGE => "", "ACTIONDOING" => "chk"];
                        echo json_encode($backData);
                    }
                    break;


                case "sve":
                    $voterID = $this->saveVoter($formData);
                    if (!empty($voterID)) {

                        $votesToken = $this->saveDailyVote($this->formData->post_id, $voterID);
                        $this->genericSendMail($this->formData->post_id, $this->formData->email, $votesToken);
                        $tokenLink = get_the_permalink($this->formData->post_id) . '?token=' . $votesToken;
                        $backData = [CODESTATUS => self::VOTESAVED, MESSAGE => "", "TOKENURL" => "$tokenLink"];
                        echo json_encode($backData);
                    }


                    break;
                case "share":
                    $votes=new Votes();
                    $ishared=$votes->storeVote($this->formData->projectID);
                    if($ishared){
                        $backData = [CODESTATUS =>self::SHAREVOTED, MESSAGE => ""];
                        echo json_encode($backData);


                    }
                    break;
                case "facebook_user":

                    $voter = $this->checkEmailSaved($formData->email);

                    if (!empty($voter)) {
                        $voterTodayVoted = $this->haveVotedToday($voter->ID);

                        if (empty($voterTodayVoted)) {
                            $votesToken = $this->saveDailyVote($this->formData->post_id, $voter->ID);
                            $this->genericSendMail($this->formData->post_id, $voter->email, $votesToken);
                            $tokenLink = get_the_permalink($this->formData->post_id) . '?token=' . $votesToken;
                            $backData = [CODESTATUS => self::VOTESAVED, MESSAGE => "", "TOKENURL" => "$tokenLink"];
                            echo json_encode($backData);
                        } else {
                            $backData = [CODESTATUS => self::HAVEVOTEDTODAY, MESSAGE => "", "ACTIONDOING" => "voted"];
                            echo json_encode($backData);
                        }


                    } else {
                        $voterID = $this->saveVoter($formData);
                        if (!empty($voterID)) {

                            $votesToken = $this->saveDailyVote($this->formData->post_id, $voterID);
                            $isSent=$this->genericSendMail($this->formData->post_id, $this->formData->email, $votesToken);
                            if($isSent==true){
                                $tokenLink = get_the_permalink($this->formData->post_id) . '?token=' . $votesToken;
                                $backData = [CODESTATUS => self::VOTESAVED, MESSAGE => "", "TOKENURL" => "$tokenLink"];
                                echo json_encode($backData);
                            }else{

                            }

                        }
                    }

                    break;

                default:
                    $backData = [CODESTATUS => 0, MESSAGE => ""];
                    echo json_encode($backData);

            }

            wp_die();
        }
    }

    public function checkEmailSaved($email)
    {
        $resultats = [];
        $resultats = $this->dbObject->get_results("SELECT * FROM {$this->tableName} WHERE email='$email'");
        if (!empty($resultats)) {
            return $resultats[0];
        }
        return $resultats;

    }

    public function haveVotedToday($voterID)
    {

        $resultats = [];
        $resultats = $this->dbObject->get_results("SELECT ID FROM {$this->tableDailyVotes} WHERE voterID=voterID AND DATE(dateVotes) = CURDATE()");
        if (!empty($resultats)) {
            return $resultats[0];
        }
        return $resultats;
    }

    public function saveDailyVote($post_ID, $voter_ID)
    {
        $tokenVotes = uniqid();
        $insert = $this->dbObject->insert(
            $this->tableDailyVotes,
            array(
                'projetID' => $post_ID,
                'voterID' => $voter_ID,
                'tokenVotes' => $tokenVotes

            )
        );
        if ($insert) {

            return $tokenVotes;
        }
        return null;

    }

    public function genericSendMail($post_ID, $email, $token)
    {


        if (!empty($token)) {

            $message = $this->getStandardMailMessage($post_ID,$token);
                $isSent=$this->sendMail($email, "VOTING CONFIRMATION LINK", $message);
                if($isSent==true){
                    return true;
                }else{
                    return false;
                }
        }
    }

    public function getStandardMailMessage($post_ID,$token)
    {
        global  $tokenUrl;
        global  $voter;

        $tokenLink = get_the_permalink($post_ID) . '?token=' . $token;
        $tokenUrl=$tokenLink;

        $userinfo=($this->getVoterInfoFromToken($token));
        $userinfo=(array)$userinfo[0];

        $voter["last_name"] =$userinfo['nom'];
        $voter["first_name"]=$userinfo['prenom'] ;
        $voter["project_title"]=get_the_title($post_ID) ;

        get_template_part('mails/voting-part-one');
        $message = ob_get_contents();
      ob_end_clean();
       //"Lien de confitmation <a href='$tokenlink'> $tokenlink </a>";
        return $message;

    }

    public function sendMail($email, $subject, $messages)
    {
        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
        $email = wp_mail($email, $subject, $messages);
        remove_filter('wp_mail_content_type', 'set_html_content_type');
        if($email){
            return true;
        }else{

            return false;
        }

    }

    public function saveVoter($formData)
    {
        $formData = (object)$formData;

        $insert = $this->dbObject->insert(
            $this->tableName,
            array(
                'email' => $formData->email,
                'nom' => $formData->nom,
                'prenom' => $formData->prenom,
                'datedenaissance' => $formData->datedenaissance,
                'zipCode' => $formData->zipCode,

            )
        );
        if ($insert) {


            return $this->dbObject->insert_id;
        }
        return null;


    }

    public function updateVoterData($email)
    {

        $insert = $this->dbObject->insert(
            $this->tableName,
            array(
                'email' => $email,
                //'datedenaissance' => date("Y-m-d"),

            )
        );
       // print_r($insert);
        if ($insert) {

            $backData = [CODESTATUS => 0, MESSAGE => "", "VOTER" => ""];
            echo wp_json_encode($backData);
        }
        return false;


    }

    public function voterToAdminMenu()
    {
        add_menu_page(
            __('Project Voters', 'textdomain'),
            'Voters',
            'manage_options',
            'voters',
            [$this, "votersMenuPage"],
            "dashicons-groups",
            10
        );
    }

    public function votersMenuPage()
    {
        $myListTable = new TableList();
        $myListTable->prepare_items();
        echo '</pre><div class="wrap"><h2>Voter of Projects</h2>';
        echo '<form method="post">';
       echo ' <input type="hidden" name="page" value="voters">';

    //$myListTable->search_box( 'search', 'search_id' );

    $myListTable->display();
    echo '</form></div>';
    }

    public function getVoterList(){
        global  $wpdb;
        $tableName=$wpdb->prefix.'voters';
        $voters= $wpdb->get_results("SELECT * FROM  $tableName");
        return $voters;
    }


    function getVoterInfoFromToken($token){
        $resultats = $this->dbObject->get_results("SELECT *   FROM {$this->tableDailyVotes} , {$this->tableName}  WHERE {$this->tableName}.ID={$this->tableDailyVotes}.voterID AND {$this->tableDailyVotes}.tokenVotes='$token'");
      return $resultats;
    }





}

new Voteur();
