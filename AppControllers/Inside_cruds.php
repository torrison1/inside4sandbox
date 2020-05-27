<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

// Inside Custom CRUD Interface Example

Class Inside_cruds extends BaseController
{
    public function requests()
    {
        $table_name = 'It_requests';

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

        //  ===================== Access system adding functionality (view only for creator) ==============
        if (isset($table_config['access_system']) AND !$auth->is_admin()) {
            foreach ($return['res'] as $key => $row) {
                $creators_access_users = array();

                if (isset($table_config['access_creator_fields'])) {
                    foreach ($table_config['access_creator_fields'] as $field_name) {
                        if (isset($row[$field_name]) AND $row[$field_name] != 0) {
                            $creators_access_users[] = $row[$field_name];
                        }
                    }
                }


                if (
                    $row['ar_creator_view']
                    AND !$row['ar_all_view']
                    AND !$row['ar_group_view']
                    AND (
                        (!in_array($current_user, $creators_access_users) AND $row['ar_user_id'] != $current_user)
                        OR !$user_in_work_groups
                    )
                )
                {
                    unset($return['res'][$key]);
                }
            }
        }
        //  ===================== Access system adding functionality ==============

        return $return;

    }
}