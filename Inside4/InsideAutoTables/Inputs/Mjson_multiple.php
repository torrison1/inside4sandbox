<?php
namespace Inside4\InsideAutoTables\Inputs;

class Mjson_multiple {

    public function input_form($input_array)
    {

        ob_start();

        //print_r($input_array['config_array']);
        // print_r($input_array['value']);
        $data_arr = $input_array['value'];
        if ($data_arr != '' OR $data_arr != '[]')
        $data_arr = json_decode($input_array['value'], true);
        else $data_arr = '';

        // print_r($data_arr);
?>

        <div class="mjson_multiple_input">
            <div class="data_line">
                <table class="mjson_multiple_table table table-bordered">
                    <tr style="background: #eee;">
                        <?php foreach ($input_array['config_array'] as $row) { ?>
                            <th><?=$row['text']?></th>
                        <?php } ?>
                        <th></th>
                    </tr>
                    <tr class="add_template" style="display: none;">
                        <?php foreach ($input_array['config_array'] as $row) { ?>
                        <td><input style="width:100%;" type="text" value="" name="<?=$input_array['name']?>_mjson_multiple_<?=$row['name']?>[]"></td>
                        <?php } ?>
                        <td><a class="btn btn-danger" style="color: white;" onclick="$(this).parent().parent().remove();">X</a></td>
                    </tr>
                    <?php if ($data_arr != '' AND isset($data_arr[0])) { foreach ($data_arr as $data_line) { ?>
                    <tr>
                        <?php foreach ($input_array['config_array'] as $row) { ?>
                        <td><input style="width:100%;" type="text" value="<?=@$data_line[$row['name']]?>" name="<?=$input_array['name']?>_mjson_multiple_<?=$row['name']?>[]"></td>
                        <?php } ?>
                        <td><a class="btn btn-danger" style="color: white;" onclick="$(this).parent().parent().remove();">X</a></td>
                    </tr>
                    <?php } } ?>
                </table>
                <a class="btn btn-primary" style="color: white;" onclick="$(this).prev().append('<tr>'+$(this).prev().find('.add_template').html()+'</tr>')">Add more</a>
            </div>
        </div>
<?php
        $variants_field = ob_get_clean();
        return $variants_field;
    }

    public function db_save($input_array)
    {
        // print_r($_POST);
        // print_r($input_array['config_array']);

        $json_data = Array();

        // 0 - for add template
        $i = 1;

        $while = true;

        while ($while) {

            $new_line = false;

            foreach ($input_array['config_array'] as $row) {

                // echo ">>>";
                // print_r($_POST['mjson_multiple_'.$row['name']]);
                // echo ($_POST['mjson_multiple_'.$row['name']][$i]);
                // $input_array['name']

                if (isset($_POST[$input_array['name'].'_mjson_multiple_'.$row['name']][$i]) AND $_POST[$input_array['name'].'_mjson_multiple_'.$row['name']][$i] != '') {

                    $new_line[$row['name']] = $_POST[$input_array['name'].'_mjson_multiple_'.$row['name']][$i];

                }

            }

            if ($new_line) $json_data[] = $new_line;
            else $while = false;
            $i++;
        }

        if (!empty($json_data)) $res = json_encode($json_data);
        else $res = '';

        // print_r($res);
        // $res = '';

        return $res;

    }

}
