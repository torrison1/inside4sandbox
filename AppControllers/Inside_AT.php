<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Inside_AT extends BaseController
{
    public function table($table_name = 'Inside_top_menu') {

        $this->data['top_menu'] = 'MENU';

        $table_name = ucfirst($table_name);

        $this->data['table_name'] = $table_name;

        // Access Check
        // $this->inside_lib->check_access('inside_' . $table_name, 'init');

        // Isset Config File
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;

        if (class_exists($table_class)) {
            $table_obj = new $table_class();
            $table_obj->init();
            if (isset($table_config)) $this->data['table_config'] = $table_obj->table_config;
            $this->data['table_config'] = $table_obj->table_config;

            $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
            $at_system->init();
            $this->data['filters'] = $at_system->generate_top_filters($table_obj);
            $this->data['inside_filters'] = $this->view->render_to_var($this->data, 'Parts/inside_filters.php', $template_folder = 'inside_admin_template');
            $this->data['scope_type'] = 'table';
            $this->data['control_form'] = $this->view->render_to_var($this->data, 'Parts/inside_form.php', $template_folder = 'inside_admin_template');
            $this->data['terminal'] = 'AJAX loading...';
        } else {
            $this->data['control_form'] = '';
            $this->data['terminal'] = 'Sorry, this table does not exists';
        }

        $admin_system = new \Inside4\InsideAdminSystem\InsideAdminSystem;
        $admin_system->init();
        $this->data['menu_arr'] = $admin_system->get_top_menu_arr();
        $this->data['top_menu'] = $this->view->render_to_var($this->data, 'Parts/inside_menu.php', $template_folder = 'inside_admin_template');

        // Other HTML Template
        $this->view->render($this->data,'InsideAutoTables/interface', 'inside_admin_template');

    }

    public function scope() {


        $table_name = $this->input->post_secure('pdg_table');
        $table_name = $this->input->defend_filter(4, $table_name);

        // Access Check
        // $this->inside_lib->check_access('inside_' . $table_name, 'view');

        // Filtering POST data
        $this->data['table_name'] = $table_name;
        $filter['order'] = $this->input->post_secure('pdg_order');
        $filter['asc'] = $this->input->post_secure('pdg_asc');
        $filter['limit'] = $this->input->post_secure('pdg_limit');
        $filter['page'] = $this->input->post_secure('pdg_page');
        $filter['fsearch'] = $this->input->post_secure('pdg_fsearch');
        $filter['fsearch'] = $this->input->defend_filter(1, $filter['fsearch']);
        $filter['fkey'] = intval($this->input->post_secure('pdg_fkey'));
        $filter['order'] = $this->input->defend_filter(1, $filter['order']);
        $filter['asc'] = $this->input->defend_filter(1, $filter['asc']);
        $filter['limit'] = intval($filter['limit']);
        $filter['page'] = intval($filter['page']);

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        // Get Array
        $table_arr = $at_system->get_table_arr($table_name, $filter);
        $this->data['table_arr'] = $table_arr['res'];
        $this->data['sql'] = $table_arr['sql'];
        $this->data['debug'] = $this->input->post_secure('pdg_fsearch');
        $this->data['at_system'] =& $at_system;

        echo $this->view->render_to_var($this->data, 'Parts/inside_table.php', $template_folder = 'inside_admin_template');

    }
}
