<?php

namespace Inside4\InsideAutoTables\Inputs;

class Group_new_access {


    public function input_form($input_array, $cell_id)
    {

        $db =& $GLOBALS['Commons']['db'];
        ob_start();

        $access_arr = $db->sql_get_data("
            SELECT inside_groups_access.*
                    FROM inside_groups_access
                    WHERE group_id = ".intval($cell_id)."
        ");

        $access_arr_fast = Array();
        foreach ($access_arr as $access_row) {
            $access_arr_fast[$access_row['module_id']] = Array();
            if ($access_row['module_init'] == 1) $access_arr_fast[$access_row['module_id']]['init'] = 1;
            if ($access_row['module_view'] == 1) $access_arr_fast[$access_row['module_id']]['view'] = 1;
            if ($access_row['module_edit'] == 1) $access_arr_fast[$access_row['module_id']]['edit'] = 1;
        };
        // print_r($access_arr_fast);

        $menu_arr = $this->AdminTreeMenu();

        foreach ($menu_arr as $row)
        {
// No Shift - is row, Shift is open/close parents ul tags
            if (!isset($row['shift']))
            {
                // Link or Static block
                if ($row['url'] != '') $text = '<a href="'.$row['url'].'" title="'.$row['name'].'">'.$row['name'].'</a>';
                else $text = '<a>'.$row['name'].'</a>';
                // Custom Width
                if ($row['width'] > 0) $width = "width: ".$row['width']."px;";
                else $width = "";
                echo '<li style="'.$width.'">'.$text;
                $init_checked = '';
                $view_checked = '';
                $edit_checked = '';

                if (isset($access_arr_fast[$row['id']]['init'])) $init_checked = ' checked';
                if (isset($access_arr_fast[$row['id']]['view'])) $view_checked = ' checked';
                if (isset($access_arr_fast[$row['id']]['edit'])) $edit_checked = ' checked';

                echo '
                      <span><i class="glyphicon glyphicon-off"></i> <input class="access_checkbox" type="checkbox" value="'.$row['id'].'" access_type="access_init" name="access_init[]"'.$init_checked.'>
                      <i class="glyphicon glyphicon-eye-open"></i> <input class="access_checkbox" type="checkbox" value="'.$row['id'].'" access_type="access_view" name="access_view[]"'.$view_checked.'>
                      <i class="glyphicon glyphicon-edit"></i> <input class="access_checkbox" type="checkbox" value="'.$row['id'].'" access_type="access_edit" name="access_edit[]"'.$edit_checked.'></span>
                ';
                // print_r($row);
                if ($row['haschild'] != 1) echo "</li>";
                else $tmp_width_child = $row['width_child'];
            }
            else
            {
                if ($row['action'] == "open")
                {
                    // Add Childs Width Style
                    if ( (isset($tmp_width_child)) && ($tmp_width_child > 0) ) $width_child = "width: ".$tmp_width_child."px;";
                    else $width_child = "";

                    echo "\n".'<ul style="'.$width_child.'">'."\n";
                    $tmp_width_child = '';
                }
                if ($row['action'] == "close") echo "\n</ul></li>\n";
            }
        }

?>
        <style>

            #access_new li span{
                position: absolute;
                left: 350px;
            }
        </style>
        <script>
            $(function(){

                var fast_check_start;
                $('.access_checkbox').on('mousedown', function(){
                    fast_check_start = $(this);
                });
                $('.access_checkbox').on('mouseup', function(){
                    var end_check_element = $(this);
                    var fast_check_start_checked = fast_check_start.is(':checked');

                    if (
                        fast_check_start.attr('name') == end_check_element.attr('name') &&
                        fast_check_start.val() != end_check_element.val()
                    ) {

                        // console.log(fast_check_start.val());
                        // console.log(end_check_element.val());
                        var start_changes = false;

                        $('.access_checkbox[access_type='+end_check_element.attr('access_type')+']').each(function(){

                            if ($(this).val() == fast_check_start.val()) start_changes = true;
                            if ($(this).val() == end_check_element.val()) start_changes = false;

                            if (start_changes) {
                                console.log($(this).val()+' - '+$(this).attr('access_type'));
                                if ( ! fast_check_start_checked) $(this).prop('checked', true);
                                else $(this).prop('checked', false);
                            }

                        });
                        // Final for This Element
                        if ( ! fast_check_start_checked) $(this).prop('checked', true);
                        else $(this).prop('checked', false);
                    }

                });

            });
        </script>
<?php
        return ob_get_clean();
    }


    public function db_save($input_array, $cell_id)
    {

        $db =& $GLOBALS['Commons']['db'];

        $db->run_sql("DELETE FROM inside_groups_access WHERE group_id = '".intval($cell_id)."'");

        $access_save_arr = Array();

        if ( isset($_POST['access_init']) ) { foreach($_POST['access_init'] as $init_modules) {

            $access_save_arr[$init_modules]['module_init'] = 1;

        } }
        if ( isset($_POST['access_view']) ) { foreach($_POST['access_view'] as $init_modules) {

            $access_save_arr[$init_modules]['module_view'] = 1;

        } }
        if ( isset($_POST['access_edit']) ) { foreach($_POST['access_edit'] as $init_modules) {

            $access_save_arr[$init_modules]['module_edit'] = 1;

        } }

        foreach ($access_save_arr as $module_id => $access_arr) {

            $access_arr['group_id'] = $cell_id;
            $access_arr['module_id'] = $module_id;
            // print_r($access_arr); echo "<br /><br />";
            $db->insert('inside_groups_access', $access_arr);
        }

        // $data = array($input_array['table_column_row']['rel_key'] => $cell_id, $input_array['table_column_row']['rel_join'] => $join_id);
        //
    }

