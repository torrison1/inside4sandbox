<?php

namespace Inside4\InsideTools;

Class InsideModularSystem
{

    var $db;
    var $view;

    public function check_update_modules_files_relations()
    {
        // TO DO

        // DELETE ALL Relations
        // Foreach ALL Files
        // - IF File in Module ADD
        // - IF Block in File ADD

        $obj = new \Inside4\InsideTools\InsideProjectFiles;
        $obj->view();

    }

    public function check_update_modules_database_relations()
    {
        // TO DO

        // if Admin Check ( TO DO )
        $obj = new \Inside4\InsideTools\InsideDatabaseView;
        $obj->db =& $this->db;
        $obj->view();

        // DELETE ALL Relations
        // Foreach ALL Tables
        // - IF Table in Module ADD
        // - IF Column in Module ADD

    }

    public function get_modules_arr()
    {
        $query = "SELECT * FROM inside_modules WHERE off != 1 ORDER BY priority";
        $data = $this->db->sql_get_data($query);
        return $data;
    }

    public function module_info($system_name = '')
    {
        if ($system_name == '' OR $system_name == 'undefined') exit();
        $this->data['system_name'] = $system_name;

        $sql = "SELECT *
										FROM inside_modules
										WHERE system_name = " . $this->db->quote($system_name) . "
										LIMIT 1
										";

        $this->data['module_arr'] = $this->db->sql_get_data($sql);

        if (isset ($this->data['module_arr'][0])) $this->data['module_arr'] = $this->data['module_arr'][0];
        else exit();

        $this->data['module_name'] = $this->data['module_arr']['name'];
        $this->data['module_description'] = $this->data['module_arr']['description'];

        $this->data['module_img'] = '';
        if ($this->data['module_arr']['img'] != '') ;
        $this->data['module_img'] = '/Uploads/inside_modules_img/' . $this->data['module_arr']['img'];

        $this->data['module_terminal'] = '';
        if (isset($this->data['module_arr']['terminal'])) $this->data['module_terminal'] = $this->data['module_arr']['terminal'];

        $this->data['module_how_to_use'] = '';
        if (isset($this->data['module_arr']['how_to_use'])) $this->data['module_how_to_use'] = $this->data['module_arr']['how_to_use'];

        $system_elements = '';
        if (isset ($this->data['module_arr']['system_elements_json']) AND ($this->data['module_arr']['system_elements_json'] != '')) {
            $json = $this->data['module_arr']['system_elements_json'];
            // $json = str_replace('\n', '', $json);
            // $json = str_replace(' ', '', $json);
            $this->data['system_elements'] = json_decode($json, true);

            // echo $json;
            // echo "| >>> "; echo json_last_error();
            // print_r($this->data['system_elements']);

            foreach ($this->data['system_elements'] as $link) {
                $system_elements .= '<div><a href="' . $link['link'] . '">' . $link['name'] . '</a></div>';
            }
        }
        $this->data['system_elements'] = $system_elements;

        // Manual Info
        // print_r( $this->data['module_arr']);
        $this->data['manual_html'] = '';
        if (isset ($this->data['module_arr']['files_json']) AND ($this->data['module_arr']['files_json'] != '')) {
            $json = $this->data['module_arr']['files_json'];
            $module['files'] = json_decode($json, true);

            // echo $json;

            ob_start();
            foreach ($module['files'] as $file) { ?>

                <b><?= $file['name'] ?></b> <?= $file['filename'] ?> :
                <a href="https://github.com/torrison1/inside4sandbox/blob/master/<?=$file['path'] ?>" target="_blank"><?= $file['path'] ?></a>
                | <?= $file['type'] ?>
                <br>
                <div style="border: 1px solid silver; padding: 10px; margin-top: 5px; width: 60%">
                    <?php

                    // Find info in file:
                    // echo $_SERVER['DOCUMENT_ROOT'].$file['path'];
                    $string = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $file['path']);

                    $comments_arr = Array();

                    $start = '//i--- ';
                    $finish = ' ---/';
                    $format = 'text ; module ; who ; update_time ; point_id';

                    // --------- Visualize Comments ------------ //
                    if (strpos($string, $start) > 0) {
                        $tmp_arr = explode($start, $string);
                        foreach ($tmp_arr as $tmp) {
                            if (strpos($tmp, $finish) > 0) {
                                $tmp_arr2 = explode($finish, $tmp);
                                $tmp_3 = explode(' ; ', $tmp_arr2[0]);
                                $comments_arr[] = Array(
                                    'text' => @$tmp_3[0],
                                    'module' => @$tmp_3[1],
                                    'who' => @$tmp_3[2],
                                    'update_time' => @$tmp_3[3],
                                    'id' => @$tmp_3[4],
                                    'color' => @$tmp_3[5],
                                );
                            }
                        }
                    }

                    foreach ($comments_arr as $comment) {
                        if ($comment['module'] == $system_name) {
                            ?>
                            <div<?php if (isset($comment['color']) and $comment['color'] != '') { ?> style="color: <?= $comment['color'] ?>;"<?php } ?>>
                                - <b><?= $comment['text'] ?></b> [ <?= $comment['id'] ?> ]
                                <?= $comment['who'] ?> <?= $comment['update_time'] ?>
                            </div>
                        <?php }
                    } ?>
                </div>
                <br>
            <?php }
            $this->data['manual_html'] = ob_get_clean();
        }

        return $this->view->render_to_var($this->data, 'Parts/module_info.php', $template_folder = 'inside_admin_template');

        }

}