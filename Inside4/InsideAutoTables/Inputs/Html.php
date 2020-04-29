<?php
namespace Inside4\InsideAutoTables\Inputs;

class Html {


	public function input_form($input_array)
	{
		// NEED To Remove to HTML input
        $auth =& $GLOBALS['Commons']['auth'];
		if ($auth->in_groups(Array('content','admin'))) {
			$_SESSION['kcf'] = 'a_dHgykd_sd7w';
		}

    	if (!isset ($input_array['height'])) {$input_array['width'] = 500; $input_array['height'] = 200;}
		if (!isset ($input_array['width_units'])) {$input_array['width_units'] = 'px';}
		if (!isset ($input_array['height_units'])) {$input_array['height_units'] = 'px';}
    	return "<br /><textarea name=\"".$input_array['name']."\" id=\"".$input_array['name']."\" class=\"input html_editor\" style=\"width:".$input_array['width']."".$input_array['width_units'].";height:".$input_array['height']."".$input_array['height_units'].";\">".$input_array['value']."</textarea>";
	}


}