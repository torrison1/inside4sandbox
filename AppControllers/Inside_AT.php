<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Inside_AT extends BaseController
{
    public function table($table_name = 'Inside_top_menu') {

        $admin_system = new \Inside4\InsideAdminSystem\InsideAdminSystem;
        $admin_system->init();

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $table_name = ucfirst($table_name);

        $this->data['table_name'] = $table_name;

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'init');

        // Isset Config File
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;

        if (class_exists($table_class)) {
            $table_obj = new $table_class();
            $table_obj->init();
            if (isset($table_config)) $this->data['table_config'] = $table_obj->table_config;
            $this->data['table_config'] = $table_obj->table_config;


            $this->data['filters'] = $at_system->generate_top_filters($table_obj);
            $this->data['inside_filters'] = $this->view->render_to_var($this->data, 'Parts/inside_filters.php', $template_folder = 'inside_admin_template');
            $this->data['scope_type'] = 'table';
            $this->data['control_form'] = $this->view->render_to_var($this->data, 'Parts/inside_form.php', $template_folder = 'inside_admin_template');
            $this->data['terminal'] = 'AJAX loading...';
        } else {
            $this->data['control_form'] = '';
            $this->data['terminal'] = 'Sorry, this table does not exists';
        }

        if (isset($table_obj->interface_name)) $this->data['admin_interface_name'] = $table_obj->interface_name;
        else $this->data['admin_interface_name'] = $table_name;

        $this->data['menu_arr'] = $admin_system->get_top_menu_arr();
        $this->data['top_menu'] = $this->view->render_to_var($this->data, 'Parts/inside_menu.php', $template_folder = 'inside_admin_template');

        // Other HTML Template
        $this->view->render($this->data,'InsideAutoTables/interface', 'inside_admin_template');

    }

    public function scope() {

        $table_name = $this->input->post_secure('pdg_table');
        $table_name = $this->input->defend_filter(4, $table_name);

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'view');

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

        // Get Array
        $table_arr = $at_system->get_table_arr($table_name, $filter);
        $this->data['table_arr'] = $table_arr['res'];
        $this->data['sql'] = $table_arr['sql'];
        $this->data['debug'] = $this->input->post_secure('pdg_fsearch');
        $this->data['at_system'] =& $at_system;

        echo $this->view->render_to_var($this->data, 'Parts/inside_table.php', $template_folder = 'inside_admin_template');

    }


    // ------------------------------------------------------ AJAX Add Window ------------------------------
    public function add_dialog($cell_id = 0)
    { // << for ADD

        $table_name = $this->input->post_secure('pdg_table');
        $table_name = $this->input->defend_filter(4, $table_name);

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'edit');

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();


        //  ================= Check column access ===============
        $user_groups = array();
        $user_groups_ion = $this->auth->get_users_groups();
        if ($user_groups_ion) {
            foreach ($user_groups_ion as $group) {
                $user_groups[] = $group['name'];
            }
            unset($user_groups_ion);
        }

        //  ================= Check column access ===============


        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        // Get table row
        if ($cell_id > 0) $edit_cell_arr = $at_system->get_table_cell_arr($table_obj, $cell_id);
        else $edit_cell_arr = Array(); // << for ADD
        // Load Table Config

        // ============== Access system =======================

        if (isset($table_obj->table_config['access_system']) AND !$this->auth->is_admin()) {
            if (!$this->auth->in_group(Array($table_obj->table_config['access_work_groups']))) {
                echo 'Access denied'; die();
            }
        }

        // ============== Access system =======================

        // =================Tabs access==============

        $unaccess_tabs = array();
        if (isset($table_obj->table_config['tabs_access'])) {
            foreach ($table_obj->table_config['tabs_access'] as $key => $groups) {
                if(!array_intersect($user_groups, $groups)) {
                    $unaccess_tabs[] = $key;
                }
            }
        }

        // =================Tabs access==============

        // Wear table inputs
        foreach ($table_obj->table_columns as $config_row) {
            $tmp_name = $config_row['name'];
            if (!isset($edit_cell_arr[$tmp_name])) $edit_cell_arr[$tmp_name] = '';
            if (isset($config_row['default_value'])) $edit_cell_arr[$tmp_name] = $config_row['default_value'];
            if (isset($config_row['default_current_user_id'])) $edit_cell_arr[$tmp_name] = $this->data['user']->id;
            $config_row['value'] = $edit_cell_arr[$tmp_name];

            $config_row['cell_id'] = $cell_id;
            $config_row['table'] = $table_name;
            $config_row['make_type'] = 'add'; // << for ADD
            $config_row['cell_row'] = $edit_cell_arr;

            if (isset($config_row['input_type'])) {
                if(!isset($config_row['group_access_arr']) OR array_intersect($user_groups, $config_row['group_access_arr'])) { // CHECK INPUT ACCESS
                    $gen_inputs_arr[$tmp_name] = $at_system->make_input("input_form", $config_row);
                }
            }
        }
        // Add Relationships to table
        if (isset($table_obj->adv_rel_inputs)) {
            foreach ($table_obj->adv_rel_inputs as $rel_input_row) {
                if(!isset($rel_input_row['group_access_arr']) OR array_intersect($user_groups, $rel_input_row['group_access_arr'])) { // CHECK INPUT ACCESS
                    $rel_input_row['base_table'] = $table_name;
                    $rel_input_row['make_type'] = 'add'; // << for ADD
                    $gen_inputs_arr[$rel_input_row['name']] = $at_system->make_rel_input("input_form", $rel_input_row, $cell_id);
                }
            }
        }

        // Load View
        $this->data['edit_cell_arr'] = $edit_cell_arr;
        $this->data['gen_inputs_arr'] = $gen_inputs_arr;
        $this->data['table_name'] = $table_name;
        $this->data['dialog_id'] = intval($this->input->post_secure('dialog_id'));
        $this->data['cell_id'] = $cell_id;

        $this->data['key_field'] = $table_obj->table_config['key'];
        $this->data['table_config'] = $table_obj->table_config;
        $this->data['table_columns'] = $table_obj->table_columns;
        $this->data['unaccess_tabs'] = $unaccess_tabs;
        if (isset($table_obj->adv_rel_inputs)) $this->data['adv_rel_inputs'] = $table_obj->adv_rel_inputs;

        echo $this->view->render_to_var($this->data, 'Parts/inside_add_form.php', $template_folder = 'inside_admin_template');

    }

