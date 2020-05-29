<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Inside extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        $admin_system = new \Inside4\InsideAdminSystem\InsideAdminSystem;
        $admin_system->init();

        $this->data['top_menu'] = 'MENU';
        $this->data['menu_arr'] = $admin_system->get_top_menu_arr();
        $this->data['top_menu'] = $this->view->render_to_var($this->data, 'Parts/inside_menu.php', $template_folder = 'inside_admin_template');
    }


    public function index() {
        $this->website->redirect_refresh('/inside/admin');
    }

    //i--- Main Page of Admin Table with Modular System Table ; inside_admin ; torrison ; 01.05.2020 ; 1 ---/
    public function admin() {

        // Admin Panel
        $this->data['admin_interface_name'] = 'Welcome to Inside!';

        $modules_system = new \Inside4\InsideTools\InsideModularSystem;
        $modules_system->db =& $this->db;
        $this->data['modules_arr'] = $modules_system->get_modules_arr();

        // Other HTML Template
        $this->view->render($this->data,'admin_main', 'inside_admin_template');
    }


    public function menu_tree() {

        $this->data['admin_interface_name'] = 'Full Menu';

        $this->data['data'] = $this->data['top_menu'];

        $this->data['seo_title'] = 'Menu tree';

        $this->view->render($this->data,'menu_tree', 'inside_admin_template');

    }


    //i--- Show Database Method ; inside_admin ; torrison ; 01.05.2020 ; 5 ---/
    public function database() {

        $this->data['admin_interface_name'] = 'DB and Admin Tables';

        // if Admin Check ( TO DO )
        $obj = new \Inside4\InsideTools\InsideDatabaseView;
        $obj->db =& $this->db;
        $this->data['content'] = $obj->view();
        $this->view->render($this->data,'admin_page', 'inside_admin_template');

    }

    //i--- Show Project Files Method ; inside_admin ; torrison ; 01.05.2020 ; 6 ---/
    public function projectfiles() {

        $this->data['admin_interface_name'] = 'Files View';

        // if Admin Check ( TO DO )

        $obj = new \Inside4\InsideTools\InsideProjectFiles;
        $this->data['content'] = $obj->view();
        $this->view->render($this->data,'admin_page', 'inside_admin_template');
    }

    // OLD
    public function table($table_name) {

        $this->website->redirect_refresh('/inside_AT/table/'.$table_name);

    }
}