    public function AdminTreeMenu()
    {

        $db =& $GLOBALS['Commons']['db'];
        $user =& $GLOBALS['Commons']['user'];

        if (isset($user['id']))
            $user_id = $user['id'];
        else {
            echo "Auth Error!";
            exit();
        }

        $user_groups = $this->GetUserGroups($user_id);
        $sql = "
            SELECT inside_groups_access.module_id
                    FROM inside_groups_access
                    LEFT JOIN inside_top_menu ON inside_top_menu.top_menu_id = inside_groups_access.module_id
                    LEFT JOIN auth_users_groups ON auth_users_groups.group_id = inside_groups_access.group_id
                    WHERE
                    auth_users_groups.user_id = " . intval($user_id) . " AND
                    inside_groups_access.module_init = 1
                    GROUP BY inside_groups_access.module_id
        ";
        $menu_access_arr = $db->sql_get_data($sql);
        $in_menu_fast_arr = Array();
        foreach ($menu_access_arr as $tmp_row) $in_menu_fast_arr[$tmp_row['module_id']] = true;
        // print_r($menu_access_arr);


        $sql = 'SELECT * FROM inside_top_menu
	                                WHERE top_menu_invisible = 0 ORDER BY top_menu_parent_id, top_menu_priority, top_menu_name ASC';

        $res = $db->sql_get_data($sql);

        $i = 0;
        $tmp_id_arr = Array();
        foreach ($res as $row) {
            // Access
            if (isset($in_menu_fast_arr[$row['top_menu_id']]) || in_array('admin', $user_groups)) {
                $tmp_id_arr[] = $row['top_menu_id'];
                $db_array[$i]['id'] = $row['top_menu_id'];
                $db_array[$i]['parent_id'] = $row['top_menu_parent_id'];
                $db_array[$i]['haschild'] = $row['top_menu_haschild'];
                $db_array[$i]['name'] = $row['top_menu_name'];

                $db_array[$i]['name_ru'] = $row['top_menu_name'];
                $db_array[$i]['name_ua'] = $row['top_menu_name'];
                $db_array[$i]['name_en'] = $row['top_menu_name'];
                $db_array[$i]['name_de'] = $row['top_menu_name'];

                $db_array[$i]['url'] = $row['top_menu_url'];
                $db_array[$i]['invisible'] = $row['top_menu_invisible'];
                $db_array[$i]['priority'] = $row['top_menu_priority'];
                $db_array[$i]['width'] = $row['top_menu_width'];
                $db_array[$i]['width_child'] = $row['top_menu_widthchild'];
                $i++;
            }

        }

        // Need Extension: Access System !!! MUST BE FIXED !!!

        // Reset $i
        $i = 0;
        // Parent shift (nesting level)
        $parent_shift = 0;
        // Parent elements work array
        $parent_now = array();
        // Start Parent ID
        $parent_now[$parent_shift] = 0;
        // Temporary var for while
        $stop = false;
        while ($stop != true) {
            // Filtering by Parent and non-added, where we located now
            if ((!isset($db_array[$i]['added'])) && ($db_array[$i]['parent_id'] == $parent_now[$parent_shift])) {
                // If we have found parent
                if ($db_array[$i]['haschild'] == 1) #For HasChild Line
                {
                    // Do Shift inside the parent
                    $parent_shift++;
                    // Add ID of parent_now array
                    $parent_now[$parent_shift] = $db_array[$i]['id'];
                    // Save row to output Array
                    $ready_arr[] = $db_array[$i];
                    // Add system element
                    $ready_arr[] = array("shift" => true, "action" => "open");
                    // Add Added sign to row
                    $db_array[$i]['added'] = true;
                    // Restart cicle
                    $i = 0;
                } else {
                    // Save row to output Array
                    $ready_arr[] = $db_array[$i];
                    // Add Added sign to row
                    $db_array[$i]['added'] = true;
                }

            }

            //$ready_arr[] = $db_array[$i];

            $i++;
            // When id-s ended, we must restart  cicle
            if (!isset($db_array[$i]['id'])) {
                // if we are in the parent, we return to top level
                if ($parent_shift > 0) {
                    $parent_shift--;
                    $i = 0;
                    $ready_arr[] = array("shift" => true, "action" => "close");
                } // or ended cicle
                else $stop = true;
            }
        }

        return $ready_arr;

    }

    public function GetUserGroups($user_id)
    {

        $db =& $GLOBALS['Commons']['db'];

        $sql = "
            SELECT auth_groups.name
                    FROM auth_groups
                    LEFT JOIN auth_users_groups ON auth_users_groups.group_id = auth_groups.id
                    WHERE auth_users_groups.user_id = " . intval($user_id) . "
        ";
        $groups_arr = $db->sql_get_data($sql);
        $user_groups = Array();
        foreach ($groups_arr as $group_row) $user_groups[] = $group_row['name'];

        return $user_groups;

    }

}