// ------------------------------------------------------ AJAX Edit Window ------------------------------
    public function edit_dialog()
    {

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $table_name = $this->input->post_secure('pdg_table');
        $table_name = $this->input->defend_filter(4, $table_name);

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'view');

        $cell_id = intval($this->input->post_secure('cell_id'));

        // Load Table Config
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        // Get table row
        $edit_cell_arr = $at_system->get_table_cell_arr($table_obj, $cell_id);


        //  ================= Check column access ===============
        $user_groups = array();
        $user_groups_ion = $this->auth->get_users_groups();
        if ($user_groups_ion) {
            foreach ($user_groups_ion as $group) {
                $user_groups[] = $group['name'];
            }
            unset($user_groups_ion);
        }
        //  ================= Check column access ===============

        // ============== Access system =======================
        //if (!$edit_cell_arr) {
        //echo 'Access denied';
        //die();
        // }// If no access echo message and stop
        // ============== Access system =======================


        // =================Tabs access==============
        $unaccess_tabs = array();
        if (isset($table_obj->table_config['tabs_access'])) {
            foreach ($table_obj->table_config['tabs_access'] as $key => $groups) {
                if(!array_intersect($user_groups, $groups)) {
                    $unaccess_tabs[] = $key;
                }
            }
        }
        // =================Tabs access==============

        // Wear table inputs
        foreach ($table_obj->table_columns as $config_row) {
            $tmp_name = $config_row['name'];
            $config_row['value'] = $edit_cell_arr[$tmp_name];

            $config_row['cell_id'] = $cell_id;
            $config_row['table'] = $table_name;
            $config_row['make_type'] = 'edit';
            $config_row['cell_row'] = $edit_cell_arr;

            if (isset($config_row['input_type']))
                // Check column access
                if(!isset($config_row['group_access_arr']) OR array_intersect($user_groups, $config_row['group_access_arr'])) {
                    $gen_inputs_arr[$tmp_name] = $at_system->make_input("input_form", $config_row);
                }
        }
        // Add Relationships to table
        if (isset($table_obj->adv_rel_inputs)) {
            foreach ($table_obj->adv_rel_inputs as $rel_input_row) {
                if(!isset($rel_input_row['group_access_arr']) OR array_intersect($user_groups, $rel_input_row['group_access_arr'])) {
                    $rel_input_row['base_table'] = $table_name;
                    $rel_input_row['make_type'] = 'edit';
                    $gen_inputs_arr[$rel_input_row['name']] = $at_system->make_rel_input("input_form", $rel_input_row, $cell_id);
                }
            }
        }

        // Add Chat Data [DEPRECATED]
        // $query = $this->db->query("SELECT * FROM inside_row_chat WHERE row_chat_invisible = 0 AND row_chat_row_id = " . $cell_id . " AND row_chat_table = '" . $table_name . "' ORDER BY row_chat_datetime DESC");
        // $this->data['chat_messages'] = $query->result_array();
        $this->data['chat_messages'] = '';

        // Add All Groups Select
        // NEED Refactoring!
        // $this->load->model('inside/custom_interfaces/inside_access/main_model', 'access_custom_model');
        // $this->data['group_select'] = $this->access_custom_model->group_select_by_id_return();

        $this->data['group_select'] = '';


        // Load View
        $this->data['edit_cell_arr'] = $edit_cell_arr;
        $this->data['gen_inputs_arr'] = $gen_inputs_arr;
        $this->data['table_name'] = $table_name;
        $this->data['dialog_id'] = $this->input->post_secure('dialog_id');
        $this->data['cell_id'] = $cell_id;

        $this->data['key_field'] = $table_obj->table_config['key'];
        $this->data['table_config'] = $table_obj->table_config;
        $this->data['table_columns'] = $table_obj->table_columns;
        $this->data['unaccess_tabs'] = $unaccess_tabs;
        if (isset($table_obj->adv_rel_inputs)) $this->data['adv_rel_inputs'] = $table_obj->adv_rel_inputs;

        echo $this->view->render_to_var($this->data, 'Parts/inside_edit_form.php', $template_folder = 'inside_admin_template');

    }


    // ------------------------------- INSERT, UPDATE, DELETE DB Requests ----------------------------------
    public function edit_request()
    {
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $table_name = $this->input->get_secure('table_name');
        $tab = $this->input->get_secure('tab');
        $cell_id = $this->input->get_secure('cell_id');


        // Access Check
        $at_system->check_access('inside_' . $table_name, 'edit');


        // access system
        // if (!$this->access_system_edit('edit',$table_name, $cell_id)) { die(); }

        // ------------------------------------------------------ AJAX EDIT Request ------------------------------

        $at_system->update_table_cell($table_name, $tab, $cell_id);

        // Need Refactoring
        echo "Data Saved!";
        // ------------------------------------------------------------------------------------------------------

    }

    // ------------------------------- INSERT, UPDATE, DELETE DB Requests ----------------------------------
    public function fast_edit()
    {

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $table_name = $this->input->post_secure('table');
        $cell_id = intval($this->input->post_secure('line_id'));

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'edit');

        // Load Table Config
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        $this->db->update(
            $table_obj->db_table_name,
            Array($this->input->post_secure('column') => $this->input->post_secure('value')),
            " WHERE `".str_replace('`','',($this->input->post_secure('key_id')))."` = ".intval($cell_id)
        );

        // Need Refactoring
        echo "1";

    }

    public function add_request()
    {

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $table_name = $this->input->get_secure('table_name');

        // Load Table Config
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'edit');

        // ============== Access system =======================

        if (isset($table_obj->table_config['access_system']) AND !$this->auth->is_admin()) {
            if(!$this->auth->in_group(Array($table_config['access_work_groups']))) {
                echo null; die();
            }
        }
        // ============== Access system =======================

        $at_system->insert_table_cell($table_name);

        // Need Refactoring
        echo "Data Saved!";

    }

    public function del_request()
    {

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $table_name = $this->input->get_secure('table_name');

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'edit');

        // access system
        // if (!$this->access_system_edit('del',$table_name)) { die(); }

        $result = $at_system->del_table_cell($table_name);

        // Need Refactoring
        echo $result." Deleted!";

    }

}
