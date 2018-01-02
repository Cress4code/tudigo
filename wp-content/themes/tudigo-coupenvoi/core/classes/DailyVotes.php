<?php

Class DailyVotes
{
    private $tableDailyVotes;
    private $dbObject;
    private $totalPostVote;

    function __construct()
    {
        global $wpdb;
        $this->dbObject = $wpdb;

        $this->tableDailyVotes = $wpdb->prefix . 'dailyVotes';


    }

    /**
     * @return mixed
     */
    public function getTotalPostVote()
    {
        return $this->totalPostVote;
    }

    /**
     * @param mixed $totalPostVote
     */
    public function setTotalPostVote($totalPostVote)
    {
        $this->totalPostVote = $totalPostVote;
    }


    public function getPostVotes($postID)
    {

        $resultats = $this->dbObject->get_results("SELECT count(*) as totalPostVote FROM {$this->tableDailyVotes} WHERE projetID=$postID AND tokenValidate=1 ");
        if (!empty($resultats)) {
            $result = $resultats[0];
        }
        return $result->totalPostVote;
    }


    public function validateToken($token)
    {

        $resultats = $this->dbObject->get_results("SELECT *   FROM {$this->tableDailyVotes} WHERE tokenVotes='$token'");
        if (!empty($resultats)) {
            $result = $resultats[0];
            if (!$result->tokenValidate == 1) {
                $update = $this->dbObject->update(
                    $this->tableDailyVotes,
                    ['tokenValidate' => 1],
                    ['ID' => $result->ID]
                );

                if ($update) {
                    return true;
                }

            }


        }

        return false;

    }


}

