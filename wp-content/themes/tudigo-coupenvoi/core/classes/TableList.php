<?php
/**
 * Created by IntelliJ IDEA.
 * User: georgescress
 * Date: 26/12/2017
 * Time: 13:00
 */

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class TableList extends WP_List_Table
{


    private $votersListData;

    public function __construct($args = array())
    {
        parent::__construct(array(
            'singular' => __('voter', 'mylisttable'),     //singular name of the listed records
            'plural' => __('voters', 'mylisttable'),   //plural name of the listed records
            'ajax' => false        //does this table support ajax?

        ));
    }

    /**
     * @return mixed
     */
    public function getVotersListData()
    {
        return $this->votersListData;
    }

    /**
     * @param mixed $votersListData
     */
    public function setVotersListData($votersListData)
    {
        $this->votersListData = $votersListData;
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array('ID');
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $data = $this->getVoterList();
        usort($data, array(&$this, 'usort_reorder'));

        //$per_page = 5;
        //$current_page = $this->get_pagenum();
        //$total_items = count($data);

        // only ncessary because we have sample data
        //  $this->found_data = array_slice( $this->example_data,( ( $current_page-1 )* $per_page ), $per_page );
        /*
                $this->set_pagination_args(array(
                    'total_items' => $total_items,                  //WE have to calculate the total number of items
                    'per_page' => $per_page                     //WE have to determine how many items to show on a page
                ));*/

        $this->process_bulk_action();
        $this->items = $data;

    }

    public function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'email' => 'Email',
            'prenom' => 'First Name',
            'nom' => 'Last Name',
            'datedenaissance' => 'Birthday',
            'zipCode' => 'zipCode'
        );
        return $columns;
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'email' => array('email', false),
            'prenom' => array('prenom', false),
            'nom' => array('nom', false),
            'datedenaissance' => array('datedenaissance', false),
            'zipCode' => array('zipCode', false)
        );
        return $sortable_columns;
    }

    public function getVoterList()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . 'voters';
        $voters = [];
        $datas = $wpdb->get_results("SELECT * FROM  $tableName");
        foreach ($datas as $data) {
            $voters[] = (array)$data;
        }
        return $voters;
    }

    public function process_bulk_action()
    {

        // security check!
        if (isset($_POST['_wpnonce']) && !empty($_POST['_wpnonce'])) {

            $nonce = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
            $action = 'bulk-' . $this->_args['plural'];

            if (!wp_verify_nonce($nonce, $action))
                wp_die('Nope! Security check failed!');

        }

        $action = $this->current_action();

        switch ($action) {

            case 'delete':
                print_r($_POST);
                wp_die('Delete something');
                break;

            case 'email':
                ?>

                <?php

                wp_die('CSV something');
                break;


            default:
                // do nothing or something else
                return;
                break;
        }

        return;
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'email':
            case 'prenom':
            case 'nom':
            case 'datedenaissance':
            case 'zipCode':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    /* function column_email($item)
     {
         $actions = array(
             'edit' => sprintf('<a href="?page=%s&action=%s&ID=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['ID']),
             'delete' => sprintf('<a href="?page=%s&action=%s&ID=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['ID']),
         );

         return sprintf('%1$s %2$s', $item['email'], $this->row_actions($actions));
     }*/

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="voters[]" value="%s" />', $item['ID']
        );
    }

    public function get_bulk_actions()
    {
        $actions = array(
            'delete' => __('Delete', 'your-textdomain'),
            'email' => __('Send Mail', 'your-textdomain'),

        );
        return $actions;
    }

    function usort_reorder($a, $b)
    {
        // If no sort, default to title
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'email';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
        // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }


}