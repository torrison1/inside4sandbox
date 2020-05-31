<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

// Inside Custom CRUD Interface Example

Class Inside_cruds extends BaseController
{

    //i--- Define Default System Elements Variables ; inside_custom_cruds ; torrison ; 01.06.2020 ; 0 ---/
    var $default_table_name = 'It_requests';
    var $default_admin_interface_name = 'Custom Requests CRUD';
    var $default_table_config_path = '\\Inside4\\InsideAutoTables\\Tables\\';

    var $default_filters_inputs_path = 'Pages/InsideCruds/Requests/inside_filters.php';
    var $default_top_form_path = 'Pages/InsideCruds/Requests/inside_form.php';
    var $default_interface_path = 'InsideCruds/Requests/interface';
    var $default_scope_wear_view_path = 'Pages/InsideCruds/Requests/inside_table.php';
    var $default_inside_add_form_path = 'Pages/InsideCruds/Requests/inside_add_form.php';
    var $default_inside_edit_form_path = 'Pages/InsideCruds/Requests/inside_edit_form.php';


    public function __construct() {
        parent::__construct();

        $admin_system = new \Inside4\InsideAdminSystem\InsideAdminSystem;
        $admin_system->init();

        //i--- Admin Tree with Group Access ; inside_custom_cruds ; torrison ; 01.06.2020 ; 1 ---/
        $this->data['top_menu'] = 'MENU';
        $this->data['menu_arr'] = $admin_system->get_top_menu_arr();
        $this->data['top_menu'] = $this->view->render_to_var($this->data, 'Parts/inside_menu.php', $template_folder = 'inside_admin_template');

        $this->data['default_API_path'] = '/Inside_cruds/';
    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function requests() {
        //i--- Requests Interface ; inside_custom_cruds ; torrison ; 01.06.2020 ; 2 ---/
        $table_name = $this->default_table_name;
        $this->data['admin_interface_name'] = $this->default_admin_interface_name;
        $admin_system = new \Inside4\InsideAdminSystem\InsideAdminSystem;
        $admin_system->init();
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        $table_name = ucfirst($table_name);
        $this->data['table_name'] = $table_name;

        //i--- Check Access by Group ; inside_custom_cruds ; torrison ; 01.06.2020 ; 3 ---/
        $at_system->check_access('inside_' . $table_name, 'init');

        //i--- Open Table Config file ; inside_custom_cruds ; torrison ; 01.06.2020 ; 4 ---/
        $table_class = $this->default_table_config_path . $table_name;
        if (class_exists($table_class)) {
            $table_obj = new $table_class();
            $table_obj->init();
            if (isset($table_config)) $this->data['table_config'] = $table_obj->table_config;
            $this->data['table_config'] = $table_obj->table_config;
            //i--- Generate TOP Filters Form and Table Header ; inside_custom_cruds ; torrison ; 01.06.2020 ; 5 ---/
            $this->data['filters'] = $at_system->generate_top_filters($table_obj);
            $this->data['inside_filters'] = $this->view->render_to_var($this->data, $this->default_filters_inputs_path, $template_folder = 'inside_admin_template');
            $this->data['scope_type'] = 'table';
            $this->data['control_form'] = $this->view->render_to_var($this->data, $this->default_top_form_path, $template_folder = 'inside_admin_template');
            $this->data['terminal'] = 'AJAX loading...';
        } else {
            $this->data['control_form'] = '';
            $this->data['terminal'] = 'Sorry, this table does not exists';
        }

        //i--- Override Admin Menu (Optional) [OFF] ; inside_custom_cruds ; torrison ; 01.06.2020 ; 6 ---/
        // $this->data['menu_arr'] = $admin_system->get_top_menu_arr();
        // $this->data['top_menu'] = $this->view->render_to_var($this->data, 'Parts/inside_menu.php', $template_folder = 'inside_admin_template');

        //i--- Render Interface from View ; inside_custom_cruds ; torrison ; 01.06.2020 ; 7 ---/
        $this->view->render($this->data, $this->default_interface_path, 'inside_admin_template');

    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function requests_scope() {

        //i--- Request for Scope Data ; inside_custom_cruds ; torrison ; 01.06.2020 ; 8 ---/
        // $table_name = $this->input->post_secure('pdg_table');
        // $table_name = $this->input->defend_filter(4, $table_name);
        $table_name = $this->default_table_name;
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        $at_system->check_access('inside_' . $table_name, 'view');

        //i--- Filtering requests_scope POST data ; inside_custom_cruds ; torrison ; 01.06.2020 ; 9 ---/
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

        //i--- Get Data from Database, Storage or API ; inside_custom_cruds ; torrison ; 01.06.2020 ; 10 ---/
        $table_arr = $this->get_table_arr($table_name, $filter);
        $this->data['table_arr'] = $table_arr['res'];
        $this->data['sql'] = $table_arr['sql'];
        $this->data['debug'] = $this->input->post_secure('pdg_fsearch');
        $this->data['at_system'] =& $at_system;

        //i--- Wear Data in View ; inside_custom_cruds ; torrison ; 01.06.2020 ; 11 ---/
        echo $this->view->render_to_var($this->data, $this->default_scope_wear_view_path, $template_folder = 'inside_admin_template');

    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function get_table_arr($table_name, $filter) {

        //i--- Get Data [Model Method] ; inside_custom_cruds ; torrison ; 01.06.2020 ; 12 ---/
        $db =& $GLOBALS['Commons']['db'];
        $input =& $GLOBALS['Commons']['input'];
        $auth =& $GLOBALS['Commons']['auth'];

        // Load Table Object
        $table_class = $this->default_table_config_path.$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        $table_config = $table_obj->table_config;
        $table_columns = $table_obj->table_columns;
        $table_name = $table_obj->db_table_name;

        //i--- Dynamic Sorting ; inside_custom_cruds ; torrison ; 01.06.2020 ; 13 ---/
        $order = " ORDER BY `".$table_config['key']."` DESC";
        if (isset($table_config['order_by'])) $order = $table_config['order_by'];
        $where = '';
        $where_filter = '';
        $limit = ' ';
        $asc = 'ASC';
        $columns = '';
        $join_columns = '';
        $join = '';


        //i--- Prepare Where Filter: Form Filter + Multi Search ; inside_custom_cruds ; torrison ; 01.06.2020 ; 14 ---/
        foreach ($table_columns as $config_row) {

            if (isset ($config_row['in_crud'])) $columns .= $table_name . '.' . $config_row['name'] . ", ";

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
                        $where_filter .= " AND " . $table_name . '.' . $config_row['name'] . " = '" . $_POST[$tmp_name] . "'";

                }
            }

            //i--- Free Text Search and Filter by ID ; inside_custom_cruds ; torrison ; 01.06.2020 ; 15 ---/
            if ((isset($filter['fsearch'])) && (strlen($filter['fsearch']) > 1))
                $where .= " CONVERT(" . $table_name . '.' . $config_row['name'] . ", CHAR) like '%" . $filter['fsearch'] . "%' OR";

            if ((isset($filter['fkey'])) && (intval($filter['fkey']) > 0))
                $where .= " " . $table_name . '.' . $table_config['key'] . " = '" . $filter['fkey'] . "' OR";

        }
        $columns = substr($columns, 0, -2);
        $where = substr($where, 0, -3);

        //i--- Prepare Sorting and Pagination parameters ; inside_custom_cruds ; torrison ; 01.06.2020 ; 16 ---/
        if ( (isset($filter['asc'])) && (strlen($filter['asc']) > 1) ) $asc = $filter['asc'];
        if ( (isset($filter['order'])) && (strlen($filter['order']) > 1) )  $order = " ORDER BY `".$filter['order']."` ".$asc;

        if ( (isset($filter['page'])) && ($filter['page'] > 0) ) $filter['page']--;
        if ( (isset($filter['limit'])) && ($filter['limit'] > 0) ) $limit = " LIMIT ".intval($filter['page'])*intval($filter['limit']).",".intval($filter['limit']);

        //i--- Add Where request block ; inside_custom_cruds ; torrison ; 01.06.2020 ; 17 ---/
        if (strlen($where) > 2) $where = ' WHERE 1 '.$where_filter.' AND ('.$where.') ';
        else $where = ' WHERE 1 '.$where_filter.' ';

        //i--- Make Join blocks (Optional) ; inside_custom_cruds ; torrison ; 01.06.2020 ; 18 ---/
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

        //i--- Make SQL Request ; inside_custom_cruds ; torrison ; 01.06.2020 ; 19 ---/
        $query_sql = 'SELECT '.$columns.$join_columns.' FROM '.$table_name.$join.$where.$order.$limit;
        $return['res'] = $db->sql_get_data($query_sql);
        $return['sql'] = $query_sql;

        return $return;

    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function add_dialog($cell_id = 0) {
        //i--- Add Dialog View Request ; inside_custom_cruds ; torrison ; 01.06.2020 ; 20 ---/
        // $table_name = $this->input->post_secure('pdg_table');
        // $table_name = $this->input->defend_filter(4, $table_name);
        $table_name = $this->default_table_name;
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        $at_system->check_access('inside_' . $table_name, 'edit');
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        // Load Table Config
        $table_class = $this->default_table_config_path.$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        //i--- Get data for Copy Dialog ; inside_custom_cruds ; torrison ; 01.06.2020 ; 21 ---/
        if ($cell_id > 0) $edit_cell_arr = $this->get_table_cell_arr($table_obj, $cell_id);
        else $edit_cell_arr = Array();


        //i--- Get form inputs array ; inside_custom_cruds ; torrison ; 01.06.2020 ; 22 ---/
        foreach ($table_obj->table_columns as $config_row) { // Columns Inputs
            $tmp_name = $config_row['name'];
            if (!isset($edit_cell_arr[$tmp_name])) $edit_cell_arr[$tmp_name] = '';
            if (isset($config_row['default_value'])) $edit_cell_arr[$tmp_name] = $config_row['default_value'];
            if (isset($config_row['default_current_user_id'])) $edit_cell_arr[$tmp_name] = $this->data['user']->id;
            $config_row['value'] = $edit_cell_arr[$tmp_name];

            $config_row['cell_id'] = $cell_id;
            $config_row['table'] = $table_name;
            $config_row['make_type'] = 'add';
            $config_row['cell_row'] = $edit_cell_arr;

            if (isset($config_row['input_type'])) $gen_inputs_arr[$tmp_name] = $at_system->make_input("input_form", $config_row);
        }
        if (isset($table_obj->adv_rel_inputs)) { // Relation Inputs
            foreach ($table_obj->adv_rel_inputs as $rel_input_row) {

                    $rel_input_row['base_table'] = $table_name;
                    $rel_input_row['make_type'] = 'add';
                    $gen_inputs_arr[$rel_input_row['name']] = $at_system->make_rel_input("input_form", $rel_input_row, $cell_id);
            }
        }

        //i--- Wear add form View ; inside_custom_cruds ; torrison ; 01.06.2020 ; 23 ---/
        $this->data['edit_cell_arr'] = $edit_cell_arr;
        $this->data['gen_inputs_arr'] = $gen_inputs_arr;
        $this->data['table_name'] = $table_name;
        $this->data['dialog_id'] = intval($this->input->post_secure('dialog_id'));
        $this->data['cell_id'] = $cell_id;

        $this->data['key_field'] = $table_obj->table_config['key'];
        $this->data['table_config'] = $table_obj->table_config;
        $this->data['table_columns'] = $table_obj->table_columns;
        if (isset($table_obj->adv_rel_inputs)) $this->data['adv_rel_inputs'] = $table_obj->adv_rel_inputs;

        echo $this->view->render_to_var($this->data, $this->default_inside_add_form_path, $template_folder = 'inside_admin_template');

    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function edit_dialog() {
        //i--- Edit Dialog View Request ; inside_custom_cruds ; torrison ; 01.06.2020 ; 24 ---/
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        // $table_name = $this->input->post_secure('pdg_table');
        // $table_name = $this->input->defend_filter(4, $table_name);
        $table_name = $this->default_table_name;
        $at_system->check_access('inside_' . $table_name, 'view');

        $cell_id = intval($this->input->post_secure('cell_id'));

        // Load Table Config
        $table_class = $this->default_table_config_path.$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        //i--- Get Data by ID ; inside_custom_cruds ; torrison ; 01.06.2020 ; 25 ---/
        $edit_cell_arr = $this->get_table_cell_arr($table_obj, $cell_id);

        //i--- Make Edit Inputs Array ; inside_custom_cruds ; torrison ; 01.06.2020 ; 26 ---/
        foreach ($table_obj->table_columns as $config_row) { // Columns Inputs
            $tmp_name = $config_row['name'];
            $config_row['value'] = $edit_cell_arr[$tmp_name];

            $config_row['cell_id'] = $cell_id;
            $config_row['table'] = $table_name;
            $config_row['make_type'] = 'edit';
            $config_row['cell_row'] = $edit_cell_arr;

            if (isset($config_row['input_type'])) $gen_inputs_arr[$tmp_name] = $at_system->make_input("input_form", $config_row);
        }
        if (isset($table_obj->adv_rel_inputs)) { // Relation Inputs
            foreach ($table_obj->adv_rel_inputs as $rel_input_row) {
                $rel_input_row['base_table'] = $table_name;
                $rel_input_row['make_type'] = 'edit';
                $gen_inputs_arr[$rel_input_row['name']] = $at_system->make_rel_input("input_form", $rel_input_row, $cell_id);
            }
        }

        //i---  Wear edit form View ; inside_custom_cruds ; torrison ; 01.06.2020 ; 27 ---/
        $this->data['edit_cell_arr'] = $edit_cell_arr;
        $this->data['gen_inputs_arr'] = $gen_inputs_arr;
        $this->data['table_name'] = $table_name;
        $this->data['dialog_id'] = $this->input->post_secure('dialog_id');
        $this->data['cell_id'] = $cell_id;

        $this->data['key_field'] = $table_obj->table_config['key'];
        $this->data['table_config'] = $table_obj->table_config;
        $this->data['table_columns'] = $table_obj->table_columns;
        if (isset($table_obj->adv_rel_inputs)) $this->data['adv_rel_inputs'] = $table_obj->adv_rel_inputs;

        echo $this->view->render_to_var($this->data, $this->default_inside_edit_form_path, $template_folder = 'inside_admin_template');
    }


    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function edit_request() {
        //i---  Edit Save Data ; inside_custom_cruds ; torrison ; 01.06.2020 ; 28 ---/
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        // $table_name = $this->input->get_secure('table_name');
        $table_name = $this->default_table_name;
        $tab = $this->input->get_secure('tab');
        $cell_id = $this->input->get_secure('cell_id');
        $at_system->check_access('inside_' . $table_name, 'edit');
        $this->update_table_cell($table_name, $tab, $cell_id);

        // String Answer
        echo "Data Saved!";
    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function fast_edit() {
        //i---  Fast Edit Save Data ; inside_custom_cruds ; torrison ; 01.06.2020 ; 29 ---/
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        // $table_name = $this->input->post_secure('table');
        $table_name = $this->default_table_name;
        $cell_id = intval($_POST['line_id']);
        $at_system->check_access('inside_' . $table_name, 'edit');
        $table_class = $this->default_table_config_path.$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        //i---  Fast Edit Save DataBase UPDATE ; inside_custom_cruds ; torrison ; 01.06.2020 ; 30 ---/
        $this->db->update(
            $table_obj->db_table_name,
            Array($this->input->post_secure('column') => $this->input->post_secure('value')),
            " WHERE `".str_replace('`','',($this->input->post_secure('key_id')))."` = ".intval($cell_id)
        );

        // String Answer
        echo "1";

    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function add_request() {
        //i---  Add Save Data ; inside_custom_cruds ; torrison ; 01.06.2020 ; 31 ---/
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        // $table_name = $this->input->get_secure('table_name');
        $table_name = $this->default_table_name;
        $table_class = $this->default_table_config_path.$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();
        $at_system->check_access('inside_' . $table_name, 'edit');

        $this->insert_table_cell($table_name);

        // String Answer
        echo "Data Saved!";
    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function del_request() {
        //i---  Delete Save Data ; inside_custom_cruds ; torrison ; 01.06.2020 ; 32 ---/
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        // $table_name = $this->input->get_secure('table_name');
        $table_name = $this->default_table_name;
        $at_system->check_access('inside_' . $table_name, 'edit');
        $result = $this->del_table_cell($table_name);

        // String Answer
        echo $result." Deleted!";
    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function update_table_cell($table_name, $tab, $cell_id) {
        //i--- UPDATE Data [Model Method] ; inside_custom_cruds ; torrison ; 01.06.2020 ; 33 ---/
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        $db =& $GLOBALS['Commons']['db'];
        $input =& $GLOBALS['Commons']['input'];
        $user =& $GLOBALS['Commons']['user'];

        // Load Table Config
        $table_class = $this->default_table_config_path.$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        //i--- Make Update Array by Input Fields ; inside_custom_cruds ; torrison ; 01.06.2020 ; 33 ---/
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


        //i--- Make Update SQL Request ; inside_custom_cruds ; torrison ; 01.06.2020 ; 34 ---/
        if (count ($update_array) > 0) $db->update($table_obj->db_table_name, $update_array, ' WHERE `'.$table_obj->table_config['key']."` = ".intval($cell_id));

        //i--- Insert Request Data to the Changes Log ; inside_custom_cruds ; torrison ; 01.06.2020 ; 35 ---/
        $db->insert(
            'inside_log',
            Array(
                'log_table' => $table_obj->db_table_name,
                'log_datetime' => time(),
                'log_sql' => 'UPDATE '.$table_obj->db_table_name.print_r($update_array, true).' WHERE `'.$table_obj->table_config['key']."` = ".intval($cell_id),
                'log_user_id' => $user['id'])
        );

        //i--- Run Relations Inputs Update/Save Methods ; inside_custom_cruds ; torrison ; 01.06.2020 ; 36 ---/
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

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function insert_table_cell($table_name) {
        //i--- INSERT Data [Model Method] ; inside_custom_cruds ; torrison ; 01.06.2020 ; 37 ---/
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();
        $db =& $GLOBALS['Commons']['db'];
        $input =& $GLOBALS['Commons']['input'];
        $user =& $GLOBALS['Commons']['user'];

        // Load Table Config
        $table_class = $this->default_table_config_path.$table_name;
        if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
        $table_obj = new $table_class();
        $table_obj->init();

        //i--- Make Insert Array by Input Fields ; inside_custom_cruds ; torrison ; 01.06.2020 ; 38 ---/
        $insert_array = Array();
        foreach ($table_obj->table_columns as $config_row) {
            $tmp_name = $config_row['name'];

            if (!isset ($config_row['defend_filter'])) $config_row['defend_filter'] = 1;
            $config_row['value'] = $input->defend_filter(intval($config_row['defend_filter']), @$_POST[$tmp_name]);

            $config_row['table'] = $table_obj->db_table_name;
            $config_row['post_array'] = $_POST;
            $config_row['save_type'] = 'insert';

            //i--- Run Columns Save Methods (Optional) ; inside_custom_cruds ; torrison ; 01.06.2020 ; 39 ---/
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

        //i--- Make INSERT SQL Request ; inside_custom_cruds ; torrison ; 01.06.2020 ; 40 ---/
        if (count ($insert_array) > 0) $db->insert($table_obj->db_table_name, $insert_array);

        $cell_id = $db->last_id();

        //i--- Insert Request Data to the Changes Log ; inside_custom_cruds ; torrison ; 01.06.2020 ; 41 ---/
        $db->insert('inside_log', Array('log_table' => $table_obj->db_table_name, 'log_datetime' => time(), 'log_sql' => 'INSERT '.$table_obj->db_table_name.print_r($insert_array, true), 'log_user_id' => $user['id']));

        //i--- Run Relations Inputs Add Methods ; inside_custom_cruds ; torrison ; 01.06.2020 ; 42 ---/
        if (isset($table_obj->adv_rel_inputs))
        {
            foreach ($table_obj->adv_rel_inputs as $rel_input_arr) {
                $rel_input_arr['base_table'] = $table_obj->db_table_name;
                $at_system->make_rel_input("db_add", $rel_input_arr, $cell_id);
            }
        }
        return "Ok!";
    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function del_table_cell($table_name) {
        //i--- DELETE Data [Model Method] ; inside_custom_cruds ; torrison ; 01.06.2020 ; 43 ---/
        if (isset($_POST['del_ids'])) {
            $db =& $GLOBALS['Commons']['db'];
            $user =& $GLOBALS['Commons']['user'];
            $table_class = $this->default_table_config_path.$table_name;
            if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
            $table_obj = new $table_class();
            $table_obj->init();

            foreach ($_POST['del_ids'] as $del_id)
            {
                //i--- Make SQL DELETE Requests and Save Data to Changes Log ; inside_custom_cruds ; torrison ; 01.06.2020 ; 44 ---/

                echo intval ($del_id);
                $db->run_sql("DELETE FROM ".$table_obj->db_table_name." WHERE ".$table_obj->table_config['key']." = ".intval($del_id));

                $db->insert('inside_log', Array('log_table' => $table_obj->db_table_name, 'log_datetime' => time(), 'log_sql' => 'DELETE id = '.$del_id.' FROM '.$table_obj->db_table_name, 'log_user_id' => $user['id']));
            }
        }
        return "Ok!";
    }

    //i--- ---------------------------------------- ; inside_custom_cruds ; torrison ; 01.06.2020 ; - ---/
    public function get_table_cell_arr($table_obj, $cell_id) {
        //i--- Get Data by ID [Model Method] ; inside_custom_cruds ; torrison ; 01.06.2020 ; 45 ---/
        $db =& $GLOBALS['Commons']['db'];
        $array = $db->sql_get_data("SELECT * FROM `".$table_obj->db_table_name."` WHERE `".$table_obj->table_config['key']."` = ".intval($cell_id)." LIMIT 1");
        // Return One Row!
        return $array[0];
    }
}