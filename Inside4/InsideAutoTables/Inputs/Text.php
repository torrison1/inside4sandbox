<?php
namespace Inside4\InsideAutoTables\Inputs;

class Text {


	public function input_form ($input_array)
	{
		return '<input class="form-control" type="text" id="'.$input_array['name'].'" name="'.$input_array['name'].'" value="'.$input_array['value'].'" />';
	}

	public function input_filter ($input_array)
	{
		//return '<input style="width:100px; height: 10px; border-color:green;" type="text" id="'.$input_array['name'].'" name="'.$input_array['name'].'" value="'.$input_array['value'].'" /><br />';
		return '<input style="padding: 10px; width: 100%; height: 34px; border: 1px solid #cccccc;" type="text" id="'.$input_array['name'].'" name="'.$input_array['name'].'" value="'.$input_array['value'].'" /><br />';

	}

	public function like_filter($input_array)
	{
		return '<input style="padding: 10px; width: 100%; height: 34px; border: 1px solid #cccccc;" type="text" id="' . $input_array['name'] . '" name="' . $input_array['name'] . '" value="' . $input_array['value'] . '" /><br />';
	}

	public function comparison_filter($input_array)
	{
		return '<br><div class="comparison_filter" style="text-align: center;"><input type="hidden" id="comparison_' . $input_array['name'] . '" name="comparison_' . $input_array['name'] . '" value="1" />
                <div style="display: inline-block; width: 49%">От: <input style="padding: 10px; width: 77.5%; height: 34px; border: 1px solid #cccccc;" type="text" id="comparison_' . $input_array['name'] . '" name="from_' . $input_array['name'] . '" value="" /></div>
                <div style="display: inline-block; width: 49%">До: <input style="padding: 10px; width: 77.5%; height: 34px; border: 1px solid #cccccc;" type="text" id="comparison_' . $input_array['name'] . '" name="to_' . $input_array['name'] . '" value="" /></div></div>';
	}
}