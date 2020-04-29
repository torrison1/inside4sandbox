<?php
namespace Inside4\InsideAutoTables\Inputs;

class Many2many {


	public function input_form($input_array, $cell_id)
	{
        $db =& $GLOBALS['Commons']['db'];
        $res = $db->sql_get_data("SELECT * from ".$input_array['table']);

        $selected_arr = $db->sql_get_data("SELECT * from ".$input_array['rel_table']." WHERE ".$input_array['rel_key']." = ".intval($cell_id));

		// For Debug
		//print_r($selected_arr);

		$data = '<select name="'.$input_array['name'].'[]" id="'.$input_array['name'].'" multiple="multiple"  class="multiselect pdg_mselect">';
		
		foreach ($res as $join_row)
		{
		  $selected = '';
		  foreach ($selected_arr as $rel_row) {if ($rel_row[$input_array['rel_join']] == $join_row[$input_array['join_key']]) $selected = " SELECTED";}
		  
		  $data .= '<option value="'.$join_row[$input_array['join_key']].'"'.$selected.'>'.$join_row[$input_array['join_name']].' ['.$join_row[$input_array['join_key']].']</option>';
		}
		
		$data .= '</select><br /><a href="/inside/table/'.$input_array['table'].'" target="_blank">Open join table</a><br /><br />';
		
		return $data;
	}
	public function db_save($input_array, $cell_id)
	{
        $db =& $GLOBALS['Commons']['db'];
		$db->run_sql("DELETE FROM ".$input_array['rel_table']." WHERE ".$input_array['rel_key']." = '".$cell_id."'");
		if ( isset($_POST[$input_array['name']]) )
		{
			foreach ($_POST[$input_array['name']] as $join_id)
			{
			$join_id = intval($join_id);
			$data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                $db->insert($input_array['rel_table'], $data);
			}	
		}
	}
	public function db_add($input_array, $cell_id)
	{
        $db =& $GLOBALS['Commons']['db'];

		if ( isset($_POST[$input_array['name']]) )
			{
				foreach ($_POST[$input_array['name']] as $join_id)
				{
				$join_id = intval($join_id);
				$data = array($input_array['rel_key'] => $cell_id, $input_array['rel_join'] => $join_id);
                    $db->insert($input_array['rel_table'], $data);
				}	
			}
	}

}
