<?php
/**
 * Created by IntelliJ IDEA.
 * User: georgescress
 * Date: 12/12/2017
 * Time: 12:14
 */

class Votes
{
    private $tableVotes;
    private $dbObject;
    private $totalPostVote;

    function __construct()
    {
        global $wpdb;
        $this->dbObject = $wpdb;

        $this->tableVotes = $wpdb->prefix . 'votes';


    }


    public function storeVote($projectID)
    {
        $score = $this->getPostVotes($projectID);
        if (!empty($score)) {
            $score=$score+1;
            return $this->updateVote($projectID,$score);
        } else {
           return  $this->insertVote($projectID);
        }


    }

    public function getPostVotes($projectID)
    {
        $score = null;
        $resultats = $this->dbObject->get_results("SELECT score    FROM {$this->tableVotes} WHERE projetID=$projectID ");
        if (!empty($resultats)) {
            $result = $resultats[0];
            $score = $result->score;
            return $score;
        }

    }

    public function updateVote($projectID,$score)
    {

        $update = $this->dbObject->update(
            $this->tableVotes,
            [  'score' => $score ],
            ['projetID' => $projectID]
        );
        if ($update) {

            return true;
        }
        return false;
    }

    public function insertVote($projectID)
    {
        $insert = $this->dbObject->insert(
            $this->tableVotes,
            ['projetID' => $projectID,
                'score' => 1
            ]
        );
        if ($insert) {

            return true;
        }
        return false;
    }


}