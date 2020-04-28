<?php
namespace Inside4\InsideAutoTables\Inputs;

class Image_mod {


    public function input_form($input_array)
    {
        if ($input_array['make_type'] == 'copy') $input_array['value'] = '';
        return $this->input_file_img ($input_array['name'], $input_array['value'],$input_array['folder'], $input_array);
    }

    // OLD Stable Function
    public function input_file_img($name, $row_img = NULL, $img_folder = NULL, $input_array = NULL){
        $data='';
        if (isset($row_img)&&($row_img != ""))
        {  	if (isset($img_folder)) $link_folder = $img_folder."/";

            if ($row_img == "error_file") $data .= "<font color=\"darkred\">pics/".$link_folder.$row_img."</font>";
            // else $data .= "<a href=\"/files/uploads/".$link_folder.$row_img."\" target=\"_blank\">files/uploads/".$link_folder.$row_img."</a>";
            else $data .= "<div class='".$name."_div'><a class='path_to_img_".$name."' href=\"/files/uploads/".$link_folder.$row_img."\" target=\"_blank\"><img style='border: 1px solid #ccc;' src='/files/uploads/".$link_folder.$row_img."' width='160' height='90'></a><br>";
            $data .= "
			<input style='display: none;' name=\"del_img_".$name."\" type=\"checkbox\" value=\"1\" class='del_main_img_".$name."'>
			<a style=' display: block; padding: 0; width: 160px; border: 1px solid #ccc; border-top: none;' class='btn btn-default remove_img_".$name."'>Удалить</a>
			<a style=' display: block; padding: 0; width: 160px; margin-bottom: 5px; border: 1px solid #ccc; border-top: none;' class='btn btn-default crop_img_".$name."' data='/files/uploads/".$link_folder.$row_img."'>Обрезать</a>
			<input style='display: none;' type=\"file\" name=\"".$name."\" capture=\"camera\" class=\"upload_new_img_".$name."\">
			<a style=\"padding: 0; width: 160px;\" class=\"btn btn-success add_main_img\">Добавить новую</a>
			<input name=\"".$name."\" type=\"hidden\" value=\"".$row_img."\"></div>
			";

            if (isset($img_folder)) $data .= "<input name=\"".$name."_folder\" type=\"hidden\" value=\"".$img_folder."\">";
        }
        else
        {  	/*$data = "
		<div class='".$name."_div'><input style='display: none;' type=\"file\" name=\"".$name."\" id=\"".$name."\" style=\"width:350px;\" value=\"".$row_img."\" class=\"upload_new_img_".$name."\">
		<a style='padding: 0; width: 100px;' class='btn btn-success add_first_image_".$name."'>Загрузить</a>
		</div>";*/

            $data = "
		<div class='".$name."_div'>
		<input style='display: none;' type=\"file\" capture=\"camera\" name=\"".$name."\" id=\"".$name."\" style=\"width:350px;\" value=\"".$row_img."\" class=\"upload_new_img_".$name."\">
	    <a style=\"padding: 0; width: 100px;\" class=\"btn btn-success add_main_img\">Добавить</a>
		</div>";
            if (isset($img_folder)) $data .= "<input name=\"".$name."_folder\" type=\"hidden\" value=\"".$img_folder."\">";
        }

        ob_start();?>
        <script>

            /*<a style='padding: 0; width: 100px;' class='btn btn-success add_new_image_".$name."'>Загрузить</a>*/
            <?php if($input_array['make_type'] != 'add') { ?>

            $("body").off('change','.upload_new_img_<?= $name; ?>').on('change','.upload_new_img_<?= $name; ?>', function() {

                if($(".del_main_img_<?= $name; ?>").length > 0) {
                    if (!$(".del_main_img_<?= $name; ?>").is(':checked')) {
                        $(".del_main_img_<?= $name; ?>").click();
                    }
                }

                var options = {
                    success: function (data) {
                        var folder = $(data).filter('.path_to_folder').text();
                        var src = $(data).filter('.path_to_image').text();
                        $(".<?= $name; ?>_div").empty();
                        $(".<?= $name; ?>_div").append("<a target='_blank' href='/files/uploads/"+folder+src+"'><img style='border: 1px solid #ccc;' src='/files/uploads/"+folder+src+"' width='160' height='90'></a>");
                        $(".<?= $name; ?>_div").append("<a style='display: block; padding: 0; width: 160px; border: 1px solid #ccc; border-top: none;' class='btn btn-default remove_img_<?= $name; ?>'>Удалить</a>");
                        $(".<?= $name; ?>_div").append("<a style='display: block; padding: 0; width: 160px; margin-bottom: 5px;  border: 1px solid #ccc; border-top: none;' class='btn btn-default crop_img_<?= $name; ?>' data='/files/uploads/"+folder+src+"'>Обрезать</a>");
                        $(".<?= $name; ?>_div").append("<input style='display: none;' name=\"del_img_<?= $name; ?>\" type=\"checkbox\" value=\"1\" class='del_main_img_<?= $name; ?>'>");
                        $(".<?= $name; ?>_div").append("<input style='display: none;' type=\"file\" capture=\"camera\" name=\"<?= $name; ?>\" class=\"upload_new_img_<?= $name; ?>\">");
                        $(".<?= $name; ?>_div").append("<a style=\"padding: 0; width: 160px;\" class=\"btn btn-success add_main_img\">Добавить новую</a>");
                        $(".<?= $name; ?>_div").append("<input name=\"<?= $name; ?>\" type=\"hidden\" value=\""+src+"\">");
                    }
                };

                $(this).closest('form').ajaxSubmit(options);

                $(".del_main_img_<?= $name; ?>").prop('checked', false);
            });

            $('body').off('click','.remove_img_<?= $name; ?>').on('click','.remove_img_<?= $name; ?>', function () {

                var isRemove = confirm("Удалить изображение?");

                if(isRemove) {
                    if (!$(".del_main_img_<?= $name; ?>").is(':checked')) {
                        $(".del_main_img_<?= $name; ?>").click();
                    }
                    var options = {
                        data: {not_upload_img: true}
                    };
                    $(this).closest('form').ajaxSubmit(options);
                    $(".<?= $name; ?>_div").empty();
                    var new_input = "<input style='display: none;' capture=\"camera\" type=\"file\" name=\"<?= $name; ?>\" id=\"<?= $name; ?>\" style=\"width:350px;\" class=\"upload_new_img_<?= $name; ?>\"><a style=\"padding: 0; width: 100px;\" class=\"btn btn-success add_main_img\">Добавить</a>";
                    $(".<?= $name; ?>_div").append(new_input);
                    $(".del_main_img_<?= $name; ?>").prop('checked', false);
                }

            });

            <?php } else { ?>

            $("body").off('change','.upload_new_img_<?= $name; ?>').on('change','.upload_new_img_<?= $name; ?>', function() {
                if($(".del_main_img_<?= $name; ?>").length > 0) {
                    if (!$(".del_main_img_<?= $name; ?>").is(':checked')) {
                        $(".del_main_img_<?= $name; ?>").click();
                    }
                }
                var options = {
                    type: "POST",
                    url: '/admin/inside_ajax/add_uploads_image/',
                    data: {
                        <?php foreach ($input_array as $key => $value) {
                            if(!is_array($value) AND $value){
                                if($value !== end($input_array)){
                                    echo "'$key':'$value', ";
                                } else {echo "'$key':'$value'";
                                }
                            }
                        }?>
                    },
                    success: function (data) {
                        var folder = $(data).filter('.path_to_folder').text();
                        var src = $(data).filter('.path_to_image').text();
                        $(".<?= $name; ?>_div").empty();
                        $(".<?= $name; ?>_div").append("<a target='_blank' href='/files/uploads/"+folder+src+"'><img style='border: 1px solid #ccc;' src='/files/uploads/"+folder+src+"' width='160' height='90'></a>");
                        $(".<?= $name; ?>_div").append("<a style='display: block; padding: 0; width: 160px; border: 1px solid #ccc; border-top: none;' class='btn btn-default remove_img_<?= $name; ?>'>Удалить</a>");
                        $(".<?= $name; ?>_div").append("<a style='display: block; padding: 0; width: 160px; margin-bottom: 5px;  border: 1px solid #ccc; border-top: none;' class='btn btn-default crop_img_<?= $name; ?>' data='/files/uploads/"+folder+src+"'>Обрезать</a>");
                        $(".<?= $name; ?>_div").append("<input style='display: none;' name=\"del_img_<?= $name; ?>\" type=\"checkbox\" value=\"1\" class='del_main_img_<?= $name; ?>'>");
                        $(".<?= $name; ?>_div").append("<input style='display: none;' type=\"file\" capture=\"camera\" name=\"<?= $name; ?>\" class=\"upload_new_img_<?= $name; ?>\">");
                        $(".<?= $name; ?>_div").append("<a style=\"padding: 0; width: 160px;\" class=\"btn btn-success add_main_img\">Добавить новую</a>");
                        $(".<?= $name; ?>_div").append("<input name=\"<?= $name; ?>\" type=\"hidden\" value=\""+src+"\">");
                    }
                };

                $(this).closest('form').ajaxSubmit(options);

                $(".del_main_img_<?= $name; ?>").prop('checked', false);
            });

            $('body').off('click','.remove_img_<?= $name; ?>').on('click','.remove_img_<?= $name; ?>', function () {

                var isRemove = confirm("Удалить изображение?");

                if(isRemove) {
                    if (!$(".del_main_img_<?= $name; ?>").is(':checked')) {
                        $(".del_main_img_<?= $name; ?>").click();
                    }
                    var options = {
                        type: "POST",
                        url: '/admin/inside_ajax/add_uploads_image/',
                        data: {table: '<?= $input_array['table']; ?>', name: '<?= $input_array['name']; ?>', folder:'<?= $input_array['folder']; ?>'}
                    };
                    $(this).closest('form').ajaxSubmit(options);
                    $(".<?= $name; ?>_div").empty();
                    var new_input = "<input style='display: none;' capture=\"camera\" type=\"file\" name=\"<?= $name; ?>\" id=\"<?= $name; ?>\" style=\"width:350px;\" class=\"upload_new_img_<?= $name; ?>\"><a style=\"padding: 0; width: 100px;\" class=\"btn btn-success add_main_img\">Добавить</a>";
                    $(".<?= $name; ?>_div").append(new_input);
                    $(".del_main_img_<?= $name; ?>").prop('checked', false);
                }

            });

            <?php } ?>
            // Add button
            $('body').off('click', '.add_main_img').on('click', '.add_main_img', function() {
                $(".upload_new_img_<?= $name; ?>").click();
            });


            // Crop image
            $('body').off('click', '.crop_img_<?= $name; ?>').on('click', '.crop_img_<?= $name; ?>', function() {
                var data = btoa($(this).attr('data'));
                window.open("/admin/crop/crop_tool/<?= $input_array['table']; ?>?src=" + data, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400");
            });
        </script>

        <?php $data .= ob_get_clean();
        return $data;
    }
    public function db_save($input_array)
    {
        $CI =& get_instance();
        $tmp_name = $input_array['name'];

        // Check folder change
        if (isset ($input_array['folder'])) $folder = $input_array['folder']."/";
        else $folder = "";
        // Update File System!

        if (isset($_POST['del_img_'.$tmp_name]))
        {
            //var_dump($_POST[$tmp_name]);
            $CI->inside_lib->c7_delete_image($_POST[$tmp_name], $folder);
            //return '';

            $was_deleted = true;
        }

        if(isset($_POST['not_upload_img'])) {
            unset($_FILES);
        }

        if (isset($_FILES[$tmp_name]['name']))
        {
            // Rename if cirilic name
            $_FILES[$tmp_name]['name'] = $CI->inside_lib->ru2en_img($_FILES[$tmp_name]['name']);

            $_FILES[$tmp_name]['name'] = $CI->inside_lib->C7_fs_file_upload ($_FILES[$tmp_name]['tmp_name'], $_FILES[$tmp_name]['name'], "/files/uploads/".$folder);

            if (isset($input_array['resize'])) {

                $CI->load->library('image_lib');

                $path_to_image = $_SERVER["DOCUMENT_ROOT"]."/files/uploads/".$folder.$_FILES[$tmp_name]['name'];
                list($width, $height) = getimagesize($path_to_image);

                //echo $width." x ".$height." !!!";

                if (isset($input_array['new_width'])) $new_width = intval($input_array['new_width']);
                else $new_width = 200;

                if (isset($input_array['new_height'])) $new_height = intval($input_array['new_height']);
                else $new_height = 200;

                $config = Array();
                $config['height'] = $new_height;
                $config['width'] = $new_width;

                if (!empty($input_array['crop_center'])) {

                    $config_by_width = Array();
                    $config_by_width ['width'] = $new_width;
                    $config_by_width ['height'] = '800';
                    $config_by_width ['master_dim'] = 'width';
                    $config_by_width ['y_axis'] = round(($height*$new_width/$width - $new_height)/2);
                    $config_by_width ['x_axis'] = 0;

                    $config_by_height = Array();
                    $config_by_height['height'] = $new_height;
                    $config_by_height['width'] = '800';
                    $config_by_height['master_dim'] = 'height';
                    $config_by_height['x_axis'] = round(($width*$new_height/$height - $new_width)/2);
                    $config_by_height['y_axis'] = 0;


                    $config = $config_by_width;
                    $tmp_height = $height*$new_width/$width;
                    if ($tmp_height < $new_height) $config = $config_by_height;


                }
                else {
                    if (isset($input_array['resize_by_width'])) {
                        $config['master_dim'] = 'width';
                    }
                    elseif (isset($input_array['resize_by_height'])) {
                        $config['master_dim'] = 'height';
                    }
                    else {}
                }

                //print_r($config);

                //echo "Do Resize for: ".$path_to_image;
                $config['image_library'] = 'gd2';
                $config['source_image']	= $path_to_image;
                // $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $CI->image_lib->initialize($config);
                if ( ! $CI->image_lib->resize())
                {
                    //echo $CI->image_lib->display_errors();
                }

                $config['maintain_ratio'] = FALSE;
                $config['width'] = $new_width;
                $config['height'] = $new_height;

                $CI->image_lib->initialize($config);

                if (isset($input_array['crop_center'])) { if ($input_array['crop_center']) {

                    if ( ! $CI->image_lib->crop())
                    {
                        //echo $CI->image_lib->display_errors();
                    }

                } }
                $CI->image_lib->clear();
            }

            echo "<span class='path_to_folder'>".$folder."</span><span class='path_to_image'>".$_FILES[$tmp_name]['name']."</span>";

            //$value = $_FILES[$tmp_name]['name'];
            //unset($_FILES[$tmp_name]);
            //return $value;
            return $_FILES[$tmp_name]['name'];
        }
        else {
            if(!isset($was_deleted)) {
                return $input_array['value'];
            } else {
                return '';
            }
        }
    }

}
