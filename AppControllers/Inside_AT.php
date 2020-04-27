<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Inside_AT extends BaseController
{
    public function table($table_name = 'inside_top_menu') {

        $this->data['top_menu'] = 'MENU';

        $this->data['table_name'] = $table_name;

        // Other HTML Template
        $this->view->render($this->data,'AutoTables/table', 'inside_admin_template');

    }
}
