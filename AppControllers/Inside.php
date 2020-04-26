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