<?php

class Project {

    public $post_type_name;
    public $post_type_single;
    public $post_type_plural;
    public $post_type_slug;

    function __construct() {
        add_action('init', array($this, 'init'));

        add_filter("manage_project_posts_columns", array($this, 'post_columns'));
        add_action("manage_project_posts_custom_column", array($this, 'render_post_columns'), 2);

        add_filter('post_updated_messages', array($this, 'post_updated_messages'));
    }

    function post_row_actions_project($actions) {
        if (get_post_type() === $this->post_type_name) {
            return array();
        }
        return $actions;
    }

    public function set_propriety() {
        $classname = strtolower(get_class());
        $this->post_type_name = $classname;
        $this->post_type_single = ucfirst($classname);
        $this->post_type_plural = ucfirst($classname) . "s";
        $this->post_type_slug = $classname;
    }

    function init() {
        $this->set_propriety();

        $this->register_the_post_type();
    }

    function register_the_post_type() {
        $labels = array(
            'name' => $this->post_type_plural,
            'singular_name' => $this->post_type_single,
            'menu_name' => $this->post_type_plural,
            'name_admin_bar' => $this->post_type_single,
            'add_new' => 'Nouveau',
            'add_new_item' => "Ajouter une nouvelle $this->post_type_slug",
            'new_item' => "Nouvelle $this->post_type_single",
            'edit_item' => $this->post_type_single,
            'view_item' => 'Afficher ' . $this->post_type_single,
            'all_items' => 'Toutes les  catégories de ' . $this->post_type_plural,
            'search_items' => 'Rechercher un ' . $this->post_type_single,
            'not_found' => "Aucun $this->post_type_single trouvé",
            'not_found_in_trash' => "Aucun $this->post_type_single trouvé dans la corbeille."
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon'   => 'dashicons-lightbulb',
            "supports" => array('title', 'thumbnail', 'editor','excerpt'),
            'query_var' => true,
            'rewrite' => array('slug' => "/" . $this->post_type_name, "feeds" => false),
            'hierarchical' => true,
            //'capability_type' => $this->post_type_name,

        );
        flush_rewrite_rules();
        register_post_type($this->post_type_name, $args);
        $this->register_taxonomies();
    }

    function register_taxonomies() {
        register_taxonomy(
            'categories-' . $this->post_type_name, array($this->post_type_name), array(
                'label' => __("Categories"),
                'rewrite' => array('slug' => 'categories-' . $this->post_type_name),
                'hierarchical' => true,
                'show_admin_column' => true,
            )
        );
        register_taxonomy(
            'states-' . $this->post_type_name, array($this->post_type_name), array(
                'label' => __("California counties or cities "),
                'rewrite' => array('slug' => 'states-' . $this->post_type_name),
                'hierarchical' => true,
                'show_admin_column' => true,
            )
        );

    }

    public function render_post_columns($column) {
        global $post;
        switch ($column) {
            case 'author':
                echo  get_the_author_lastname();
                break;
            case 'vote':
                $votes= new Votes();
                $votesC=$votes->getPostVotes($post->ID);
                echo  !empty($votesC)?$votesC:0;
                break;

            case 'image':
                echo '<img src="' . wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), 'thumbnail') . '" alt="" width="50" height="50">';
                break;
        }
    }

    public function post_columns($existing_columns) {
        if (empty($existing_columns) && !is_array($existing_columns)) {
            $existing_columns = array();
            unset($existing_columns);
        }
        unset($existing_columns['date']);

        $columns['image'] = "Image";
        $columns['author'] = "Author";

        $columns['vote'] = "Vote";
        $columns['date'] = "Date";
        return array_merge($existing_columns, $columns);
    }

    function post_updated_messages() {
        global $post, $post_ID;
        $messages[$this->post_type_slug] = array(
            0 => '',
            1 => sprintf(__($this->post_type_single . ' mise à jour. <a href="%s">Afficher le ' . $this->post_type_single . '</a>', 'woocommerce'), esc_url(get_permalink($post_ID))),
            2 => 'Informations mises à jour.',
            3 => 'Informations mises à jour.',
            4 => $this->post_type_single . 'mis à jour.',
            5 => isset($_GET['revision']) ? sprintf('' . $this->post_type_name . ' restauré de revision from %s', wp_post_revision_title((int) $_GET['revision'], false)) : false,
            6 => sprintf('' . $this->post_type_name . ' publiée. <a href="%s">Afficher ' . $this->post_type_name . '</a>', esc_url(get_permalink($post_ID))),
            7 => '' . $this->post_type_name . ' enregistré.',
            8 => sprintf('' . $this->post_type_name . ' envoyé. <a target="_blank" href="%s">Afficher Restaurant</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
            9 => sprintf('' . $this->post_type_name . ' planifié pour : <strong>%1$s</strong>. <a target="_blank" href="%2$s">Afficher ' . $this->post_type_name . '</a>', date_i18n(__('M j, Y @ G:i', 'woocommerce'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
            10 => sprintf('Brouillon ' . $this->post_type_name . ' mis à jour . <a target="_blank" href="%s">Afficher ' . $this->post_type_name . '</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        );
        return $messages;
    }

}

new Project();
?>
