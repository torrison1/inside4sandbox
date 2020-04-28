<?php
namespace Inside4\InsideAutoTables;

use Inside4\Security\Security as Security;

Class AutoTablesSystem
{
    public function init() {

    }

    public function generate_top_filters(&$table_obj) {
            $filters = '';
            // Make Filters
            $filters = Array();
            foreach ($table_obj->table_columns as $config_row) {
                if (isset ($config_row['filter'])) {

                    if (isset($config_row['default_filter_value']))
                        $config_row['value'] = $config_row['default_filter_value'];
                    else $config_row['value'] = '';

                    // Filter by current user id
                    if (isset($config_row['filter_current_user_id']))
                        $config_row['value'] = $this->user->id;

                    if (isset($_GET[$config_row['name']]))
                        $config_row['value'] = Security::xss_cleaner($_GET[$config_row['name']]);

                    if (isset($config_row['input_type'])) {
                        if (!isset($config_row['filters_tab'])) $config_row['filters_tab'] = 'Main';
                        if (!isset($config_row['filters_column'])) $config_row['filters_column'] = 1;
                        if (isset($config_row['filter_method']))
                            $filter_input = $this->make_input($config_row['filter_method'], $config_row);
                        else $filter_input = $this->make_input("input_filter", $config_row);
                        $filters[] = Array(
                            'text' => $config_row['text'],
                            'input' => $filter_input,//$this->inside_lib->make_input("input_filter", $config_row), // add new filter method
                            'filters_tab' => $config_row['filters_tab'],
                            'filters_column' => $config_row['filters_column'],
                        );
                    }

                }
            }
            return $filters;
    }

    public function make_input($part, $input_array)
    {
        if (isset($input_array['input_type'])) {
            if (!isset($input_array['width'])) $input_array['width'] = 400;
            $type = $input_array['input_type'];
            $type = str_replace("-", "_", $type); // Fix Minus to C++ style

            $model_name = "make_input_" . $type;
            // $CI =& get_instance();

            $input_class = "\\Inside4\\InsideAutoTables\\Inputs\\".ucfirst($type);

            if (class_exists($input_class)) {

                $input_obj = new $input_class();

                if (method_exists($input_obj, $part)) {
                    return $input_obj->$part($input_array);
                } else if ($part == "input_filter") {
                    $input_array['width'] = 100;
                    return $input_obj->input_form($input_array) . "<br />\n"; // Default input for form
                } else if ($part == "db_save") {
                    return $input_array['value']; // Default value without changes
                } else if ($part == "crud_view") {
                    return $input_array['value']; // Default value without changes
                }

            } else return "File not found: " . APPPATH . 'models/inside/inputs/' . $type . '.php';
        }
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
            /* OLD LIKE FILTER FUNCTIONALITY*/
            /*else {
                if ((isset($filter['fsearch'])) && (strlen($filter['fsearch']) > 1))
                    $where .= " " . $table_name . '.' . $config_row['name'] . " like '%" . $filter['fsearch'] . "%' OR"; // here also was ambiguous

                if ((isset($filter['fkey'])) && (intval($filter['fkey']) > 0))
                    $where .= " " . $table_name . '.' . $table_config['key'] . " = '" . $filter['fkey'] . "' OR"; //here also was ambiguous
            }*/
            /* OLD LIKE FILTER FUNCTIONALITY*/

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


        // ================ Status filter ======================
        if (isset($table_config['status_rel_name'])) {

            foreach ($adv_rel_inputs as $rel_row) {
                if ($rel_row['name'] == $table_config['status_rel_name']) {
                    $status_config = $rel_row;
                }
            }

            $where .= " AND ( FALSE ";
            if(isset($_POST['status_filter'])) {
                foreach ($_POST['status_filter'] as $status) {
                    $where .= " OR " . $table_name . '.' . $status_config['status_id_field'] . " = " . intval($status) . ""; //here also was ambiguous
                }
            } else {
                foreach ($status_config['status_options'] as $status) {
                    if(isset($status['default_filter']) && $status['default_filter']) {
                        $where .= " OR " . $table_name . '.' . $status_config['status_id_field'] . " = " . intval($status['status_id']) . ""; //here also was ambiguous
                    }
                }
            }
            $where .= " ) ";
        }
        // ================ Status filter =======================



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