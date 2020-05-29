<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

// Inside Custom CRUD Interface Example

Class Inside_cruds extends BaseController
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

    public function requests()
    {
        $table_name = 'It_requests';

        $this->data['admin_interface_name'] = 'Custom Requests CRUD';

        $admin_system = new \Inside4\InsideAdminSystem\InsideAdminSystem;
        $admin_system->init();

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $table_name = ucfirst($table_name);

        $this->data['table_name'] = $table_name;

        // Access Check
        $at_system->check_access('inside_' . $table_name, 'init');

        // Isset Config File
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\" . $table_name;

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


        $this->data['menu_arr'] = $admin_system->get_top_menu_arr();
        $this->data['top_menu'] = $this->view->render_to_var($this->data, 'Parts/inside_menu.php', $template_folder = 'inside_admin_template');

        // Other HTML Template
        $this->view->render($this->data, 'InsideCruds/Requests/interface', 'inside_admin_template');

    }

    public function requests_scope() {

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
        $table_arr = $this->get_table_arr($table_name, $filter);
        $this->data['table_arr'] = $table_arr['res'];
        $this->data['sql'] = $table_arr['sql'];
        $this->data['debug'] = $this->input->post_secure('pdg_fsearch');
        $this->data['at_system'] =& $at_system;

        echo $this->view->render_to_var($this->data, 'Pages/InsideCruds/Requests/inside_table.php', $template_folder = 'inside_admin_template');

    }

    public function get_table_arr($table_name, $filter)
    {

        $db =& $GLOBALS['Commons']['db'];
        $input =& $GLOBALS['Commons']['input'];
        $auth =& $GLOBALS['Commons']['auth'];

        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        $table_config = $table_obj->table_config;
        $table_columns = $table_obj->table_columns;
        $table_name = $table_obj->db_table_name;

        // Add Special vars
        $order = " ORDER BY `".$table_config['key']."` DESC";
        if (isset($table_config['order_by'])) $order = $table_config['order_by'];
        $where = '';
        $where_filter = '';
        $limit = ' ';
        $asc = 'ASC';
        $columns = '';
        $join_columns = '';
        $join = '';


        // Prepare Where Filter: Form Filter + Multi Search
        foreach ($table_columns as $config_row) {

            if (isset ($config_row['in_crud'])) $columns .= $table_name . '.' . $config_row['name'] . ", "; //was ambiguous - add table_name
            //if (isset ($config_row['in_crud'])) {  //filter without in crud option

            // =============== Filters generation =============== =============== ===============
            if (isset ($config_row['filter'])) {
                $tmp_name = $config_row['name'];

                if (isset($config_row['filter_method'])) {

                    if ($config_row['filter_method'] == 'multiselect_filter') {
                        if (isset($_POST[$tmp_name]) AND count($_POST[$tmp_name]) > 0) {

                            foreach ($_POST[$tmp_name] as &$variant) {
                                $variant = (int) $input->defend_filter(4, $variant);
                            }
                            unset($variant);

                            $variants = implode(', ', $_POST[$tmp_name]);
                            $where_filter .= " AND " . $table_name . '.' . $config_row['name'] . " IN (" . $variants . ")";
                        }
                    } elseif ($config_row['filter_method'] == 'like_filter') {
                        if (isset($_POST[$tmp_name]) AND strlen($_POST[$tmp_name]) > 1)
                            $where_filter .= " AND " . $table_name . '.' . $config_row['name'] . " like '%" . $_POST[$tmp_name] . "%'";
                    } elseif ($config_row['filter_method'] == 'comparison_filter') {
                        if (isset($_POST['comparison_' . $tmp_name]) AND $_POST['comparison_' . $tmp_name] != '') {
                            if($_POST['to_' . $tmp_name] == 0) $_POST['to_' . $tmp_name] = 9999999999;
                            $where_filter .= " AND " . $table_name . '.' . $config_row['name'] . " BETWEEN " . intval($_POST['from_' . $tmp_name]) . " AND " . intval($_POST['to_' . $tmp_name]);
                        }
                    }
                } else {

                    $_POST[$tmp_name] = $input->defend_filter(4, @$_POST[$tmp_name]);
                    if (strlen($_POST[$tmp_name]) > 0)
                        $where_filter .= " AND " . $table_name . '.' . $config_row['name'] . " = '" . $_POST[$tmp_name] . "'"; //here also was ambiguous

                }
            }

            if ((isset($filter['fsearch'])) && (strlen($filter['fsearch']) > 1))
                $where .= " CONVERT(" . $table_name . '.' . $config_row['name'] . ", CHAR) like '%" . $filter['fsearch'] . "%' OR"; // here also was ambiguous + CONVERT MODIFY

            if ((isset($filter['fkey'])) && (intval($filter['fkey']) > 0))
                $where .= " " . $table_name . '.' . $table_config['key'] . " = '" . $filter['fkey'] . "' OR"; //here also was ambiguous

            //}
        }
        $columns = substr($columns, 0, -2);
        $where = substr($where, 0, -3);

        // Prepare Order parametrs
        if ( (isset($filter['asc'])) && (strlen($filter['asc']) > 1) ) $asc = $filter['asc'];
        if ( (isset($filter['order'])) && (strlen($filter['order']) > 1) )  $order = " ORDER BY `".$filter['order']."` ".$asc;

        // Prepare Limit and Page parametrs
        if ( (isset($filter['page'])) && ($filter['page'] > 0) ) $filter['page']--;
        if ( (isset($filter['limit'])) && ($filter['limit'] > 0) ) $limit = " LIMIT ".intval($filter['page'])*intval($filter['limit']).",".intval($filter['limit']);

        // Add Where to request
        if (strlen($where) > 2) $where = ' WHERE 1 '.$where_filter.' AND ('.$where.') ';
        else $where = ' WHERE 1 '.$where_filter.' ';

        // Make Join Columns
        if (isset ($table_join))
        {
            foreach ($table_join as $join_arr) {

                $join_columns_this_table = '';
                foreach ($table_columns as $config_row) {
                    if ( (isset ($config_row['join'])) && ($config_row['join'] == $join_arr['table']))
                    {

                        // adv_columns
                        $join_columns .= ", ".$join_arr['table'].".".$config_row['join_column']." ".$config_row['join_as'];
                        //$join_columns_this_table .= $config_row['join_column'].", ";
                    }
                }
                // join_sql
                //$join_columns_this_table = substr($join_columns_this_table, 0, -2);
                $join .= " LEFT JOIN ".$join_arr['table']." ON ".$table_name.".".$join_arr['table_key']." = ".$join_arr['table'].".".$join_arr['join_key']." ";

            }
        }


        if (isset($table_config['join_sql'])) {
            $join .= $table_config['join_sql'];
        }

        if (isset($table_config['adv_columns'])) {
            $join_columns .= ', ' . $table_config['adv_columns'];
        }

        // Make Request
        $query_sql = 'SELECT '.$columns.$join_columns.' FROM '.$table_name.$join.$where.$order.$limit;
        $return['res'] = $db->sql_get_data($query_sql);
        $return['sql'] = $query_sql;

        return $return;

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

        // =================Tabs access==============
        if (isset($table_obj->table_config['access_system']) AND !$this->auth->is_admin()) {
            if (!$this->auth->in_group(Array($table_obj->table_config['access_work_groups']))) {
                echo 'Access denied'; die();
            }
        }

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

        echo $this->view->render_to_var($this->data, 'Pages/InsideCruds/Requests/inside_add_form.php', $template_folder = 'inside_admin_template');

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

        // =================Tabs access==============
        $user_groups = array();
        $user_groups_ion = $this->auth->get_users_groups();
        if ($user_groups_ion) {
            foreach ($user_groups_ion as $group) {
                $user_groups[] = $group['name'];
            }
            unset($user_groups_ion);
        }
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

        $this->data['chat_messages'] = '';

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

        echo $this->view->render_to_var($this->data, 'Pages/InsideCruds/Requests/inside_edit_form.php', $template_folder = 'inside_admin_template');

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
            " WHERE ".$_POST['key_id']." = ".intval($cell_id)
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

        $result = $at_system->del_table_cell($table_name);

        // Need Refactoring
        echo $result." Deleted!";

    }

    public function update_table_cell($table_name, $tab, $cell_id)
    {

        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        $db =& $GLOBALS['Commons']['db'];
        $input =& $GLOBALS['Commons']['input'];
        $user =& $GLOBALS['Commons']['user'];

        // Load Table Config
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        // Make Update Array by Input Fields
        $update_array = Array();

        if(!isset($_POST['not_update_table_columns'])) {
            foreach ($table_obj->table_columns as $config_row) {
                if ((isset($config_row['tab'])) && ($config_row['tab'] == $tab)) {
                    $tmp_name = $config_row['name'];

                    if (!isset ($config_row['defend_filter'])) $config_row['defend_filter'] = 1;
                    $config_row['value'] = $input->defend_filter(intval($config_row['defend_filter']), @$_POST[@$tmp_name]);

                    $config_row['cell_id'] = $cell_id;
                    $config_row['tab'] = $tab;
                    $config_row['table'] = $table_obj->db_table_name;
                    $config_row['post_array'] = $_POST;
                    $config_row['save_type'] = 'update';

                    $save_value = $at_system->make_input('db_save', $config_row);

                    if (!(is_bool($save_value) && !$save_value)) {
                        if (is_array($save_value)) {
                            foreach ($save_value as $key => $value) $update_array[$key] = $value;
                        } else $update_array[$tmp_name] = $save_value;
                    }

                }
            }
        }


        if (count ($update_array) > 0) $db->update($table_obj->db_table_name, $update_array, ' WHERE '.$table_obj->table_config['key']." = ".intval($cell_id));

        $db->insert(
            'inside_log',
            Array(
                'log_table' => $table_obj->db_table_name,
                'log_datetime' => time(),
                'log_sql' => 'UPDATE '.$table_obj->db_table_name.print_r($update_array, true).' WHERE '.$table_obj->table_config['key']." = ".intval($cell_id),
                'log_user_id' => $user['id'])
        );

        if (isset($table_obj->adv_rel_inputs))
        {
            foreach ($table_obj->adv_rel_inputs as $rel_input_arr) {
                if ($rel_input_arr['tab'] == $tab) {
                    $rel_input_arr['base_table'] = $table_obj->db_table_name;
                    $at_system->make_rel_input("db_save", $rel_input_arr, $cell_id);
                }
            }
        }
        return "Ok!";
    }


    public function insert_table_cell($table_name)
    {
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        $db =& $GLOBALS['Commons']['db'];
        $input =& $GLOBALS['Commons']['input'];
        $user =& $GLOBALS['Commons']['user'];

        // Load Table Config
        $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        // Make Update Array by Input Fields
        $insert_array = Array();
        foreach ($table_obj->table_columns as $config_row) {
            $tmp_name = $config_row['name'];

            if (!isset ($config_row['defend_filter'])) $config_row['defend_filter'] = 1;
            $config_row['value'] = $input->defend_filter(intval($config_row['defend_filter']), @$_POST[$tmp_name]);

            $config_row['table'] = $table_obj->db_table_name;
            $config_row['post_array'] = $_POST;
            $config_row['save_type'] = 'insert';

            $save_value = $at_system->make_input('db_save', $config_row);
            if (! (is_bool($save_value) && !$save_value))
            {
                if (is_array($save_value))
                {
                    foreach ($save_value as $key => $value) $insert_array[$key] = $value;
                }
                else $insert_array[$tmp_name] = $save_value;
            }
        }

        if (count ($insert_array) > 0) $db->insert($table_obj->db_table_name, $insert_array);

        $cell_id = $db->last_id();

        $db->insert('inside_log', Array('log_table' => $table_obj->db_table_name, 'log_datetime' => time(), 'log_sql' => 'INSERT '.$table_obj->db_table_name.print_r($insert_array, true), 'log_user_id' => $user['id']));

        if (isset($table_obj->adv_rel_inputs))
        {
            foreach ($table_obj->adv_rel_inputs as $rel_input_arr) {
                $rel_input_arr['base_table'] = $table_obj->db_table_name;
                $at_system->make_rel_input("db_add", $rel_input_arr, $cell_id);
            }
        }
        return "Ok!";
    }

    public function del_table_cell($table_name)
    {
        if (isset($_POST['del_ids']))
        {
            // Load Config
            $db =& $GLOBALS['Commons']['db'];
            $user =& $GLOBALS['Commons']['user'];

            // Load Table Config
            $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
            if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
            $table_obj = new $table_class();
            $table_obj->init();

            foreach ($_POST['del_ids'] as $del_id)
            {
                echo intval ($del_id);
                $db->run_sql("DELETE FROM ".$table_obj->db_table_name." WHERE ".$table_obj->table_config['key']." = ".intval($del_id));

                $db->insert('inside_log', Array('log_table' => $table_obj->db_table_name, 'log_datetime' => time(), 'log_sql' => 'DELETE id = '.$del_id.' FROM '.$table_obj->db_table_name, 'log_user_id' => $user['id']));
            }
        }
        return "Ok!";
    }
}