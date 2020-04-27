<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Inside_AT extends BaseController
{
    public function table($table_name = 'inside_top_menu') {

        $this->data['top_menu'] = 'MENU';

        $this->data['table_name'] = $table_name;

        // Access Check
        // $this->inside_lib->check_access('inside_' . $table_name, 'init');

        // Isset Config File
        if (file_exists('application/config/pdg_tables/' . $table_name . '.php')) {
            include('application/config/pdg_tables/' . $table_name . '.php');

            if (isset($table_config)) $this->data['table_config'] = $table_config;

            $filters = $this->inside_model->generate_top_filters2($table_name);

            $this->data['control_form'] = $this->load->view('admin/pages/inside/inside_form', $this->data, TRUE);

            // Terminal Message
            $this->data['terminal'] = 'AJAX loading...';

        } else {
            // Head Scripts
            $this->data['control_form'] = '';
            $this->data['terminal'] = 'Sorry, this table does not exists';

        }

        // Other HTML Template
        $this->view->render($this->data,'InsideAutoTables/interface', 'inside_admin_template');

    }

    public function scope() {

        echo "SCOPE";
        exit();

        $this->load->model('inside_model');

        $table_name = $this->input->post('pdg_table', true);
        $table_name = $this->inside_lib->defend_filter(4, $table_name);

        // Access Check
        $this->inside_lib->check_access('inside_' . $table_name, 'view');

        // Filtering POST data
        $input_view_data['table_name'] = $table_name;
        $filter['order'] = $this->input->post('pdg_order', true);
        $filter['asc'] = $this->input->post('pdg_asc', true);
        $filter['limit'] = $this->input->post('pdg_limit', true);
        $filter['page'] = $this->input->post('pdg_page', true);
        $filter['fsearch'] = $this->input->post('pdg_fsearch', true);
        $filter['fsearch'] = $this->inside_lib->defend_filter(1, $filter['fsearch']);
        $filter['fkey'] = intval($this->input->post('pdg_fkey', true));
        $filter['order'] = $this->inside_lib->defend_filter(1, $filter['order']);
        $filter['asc'] = $this->inside_lib->defend_filter(1, $filter['asc']);
        $filter['limit'] = intval($filter['limit']);
        $filter['page'] = intval($filter['page']);

        // Get Array
        $table_arr = $this->inside_model->get_table_arr($table_name, $filter);
        $input_view_data['table_arr'] = $table_arr['res'];
        $input_view_data['sql'] = $table_arr['sql'];
        $input_view_data['debug'] = $this->input->post('pdg_fsearch', true);
        // Wear PDG_view
        if ($_POST['scope_type'] == 'atl') $this->load->view('admin/pages/inside/inside_table_lite', $input_view_data);
        else $this->load->view('admin/pages/inside/inside_table', $input_view_data);

    }
}
