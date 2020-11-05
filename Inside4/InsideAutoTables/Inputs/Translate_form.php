<?php
namespace Inside4\InsideAutoTables\Inputs;

class Translate_Form {


    public function input_form($input_array, $cell_id)
    {
        $db =& $GLOBALS['Commons']['db'];
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $t =& $GLOBALS['Commons']['t'];

        if ($input_array['make_type'] == 'edit')
        {
            $data = '';

            $lang_arr = $t->getLanguages();

            $res = $db->sql_get_data("SELECT * from ".$input_array['table']." WHERE ".$input_array['id_column']." = ".intval($cell_id)." ");;

            foreach ($lang_arr as $lang) { if ($lang['lang_alias'] != $t->defaultLanguage) {

                foreach ($res as $row)
                {
                    if ($row[$input_array['lang_alias_column']] == $lang['lang_alias']) $translate_arr[$lang['lang_alias']] = $row;
                }

            } }



            ob_start();
            ?>
            <script type="text/javascript">
                $(function(){


                    $(".language_select").on('change', function(){
                        var lang = $(this).val();
                        // alert (lang);
                        $(".translate_inputs_holder").hide();
                        $('.translate_inputs_holder input').prop('disabled', true);
                        $('.translate_inputs_holder textarea').prop('disabled', true);

                        $(".translate_inputs_holder."+lang).show();
                        $(".translate_inputs_holder."+lang+" input").prop('disabled', false);
                        $(".translate_inputs_holder."+lang+" textarea").prop('disabled', false);


                    });

                    $(".language_select").change();
                });
            </script>
            <?
            $data .= ob_get_clean();

            $data .= "<input type='hidden' value='".intval($cell_id)."' name='".$input_array['id_column']."' />";
            $data .= "<select class='language_select' name='".$input_array['lang_alias_column']."'>";
            foreach ($lang_arr as $lang) { if ($lang['lang_alias'] != $t->defaultLanguage) {
                $data .= "<option value='".$lang['lang_alias']."'>".$t->get($lang['lang_name'])."</option>";
            } }
            $data .= "</select>";
            $data .= "<br />";

            foreach ($lang_arr as $lang) { if ($lang['lang_alias'] != $t->defaultLanguage) { // For All Languages
                if (isset($translate_arr[$lang['lang_alias']])) $translate_row = $translate_arr[$lang['lang_alias']];
                $data .= "<div class='translate_inputs_holder ".$lang['lang_alias']."'>";
                foreach	($input_array['columns'] as $config) { // Make Inputs

                    if (isset($translate_row[$config['name']]))$config['value'] = $translate_row[$config['name']];
                    else $config['value'] = "";
                    $config['name'] = $config['name']."_".$lang['lang_alias'];
                    $config['make_type'] = 'edit';
                    $data .= "<b>".$config['text']."</b>"."<br />".$at_system->make_input("input_form", $config)."<br /><br />";
                }
                $data .= "</div>";
            } }

            return $data;
        }
        else return "Translates plz, add it in Edit window...";
    }
    public function db_save($input_array, $cell_id)
    {

        $db =& $GLOBALS['Commons']['db'];
        $input =& $GLOBALS['Commons']['input'];
        $at_system = new \Inside4\InsideAutoTables\AutoTablesSystem;
        $at_system->init();

        $lang = $input->post_secure($input_array['lang_alias_column']);

        $db->run_sql("DELETE FROM ".$input_array['table']." WHERE ".$input_array['lang_alias_column']." = ".$db->quote($lang)." AND ".$input_array['id_column']." = ".intval($cell_id));

        foreach ($_POST as $key => $value)
        {
            if (substr($key, -3) == "_".$lang)
                $_POST[substr($key, 0, -3)] = $value;
        }

        $result = $at_system->insert_table_cell(ucfirst($input_array['table']));
        echo $result;

    }
    public function db_add($input_array, $cell_id)
    {

    }

}