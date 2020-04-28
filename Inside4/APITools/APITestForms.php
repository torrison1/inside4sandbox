<?php

namespace Inside4\APITools;

Class APITestForms
{

    public function demo_form_api_test($method, $class, $form_method, $params = [])
    {
        $api_name = $class . '->' . $method .'()'; // Формруем название api
        $form_method = ($form_method); // Метод формы
        $class = str_replace('AppControllers\\', '', $class);
        $url = '/' .( $class) . '/' . $method; // Action формы
        $api_test_form = new \Inside4\APITools\APITestForms;
        echo $api_test_form->make_api_test_form($api_name, $form_method ,$url, $params);
        exit();
    }

    //i--- Library for API test form ; inside_api_test_forms ; torrison ; 01.08.2018 ; 4a1.4 ---/
    public function make_api_test_form($name_api, $form_method, $url, $fields = [], $aswers_json_examples_arr = [])
    {
        $result = '
        <html>
        <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.full.min.js"></script>
        </head>
        <body>
        ';

        //i--- Generate form ; inside_api_test_forms ; torrison ; 01.08.2018 ; 4a1.5 ---/
        $result .= "<h2>$name_api</h2><p>url: <i>$url</i> $form_method</p>\n";
        $result.= "<form action='$url' method='$form_method'>\n";
        if(isset($fields['data']) AND $fields['data']) {
            foreach ($fields['data'] as $name_field => $row) {
                if ($row['type'] == 'text') {
                    $result .= "<p>\n";
                    $result .= "<label>" . ($name_field) . "</label><br/>\n";
                    $result .= "<input name='{$name_field}' type='text' value='" . $row["value"] . "'/>\n";
                    $result .= "</p>\n\n";
                } else if ($row['type'] == 'textarea') {
                    $result .= "<p>\n";
                    $result .= "<label>" . ($name_field) . "</label><br/>\n";
                    $result .= "<textarea rows='6' cols='55' name='{$name_field}'>" . $row["value"] . "</textarea>\n";
                    $result .= "</p>\n\n";
                } else if ($row['type'] == 'select_table') {
                    $CI =& get_instance();
                    if(isset($row['custom_sql'])) {
                        $sql = $row['custom_sql'];
                    } else {
                        $sql = "SELECT " . $row['select_field'] . " AS select_field, " . $row['select_index'] . " AS select_index FROM " . $row['select_table'];
                    }
                    $query = $CI->db->query($sql);
                    if ($query->num_rows() > 0) {
                        $result .= "<p>\n";
                        $result .= "<label>" . ($name_field) . "</label><br/>\n";
                        $name_field = isset($row['multiple']) ? $name_field . "[]" : $name_field ;
                        $multiple = isset($row['multiple']) ? " multiple" : "";
                        $result .= "<select name='{$name_field}'$multiple>\n";
                        foreach ($query->result() as $row_query) {
                            $result .= "<option value='" . $row_query->select_index . "'>" . $row_query->select_field . "</option>\n";
                        }
                        $result .= "</select>\n";
                        $result .= "</p>\n\n";
                    }
                }else if ($row['type'] == 'select_autocomplete') {
                    $CI =& get_instance();
                    if(isset($row['custom_sql'])) {
                        $sql = $row['custom_sql'];
                    } else {
                        $sql = "SELECT " . $row['select_field'] . " AS select_field, " . $row['select_index'] . " AS select_index FROM " . $row['select_table'];
                    }
                    $query = $CI->db->query($sql);
                    if ($query->num_rows() > 0) {
                        $result .= '

                        <script>
                            $(document).ready(function() { $("#autocomplete_'.$name_field.'").select2(); });
                        </script>
                        ';
                        $result .= "<p>\n";
                        $result .= "<label>" . ($name_field) . "</label><br/>\n";
                        $name_field = isset($row['multiple']) ? $name_field . "[]" : $name_field ;
                        $multiple = isset($row['multiple']) ? " multiple" : "";
                        $result .= "<select name='{$name_field}'$multiple id='autocomplete_{$name_field}'>\n";
                        foreach ($query->result() as $row_query) {
                            $result .= "<option value='" . $row_query->select_index . "'>" . $row_query->select_field . "</option>\n";
                        }
                        $result .= "</select>\n";
                        $result .= "</p>\n\n";
                    }
                }else if ($row['type'] == 'select') {
                    if (count($row['variants']) > 0) {
                        $result .= "<p>\n";
                        $result .= "<label>" . ($name_field) . "</label><br/>\n";
                        $name_field = isset($row['multiple']) ? $name_field . "[]" : $name_field ;
                        $multiple = isset($row['multiple']) ? " multiple" : "";
                        $result .= "<select name='{$name_field}'$multiple>\n";
                        foreach ($row['variants'] as $key_var => $val_var) {
                            $result .= "<option value='" . $key_var . "'>" . $val_var . "</option>\n";
                        }
                        $result .= "</select>\n";
                        $result .= "</p>\n\n";
                    }
                } else if ($row['type'] == 'checkbox') {
                    $result .= "<p>\n";
                    $result .= "<label>" . ($name_field) . "</label><br/>\n";
                    $name_field = isset($row['multiple']) ? $name_field . "[]" : $name_field ;
                    foreach ($row['variants'] as $key_var => $val_var) {
                        $result .= "<input type='checkbox' name='{$name_field}' value='{$key_var}'>" . $val_var . "\n";
                    }
                    $result .= "</p>\n\n";
                } else if ($row['type'] == 'radio') {
                    $result .= "<p>\n";
                    $result .= "<label>" . ($name_field) . "</label><br/>\n";
                    foreach ($row['variants'] as $key_var => $val_var) {
                        $result .= "<input type='radio' name='{$name_field}' value='{$key_var}'>" . $val_var . "\n";
                    }
                    $result .= "</p>\n\n";
                }else if($row['type'] == 'file'){
                    $result .= "<p>\n";
                    $result .= "<label>" . ($name_field) . "</label><br/>\n";
                    $result .= "<input name='{$name_field}' type='file' value='" . $row["value"] . "'/>\n";
                    $result .= "</p>\n\n";
                }
            }
        }
        $result.="<input type='hidden' name='show_json' value='1'>\n";
        $result.="<input type='submit' value='Send'>\n";
        $result.="</form>\n";

        //i--- Generate JSON texts ; inside_api_test_forms ; torrison ; 01.08.2018 ; 4a1.6 ---/
        // print_r($aswers_json_examples_arr);
        foreach ($aswers_json_examples_arr as $json_example_text) {
            $result.="<div style=\"margin-top: 20px; padding: 10px; border: 2px solid silver;\">\n";
            $json_example_text = str_replace('\n','<br>',$json_example_text);
            $json_example_text = str_replace(' ','&nbsp;',$json_example_text);
            $result.=$json_example_text;
            $result.="</div>\n";
        }

        if(isset($fields['help']) AND $fields['help']) {
            $result.="<div style='width: 400px; border: 1px solid black;'>{$fields['help']}</div>";
        }

        $result .= "</body></html>";
        return $result;
    }

}