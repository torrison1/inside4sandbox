<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Content extends BaseController {

    var $blog;

    public function __construct(){
        $this->blog = new \Inside4\Blog\Blog();
        parent::__construct();
    }

    public function index()
    {
        $redirect_link = $GLOBALS['inside4']['translate']['uri_prefix'].'/content/plist';
        $this->website->redirect_301($redirect_link);
    }

    public function plist($page = 0){

        $redirect_link = $GLOBALS['inside4']['translate']['uri_prefix'].'/content/plist';
        if ($page == 1) $this->website->redirect_301($redirect_link);
        if ($page < 1) $page = 1;

        $this->data['catalog_tree'] = $this->commons->make_tree_view($this->blog->get_tree_categories_arr(), false, $GLOBALS['inside4']['translate']['uri_prefix']);

        $this->data['tags_arr'] = $this->blog->get_tags_list();
        $this->data['content_tags_arr'] = $this->blog->get_content_tags_arr();
        $this->data['content_categories_arr'] = $this->blog->get_content_categories_arr();

        $config['base_url'] = '/content/plist/';
        $config['total_rows'] = $this->blog->pages_count();

        $config['uri_segment'] = 3;
        $config['per_page'] = $this->blog->per_page();
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '';
        $config['full_tag_close'] = '';
        $config['next_link'] = ' &#8594;';
        $config['next_tag_open'] = '<div class="page-navigation">';
        $config['next_tag_close'] = '</div>';
        $config['prev_link'] = '&#8592; ';
        $config['prev_tag_open'] = '<div class="page-navigation">';
        $config['prev_tag_close'] = '</div>';
        $config['num_tag_open'] = '<div class="page-navigation">';
        $config['num_tag_close'] = '</div>';
        $config['first_tag_open'] = '<div class="page-navigation">';
        $config['first_tag_close'] = '</div>';
        $config['last_tag_open'] = '<div class="page-navigation">';
        $config['last_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="page-navigation active">';
        $config['cur_tag_close'] = '</div>';

        $this->data['pagination'] = $this->blog->pagination($config);

        $this->data['pages_list_arr'] = $this->blog->pages_list($page, $this->blog->per_page());

        // Pages List
        $this->view->render($this->data,'Content/pages_list', 'app_default_template');
    }

    public function al(){

        // Page
        $this->view->render($this->data,'Content/page', 'app_default_template');
    }

    public function contacts(){

        // Page
        $this->view->render($this->data,'Content/contacts', 'app_default_template');
    }

}