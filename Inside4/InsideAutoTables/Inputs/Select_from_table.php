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
		$sql = "SELECT ".$input_array['select_field']." FROM ".$input_array['select_table']." WHERE ".$input_array['select_index']." = ".$db->quote($input_array['value'])."";
        $res = $db->sql_get_data($sql);
		if(isset($res[$input_array['select_field']])) return $res[$input_array['select_field']];
		else return '';
	}


}
