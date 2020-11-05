<?php

namespace Inside4\CommonCore;

Class Commons {

    //i--- Common functions for common usage ; inside_core ; torrison ; 01.05.2020 ; 1 ---/

    public function make_tree_view($res, $columns = false, $lang_prefix = '', $ul_attr = '')
    {
        if (!$columns) {
            $id_column = 'categories_id';
            $pid_column = 'categories_pid';
            $name_column = 'categories_name';
            $haschild_column = 'categories_haschild';
            $invisible_column = 'categories_invisible';
            $url_column = 'categories_alias';
            $url_prefix = $lang_prefix . '/info/category/';
            $data_prefix = "- ";
        } else {
            $id_column = $columns['id_column'];
            $pid_column = $columns['pid_column'];
            $name_column = $columns['name_column'];
            $haschild_column = $columns['haschild_column'];
            $invisible_column = $columns['invisible_column'];
            $url_column = $columns['url_column'];
            $url_prefix = $lang_prefix . $columns['url_prefix'];
            $data_prefix = $columns['data_prefix'];
        }


        $prefix_count = 0;

        $data = "\n<div class=\"tree_container\"><ul" . $ul_attr . ">\n";

        $catalog_tree = $res;
        $count = count($catalog_tree);
        $i = 0;                      // Reset $i
        #$limit = 0;			   // Defend counter for Debuging
        $parent_step = 0;          // Start in parent_id = 0
        $parent[$parent_step] = 0; // Parent to Child Step Array
        $now_output = array();     // Array for ouput printing data
        while ($i <= $count) {
            #$data .= "{".$catalog_tree[$i]['parent_id']."<< = >>".$parent[$parent_step]."}"; #Debuging echo
            $now_output_signal = false; #reset now output signal

            if (@$catalog_tree[$i][$invisible_column] == 1) {
                array_push($now_output, $catalog_tree[$i][$id_column]);
                $i++;
            } else {

                for ($j = 0; $j < count($now_output); $j++) {
                    if (@$catalog_tree[$i][$id_column] == $now_output[$j]) {
                        $now_output_signal = true;
                        break;
                    } #Check for ouput printing data
                }

                if ((@$catalog_tree[$i][$pid_column] == $parent[$parent_step]) && (@$catalog_tree[$i][$id_column] > 0)) #if id has parent_id in current parent level (start in 0)
                {
                    if ($catalog_tree[$i][$haschild_column] == 1) #For HasChild Line
                    {
                        if ($now_output_signal == false) #if id has not printed
                        {
                            $parent_step++;
                            $parent[$parent_step] = $catalog_tree[$i][$id_column];

                            if ($catalog_tree[$i][$haschild_column] == 1) {
                                $catalog_tree[$i][$id_column] = $catalog_tree[$i][$id_column] . "p";
                            }
                            $data .= "<li>" . str_repeat($data_prefix, $prefix_count) . "<a href=\"" . $url_prefix . $catalog_tree[$i][$url_column] . "\" title=\"" . $catalog_tree[$i][$name_column] . "\">" . $catalog_tree[$i][$name_column] . "</a><ul>\n";

                            array_push($now_output, $catalog_tree[$i][$id_column]);
                            $i = 0; #parent step+1, new parent has added, if not empty, data printed, prefix+1 "->" , array push printed id!. Start again.
                            $prefix_count++;
                        }
                    } else {
                        if ($now_output_signal == false) #if id has not printed
                        {
                            $data .= "<li>" . str_repeat($data_prefix, $prefix_count) . "<a href=\"" . $url_prefix . $catalog_tree[$i][$url_column] . "\" title=\"" . $catalog_tree[$i][$name_column] . "\">" . $catalog_tree[$i][$name_column] . "</a>\n</li>";
                            array_push($now_output, $catalog_tree[$i][$id_column]);
                        }
                    }
                }
                if ($i == $count) {
                    $i = 0;
                    $parent_step--;
                    $prefix_count--;
                    $data .= "</ul></li>";
                } #step left in prefix way in the end of data
                $i++;
                #$limit++; if ($limit == 260) $i = $tree_i+5; # Defend system for ulimited while
                if (!isset($parent[$parent_step])) $i = $count + 5; #The End Of While, Bacause Step = -1
            }
        }

        $data = substr($data, 0, strlen($data) - 10);
        $data .= "</ul></div>\n";
        return $data;
    }
}