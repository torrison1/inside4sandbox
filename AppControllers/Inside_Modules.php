<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Inside_Modules extends BaseController
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

    //i--- AJAX API for HTML of Module Info Block ; inside_modules_system ; torrison ; 01.05.2020 ; 2 ---/
    public function module_info() {

        $modules_system = new \Inside4\InsideTools\InsideModularSystem;

        $modules_system->db =& $this->db;
        $modules_system->view =& $this->view;
        echo $modules_system->module_info($this->input->get_secure('system_name'));
    }

    //i--- AModule Easy Page ; inside_modules_system ; torrison ; 01.05.2020 ; 2a ---/
    public function module() {

        $modules_system = new \Inside4\InsideTools\InsideModularSystem;

        $modules_system->db =& $this->db;
        $modules_system->view =& $this->view;

        $this->data['content'] = '';
        $system_names = $this->input->get_secure('system_name');
        $system_names = explode(', ', $system_names);
        foreach ($system_names as $system_name) {
            $this->data['content'] .= $modules_system->module_info($system_name);
        }


        $this->view->render($this->data,'admin_page', 'inside_admin_template');
    }

    //i--- >> TO DO >> Refresh Modules Info API Link ; inside_modules_system ; torrison ; 01.05.2020 ; 3 ---/
    public function refresh_modules_data() {

        $modules_system = new \Inside4\InsideTools\InsideModularSystem;
        $modules_system->db =& $this->db;

        $modules_arr = $modules_system->get_modules_arr();

        foreach ($modules_arr as $module) {
            ?>

            <b><?=$module['name']?> : <?=$module['system_name']?> </b><br>

            <?php
        }
        $modules_system->db =& $this->db;

        $modules_system->check_update_modules_files_relations();
        $modules_system->check_update_modules_database_relations();

    }


    public function modules_from_xml() {
        // echo __DIR__;

        $xml_string = file_get_contents(__DIR__.'/../xTMP/modules.xml');
        $xml = simplexml_load_string($xml_string);
        $this->response->echo_json($xml);
    }
    public function modules() {

        // Modules : Files - Blocks, Tables Columns, Dependencies - Modules, Links - Interfaces, API Docs, Documents, Help Info Links

        // TO DO
        $res['modules'] = Array(
            Array(
                'id' => 1,
                'name' => 'Inside Enter Point : index.php',
                'files' => Array(
                    Array(
                        'path' => 'index.php',
                        'info' => 'Enter Point',

                        'blocks' => Array(
                            Array(
                                'block_id' => '1',
                                'block_name' => 'Show ALL Errors',
                                'block_code' => 'error_reporting( E_ALL );',
                                'block_info' => 'Can be set in php.ini',
                                'advanced' => 'Need to Comment in PROD Mode',
                            )
                        )
                    )
                )
            ),
            Array(
                'id' => 2, 'name' => 'Inside Default Files',
                'files' => Array(
                    Array('path' => 'config.php', 'info' => 'Main Config file. if it not exists, you need to copy from config_default.php'),
                    Array('path' => 'config_default.php', 'info' => 'Default Config file example. if config.php is not exists, you need to copy from config_default.php'),

                )
            ),
            Array('id' => 3, 'name' => 'Inside Globals Class'),
            Array('id' => 4, 'name' => 'Inside Routing Class'),
            Array('id' => 5, 'name' => 'Inside Base Controller Class'),

        );

        $this->response->echo_json($res);
    }

    //i--- >> TO DO >> XML Modules System (New) ; inside_modules_system ; torrison ; 01.05.2020 ; 4 ---/
    public function generate_modules_xml() {

        // - Modules List : table => inside_modules { id, name, info_html, img, etc. }
        // - Modules Dependencies : table => inside_modules_dependencies { id, module_id, dependency_module_id }

        // - Modules Folders : table => inside_modules_folders { id, module_id, folder_path }

        // Foreach Modules
        // Add Dependencies Lists
        // Show Blocks and Info

        // Check ALL files and blocks (ADD Files, ADD Blocks)
        // In Project Files
        // Blocks/File : Status / Costs / Manager / Developer / ...

        // Check ALL Tables and Columns (ADD Tables, Columns)
        // In Data Base : Table/Column Status / Costs / Manager / Developer / ...


        // Check ALL Files and Folders
        // Check ALL Tables and Columns

    }

}