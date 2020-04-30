<?php
namespace Inside4\InsideAutoTables\Inputs;

class Select_from_Table {


	public function input_form($input_array)
	{
		$db =& $GLOBALS['Commons']['db'];
		if (isset($input_array['select_sql'])) $sql = $input_array['select_sql'];
		else $sql = "SELECT ".$input_array['select_index'].", ".$input_array['select_field']." FROM ".$input_array['select_table']." ORDER BY ".$input_array['select_field']." ASC";
		$res = $db->sql_get_data($sql);
		$data = '';
		$i=0;
  		foreach ($res as $row)
  		{
  		$variants[$i]['name'] = $row [$input_array['select_field']];
  		$tmp_index = $input_array['select_index'];
		$variants[$i]['id'] = $row [$tmp_index];
  		$i++;
  		}
  		$data .= "
  		<select name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" class=\"input form-control selectpicker\" data-live-search=\"true\">
  		<option value=\"\">Не выбрано</option>
  		";
  		$i=0;
  		while (isset ($variants[$i]['id']))
  		{
  			if ($input_array['value'] == $variants[$i]['id']) $selected = " SELECTED"; else $selected = "";
    		$data .= "<option value=\"".$variants[$i]['id']."\"".$selected.">".$variants[$i]['name']."</option>";
    		$i++;
  		}
  		$data .= "
  		</select>\n\n
  		";
  		return $data;
	}

	public function crud_view($input_array) {
        $db =& $GLOBALS['Commons']['db'];

        // >> TO DO | need refactoring and make only 1 request by page OR LEFT JOIN in MAIN REQUEST

        if (!isset($GLOBALS['tmp_arrays']['table'][$input_array['select_table']])) {
            $sql = "SELECT ".$input_array['select_field'].",".$input_array['select_index']." FROM ".$input_array['select_table'];
            $res = $db->sql_get_data($sql);

            // print_r($res);
            $res_fast = Array();
            foreach ($res as $row) {
                $res_fast[$row[$input_array['select_index']]] = $row[$input_array['select_field']];
            }
            // print_r($res_fast);

            $GLOBALS['tmp_arrays']['table'][$input_array['select_table']] = $res_fast;
        }
        $res = $GLOBALS['tmp_arrays']['table'][$input_array['select_table']];

		if(isset($res[$input_array['value']])) return $res[$input_array['value']];
		else return '';
	}


}
