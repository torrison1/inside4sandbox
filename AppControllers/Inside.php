<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;
use stdClass;

Class Inside extends BaseController
{

    public function menu_tree()
    {

    }

    public function modules() {

        // TO DO
        $res['modules'] = Array(
            Array(
                'id' => 1, 'name' => 'Inside Enter Point : index.php',
                'files' => Array(
                    Array('path' => 'index.php', 'info' => 'Enter Point',

                        'blocks' => Array(
                            Array(
                                'block_id' => '1',
                                'block_name' => 'Show ALL Errors',
                                'block_code' => 'error_reporting( E_ALL );',
                                'advanced' => 'Need to Comment in PROD Mode',
                            )
                        )

                        )
                )
            ),
            Array(
                'id' => 1, 'name' => 'Inside Default Files',
                'files' => Array(
                    Array('path' => 'config.php', 'info' => 'Main Config file. if it not exists, you need to copy from config_default.php'),
                    Array('path' => 'config_default.php', 'info' => 'Default Config file example. if config.php is not exists, you need to copy from config_default.php'),

                )
            ),
            Array('id' => 2, 'name' => 'Inside Globals Class'),
            Array('id' => 3, 'name' => 'Inside Routing Class'),
            Array('id' => 4, 'name' => 'Inside Base Controller Class'),

        );

        $this->response->echo_json($res);
    }

    public function database() {

        // if Admin Check ( TO DO )
        $obj = new \Inside4\InsideTools\InsideDatabaseView;
        $obj->db =& $this->db;
        $obj->view();

    }

    public function projectfiles() {

        // if Admin Check ( TO DO )

        $obj = new \Inside4\InsideTools\InsideProjectFiles;
        $obj->view();

    }



    public function table($table_name = 'inside_top_menu') {

    }
}