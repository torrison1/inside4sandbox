<?php

namespace Inside4\InsideTools;
use stdClass;

Class InsideDatabaseView {

    public function view($to_var = true) {

        if ($to_var) ob_start();

        // RAW COPY from Inside0

        $system_root_url = '';

        $database = 'ikiev_inside4';

        $sql = "
        SELECT
            cols.TABLE_NAME 'Table',
            cols.`COLUMN_NAME` 'Field',
            cols.`COLUMN_TYPE` 'Type',
            cols.IS_NULLABLE 'Null',
            cols.COLUMN_KEY 'Key',
            cols.COLUMN_DEFAULT 'Default',
            cols.EXTRA 'Extra'
        FROM information_schema.columns as cols
        WHERE cols.table_schema = '{$database}'
        ORDER BY cols.TABLE_NAME, cols.COLUMN_NAME";
        $result = $this->db->sql_get_data($sql);

        echo "<html><title>System DataBase</title><body>";
        echo "<h3>DataBase : {$database}</h3>";
        echo "
        <style>
            .arial-fs10 {
                font-family: Arial;
                font-size: 10pt;
            }
            .bold {
                font-weight: bold;
            }
            .tr=yellow td{
                background: #FFFD38;
            }
            .tr-grey td{
                background: #EFEFEF;
            }
            .tr-empty td{
                min-height: 38px;
            }
        </style>
        <h1>System DataBase</h1>
        <div class='arial-fs10'>
        ";
        echo "<table class='arial-fs10'>
        <thead></thead>
        <tbody>
        ";
        if (isset($result[0])) {
            $table = '';
            $rowTable = '';
            $rowCount = 1;
            $rowDefault = '';
            global $inside_columns;
            $table_i = 0;

            $row_prev['Table'] = '';

            foreach ($result as $row) {

                $table_class = "\\Inside4\\InsideAutoTables\\Tables\\".ucfirst($row['Table']);
                // echo ($table_class); exit();
                // echo __DIR__.'/../InsideAutoTables/Tables/'.ucfirst($row['Table']) .".php";
                if (file_exists(__DIR__.'/../InsideAutoTables/Tables/'.ucfirst($row['Table']) .".php")) {


                // print_r($row);
                // echo "test";

                if ($table === $row['Table']) {
                    $rowTable = '';
                } else {
                    if (isset($table)) {
                        echo "<tr class='tr-empty'>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                            ";
                        echo "<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                            ";
                    }
                    $rowTable = $row['Table'];
                    @$rowSystem =$row['System'];
                    $table = $row['Table'];

                    // echo "$table_class"; exit();

                    $table_obj = new $table_class();
                    $table_obj->init();

                    usort($table_obj->table_columns, function($a, $b) {
                        return strcmp($a['name'], $b['name']);
                    });
                    $inside_columns = $table_obj->table_columns;
                    $table_i++;
                    echo "<tr class='tr-grey'>";
                    echo "<td>$table_i. <a href='{$system_root_url}/inside_AT/table/$rowTable'>$rowTable</a></td>
                            <td>№</td>
                            <td>Name</td>
                            <td>Type</td>
                            <td>Default</td>
                            <td>Input Type</td>
                            <td>Tab Text</td>
                            <td>In Table</td>
                            <td>In Filters</td>
                            <td>$rowSystem</td>";
                    echo "</tr>";
                    $rowCount = 1;
                }
                if (is_null($row['Default'])) {
                    $rowDefault = '-';
                } else {
                    $rowDefault = $row['Default'];
                }

                $inside_row = new stdClass;

                if (isset($inside_columns[$rowCount-1]['input_type'])) {
                    $inside_row->input_type = $inside_columns[$rowCount-1]['input_type'];
                } else {
                    $inside_row->input_type = '-';
                }
                if (isset($inside_columns[$rowCount-1]['tab'])) {
                    $inside_row->tab = $inside_columns[$rowCount-1]['tab'];
                } else {
                    $inside_row->tab = '-';
                }
                if (isset($inside_columns[$rowCount-1]['text'])) {
                    $inside_row->text = $inside_columns[$rowCount-1]['text'];
                } else {
                    $inside_row->text = '-';
                }


                if (isset($inside_columns[$rowCount-1]['in_crud']) AND $inside_columns[$rowCount-1]['in_crud']) {
                    $inside_row->in_table = "'+";
                } else {
                    $inside_row->in_table = '-';
                }
                if (isset($inside_columns[$rowCount-1]['filter']) AND $inside_columns[$rowCount-1]['filter']) {
                    $inside_row->in_filter = "'+";
                } else {
                    $inside_row->in_filter = '-';
                }
                echo "<tr>";
                echo "<td></td>
                        <td>$rowCount</td>
                        <td><b>". $row['Field'] ."</b></td>
                        <td>". $row['Type'] ."</td>
                        <td align='Center'>". $rowDefault ."</td>
                        <td>". $inside_row->input_type ."</td>
                        <td>". $inside_row->text ."</td>
                        <td align='Center'>". $inside_row->in_table ."</td>
                        <td align='Center'>". $inside_row->in_filter ."</td>
                        <td></td>";
                echo "</tr>";
                $rowCount += 1;
            } else {
                if ($row_prev['Table'] != $row['Table']) {
                    $table_i++;
                    echo "<tr class='tr-empty'>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                            ";
                    echo "<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                            ";
                    echo "<tr class='tr-grey'>";
                    echo "<td>$table_i. <b>".$row['Table']."</b></td>
                            <td>№</td>
                            <td>Name</td>
                            <td>Type</td>
                            <td>Default</td>
                            <td>Input Type</td>
                            <td>Tab Text</td>
                            <td>In Table</td>
                            <td>In Filters</td>
                            ";
                    echo "</tr>";

                }

                echo "<tr>";
                echo "<td></td>
                        <td></td>
                        <td><b>". $row['Field'] ."</b></td>
                        <td>". $row['Type'] ."</td>
                        <td></td>";
                echo "</tr>";
                $row_prev = $row;
            }}
        } else {
            echo "0 results";
        }

        echo "</tbody></table>";
        echo "</div>";
        echo "</body></html>";

        if ($to_var) return ob_get_clean();

    }

}