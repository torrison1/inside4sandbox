<?php
//i--- Get Table Object ; inside_custom_cruds ; torrison ; 01.06.2020 ; 1 ---/
$table_class = "\\Inside4\\InsideAutoTables\\Tables\\".$table_name;
if (!class_exists($table_class)) exit('No Table '.$table_name.' class!');
$table_obj = new $table_class();
$table_obj->init();

$table_config = $table_obj->table_config;
$table_columns = $table_obj->table_columns;

$key_column = $table_config['key'];
$columns_names = array();
$tab_name = '';

?>
<!-- //i--- Table View ; inside_custom_cruds ; torrison ; 01.06.2020 ; 2 ---/ -->
<table class="table table-responsive table-bordered stickytable">
    <thead>
    <tr>
        <th class="first_col">
            <input id="box0" type="checkbox" class="with-font">
            <label for="box0"></label>
        </th>

        <!-- //i--- Make Headers for Table ; inside_custom_cruds ; torrison ; 01.06.2020 ; 3 ---/ -->
        <?php
        foreach ($table_columns as $config_row) {
            if (isset($config_row['in_crud'])) {
                $tmp_name = $config_row['name'];
                $columns_names[$tmp_name] = $config_row['text'];
                ?>
                <th class="pdg_column_header" column="<?= $config_row['name'] ?>">
                    <?= $config_row['text'] ?>
                </th>
            <?php }
        } ?>
        <th class="">
        </th>
    </tr>
    </thead>

    <!-- //i--- Make default static Table blocks ; inside_custom_cruds ; torrison ; 01.06.2020 ; 4 ---/ -->
    <?php
    foreach ($table_arr as $table_row) {
        ?>
        <tr class="status_active table_row">
            <div class="mobile_buts">
                <td class="mobile_status_cell status_active">
                    <span>#<?= $table_row[$key_column] ?></span>
                </td>
                <td class="first_col">
                    <input type="checkbox" name="pdg_crud_checkbox[]" class="pdg_column_checkbox with-font"
                           line_id="<?= $table_row[$key_column] ?>" value="<?= $table_row[$key_column] ?>"/>
                    <label for="box4" class="pdg_column_checkbox_label"></label>
                </td>
                <td class="edit_cell">
                    <button type="button" class="pdg_button_edit" line_id="<?= $table_row[$key_column] ?>"><i
                                class="fa fa-pencil" aria-hidden="true"></i></button>
                </td>
                <td class="action_cell dropdown mobile_dropdown">
                    <button type="button" type="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                    <ul class="dropdown-menu">
                        <li><a line_id="<?= $table_row[$key_column] ?>" class="mobile_copy_btn">Копировать</a></li>
                        <li><a line_id="<?= $table_row[$key_column] ?>" class="mobile_del_btn">Удалить</a></li>
                    </ul>
                </td>
            </div>
            <!-- //i--- Put Data blocks to Table ; inside_custom_cruds ; torrison ; 01.06.2020 ; 5 ---/ -->
            <?php
            foreach ($table_columns as $config_row) {
                if (isset($config_row['in_crud'])) {
                    $tmp_name = $config_row['name'];

                    // Update Data Cells (If it Needs)
                    if (isset($config_row['input_type'])) {
                        $config_row['value'] = $table_row[$tmp_name];
                        $table_row[$tmp_name] = $at_system->make_input("crud_view", $config_row);
                    }
                    // Change view for JOIN columns
                    if (isset ($config_row['join'])) $table_row[$tmp_name] = $table_row[$config_row['join_as']];
                    ?>

                    <td class="table_cell pdg_column_cell" line_id="<?= $table_row[$key_column] ?>">
                        <table<?php if (isset($config_row['style'])) {
                            echo ' style="' . $config_row['style'] . '"';
                        } ?>>
                            <td class="cell_title"><?= $columns_names[$tmp_name] ?></td>
                            <td>
                                <?php if (isset($config_row['crud_edit'])) { ?>
                                    <a class="crud_edit_btn" key_id="<?= $key_column ?>"
                                       line_id="<?= $table_row[$key_column] ?>" column="<?= $config_row['name'] ?>"><i
                                                class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?php } ?>
                                <span class="crud_value_span"><?php if (isset($config_row['instead_name'])) $tmp_name = $config_row['instead_name'];
                        echo $table_row[$tmp_name] ?></span>

                            </td>
                        </table>
                    </td>

                <?php }
            } ?>

            <!-- //i--- Last Cell with Functions buttons ; inside_custom_cruds ; torrison ; 01.06.2020 ; 6 ---/ -->
            <td class="status_cell pdg_column_cell" line_id="<?= $table_row[$key_column] ?>">

                <div class="status_line"></div>

                <a href="/inside/pdg_edit/<?= $table_name ?>/<?= $table_row[$key_column] ?>" OnClick="return false;"
                   class="btn pdg_button_edit" line_id="<?= $table_row[$key_column] ?>"><i class="fa fa-pencil-square-o"
                                                                                           aria-hidden="true"></i></a>
                <!--<a class="pdg_button_delete" line_id="'.$table_row[$key_column].'">(delete)</a>-->
                <span></span>
            </td>
        </tr>

    <?php }
    // --------------------  Wear Columns in Columns Holders ---------------------------------------------------
    ?>
    </tbody>
</table>

<div style="clear:both;"></div>
<div style="font-size:9px; margin-top:12px;" id="debug_div">
    Custom CRUD Interface
    <!--
    <?php echo "SQL:" . $sql; ?>
    -->
    <br/>
    <?php echo $debug; ?>
</div>

