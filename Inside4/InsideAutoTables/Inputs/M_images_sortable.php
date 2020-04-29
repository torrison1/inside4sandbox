<?php
namespace Inside4\InsideAutoTables\Inputs;

class M_images_sortable
{


    public function input_form($input_array)
    {
        //var_dump($input_array['value']);die();

        if ($input_array['make_type'] == 'add' AND $input_array['value'] == '') $input_array['value'] = '';

        ob_start();

        if (@$input_array['value'] != '') {

            $images = json_decode($input_array['value']);

            echo '<style>
                    .ui-sortable-placeholder {
                        width: 160px;
                        height: 120px;
                        display: inline-block;
                        visibility: visible !important;
                        background: #fffa90;
                    }
                </style>';

            echo '<div class="main_images_wrapper_'.$input_array['name'].'">';
            foreach ($images as $img) {
                ?>
                <div class="image_wrapper_<?= $input_array['name'] ?>" style="display: inline-block;">
                    <a href="/files/uploads/<?= $input_array['folder'] ?>/<?= $img ?>" target="_blank"><img
                            style="display: inline-block; border: 1px solid #ccc;"
                            src="/files/uploads/<?= $input_array['folder'] ?>/<?= $img ?>" width="160" height="90"></a>
                    <a style='display: block; padding: 0; width: 160px; border: 1px solid #ccc; border-top: none;'
                       class='btn btn-default delete_multi_image_<?= $input_array['name'] ?>'>Удалить</a>
                    <a style='display: block; padding: 0; width: 160px; margin-bottom: 5px; border: 1px solid #ccc; border-top: none;'
                       class='btn btn-default crop_multi_image_<?= $input_array['name'] ?>'
                       data="/files/uploads/<?= $input_array['folder'] ?>/<?= $img ?>">Обрезать</a>
                    <input style="display: none;" name="del_img_m_images_<?= $input_array['name'] ?>[]" type="checkbox" value="<?= $img ?>">
                    <input name="m_images_<?= $input_array['name'] ?>[]" type="hidden" value="<?= $img ?>">
                </div>
                <!-- <br/>-->
                <?php
            }
            echo '</div>';
        }

        ?>
        <script type="text/javascript">
            $(function () {

                $(function () {
                    $('.main_images_wrapper_<?=$input_array['name']?>').sortable();
                });


                $(".add_files_<?= $input_array['name'] ?>.btn").on('click', function () {
                    $(".add_files_div_<?= $input_array['name'] ?> .add_file_<?= $input_array['name'] ?>:last").click();
                });

                $('body').off('click', '.crop_multi_image_<?= $input_array['name'] ?>').on('click', '.crop_multi_image_<?= $input_array['name'] ?>', function () {
                    var data = btoa($(this).attr('data'));
                    console.log(1);
                    window.open("/admin/crop/crop_tool/<?= $input_array['table']; ?>?src=" + data, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400");
                });

                /*$(".add_files_div").on('change', '.add_file:last', function(){
                 $(".add_files_div .add_file_line").last().show();
                 var img_line = ''+
                 '			<div class="add_file_line" style="display:none; margin-top: 5px;">'+
                 '			  <a class="btn btn-danger del_file"><i class="icon-remove icon-white">Del</i></a>'+
                 '			  <input type="file" value="" name="add_file[]" multiple class="add_file" placeholder=""/>'+
                 '			</div>';
                 $(".add_files_div").append(img_line);
                 });*/

                /*$(".add_files_div").on('click', '.del_file', function(){
                 $(this).parent().remove();
                 });*/

                $("body").off('click', '.delete_multi_image_<?= $input_array['name'] ?>');
                $("body").on('click', '.delete_multi_image_<?= $input_array['name'] ?>', function () {
                    $(this).parent().find('[type=checkbox]').prop('checked', true);
                    $(this).text('Не удалять');
                    $(this).removeClass('btn-danger');
                    $(this).addClass('on_delete_<?= $input_array['name'] ?> btn-success');
                });
                $("body").on('click', '.on_delete_<?= $input_array['name'] ?>', function () {
                    $(this).parent().find('[type=checkbox]').prop('checked', false);
                    $(this).text('Удалить');
                    $(this).removeClass('on_delete_<?= $input_array['name'] ?> btn-success');
                    $(this).addClass('btn-default');
                });

                $("body").on('click', '.delete_multi_image_<?= $input_array['name'] ?>', function () {
                    var length = $('input[name="del_img_m_images_<?= $input_array['name'] ?>[]"]:checked').length;
                    if (length > 0) {
                        $('.delete_all_images_wrapper_<?= $input_array['name'] ?>').show();
                    } else {
                        $('.delete_all_images_wrapper_<?= $input_array['name'] ?>').hide();
                    }
                });

                <?php if($input_array['make_type'] != 'add') { ?>
                $("body").off('change', '.add_file_<?= $input_array['name'] ?>').on('change', '.add_file_<?= $input_array['name'] ?>', function () {
                    /*$('.add_files').html('Загрузка...');*/ // WHY DONT WORK???
                    var options = {
                        success: function (data) {
                            var images = $(data).filter('.multi_images_response_<?= $input_array['name'] ?>');
                            if (images) {
                                $('.main_images_wrapper_<?= $input_array['name'] ?>').empty();
                                $('li', images).each(function () {
                                    console.log(1111);
                                    $('.main_images_wrapper_<?= $input_array['name'] ?>').append('<div class="image_wrapper_<?= $input_array['name'] ?>" style="display: inline-block; margin-right: 4px;">' +
                                        '<a href="/files/uploads/<?=$input_array['folder']?>/' + $(this).text() + '" target="_blank"><img style="display: inline-block; border: 1px solid #ccc;" src="/files/uploads/<?=$input_array['folder']?>/' + $(this).text() + '" width="160" height="90"></a>' +
                                        '<a style="display: block; padding: 0; width: 160px; border: 1px solid #ccc; border-top: none;" class="btn btn-default delete_multi_image_<?= $input_array['name'] ?>">Удалить</a>' +
                                        '<a style="display: block; padding: 0; width: 160px; margin-bottom: 5px; border: 1px solid #ccc; border-top: none;" class="btn btn-default crop_multi_image_<?= $input_array['name'] ?>" data="/files/uploads/<?=$input_array['folder']?>/' + $(this).text() + '">Обрезать</a>' +
                                        '<input style="display: none;" name="del_img_m_images_<?= $input_array['name'] ?>[]" type="checkbox" value="' + $(this).text() + '">' +
                                        '<input name="m_images_<?= $input_array['name'] ?>[]" type="hidden" value="' + $(this).text() + '"></div>');
                                });
                            }
                        }
                    };
                    $(this).closest('form').ajaxSubmit(options);

                    $('.add_file_<?= $input_array['name'] ?>').val('');
                });

                $("body").off('click', '.delete_all_images_<?= $input_array['name'] ?>').on('click', '.delete_all_images_<?= $input_array['name'] ?>', function () {
                    var isDelete = confirm("Удалить выбранные изображения?");
                    if (isDelete) {
                        $(this).closest('form').ajaxSubmit();
                        $('.on_delete_<?= $input_array['name'] ?>').parent().remove();
                        $('input[name="del_img_m_images_<?= $input_array['name'] ?>[]"]:checked').prop('checked', false);
                        $(this).parent().hide();
                    }
                });
                <?php } else { ?>

                $("body").off('change', '.add_file_<?= $input_array['name'] ?>').on('change', '.add_file_<?= $input_array['name'] ?>', function () {
                    var options = {
                        type: "POST",
                        url: '/admin/inside_ajax/add_uploads_multi_image/',
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
                            var images = $(data).filter('.multi_images_response_<?= $input_array['name'] ?>');
                            if (images) {
                                $('.main_images_wrapper_<?= $input_array['name'] ?>').empty();
                                $('li', images).each(function () {
                                    $('.main_images_wrapper_<?= $input_array['name'] ?>').append('<div class="image_wrapper_<?= $input_array['name'] ?>" style="display: inline-block; margin-right: 4px;">' +
                                        '<a href="/files/uploads/<?=$input_array['folder']?>/' + $(this).text() + '" target="_blank"><img style="display: inline-block; border: 1px solid #ccc;" src="/files/uploads/<?=$input_array['folder']?>/' + $(this).text() + '" width="160" height="90"></a>' +
                                        '<a style="display: block; padding: 0; width: 160px; border: 1px solid #ccc; border-top: none;" class="btn btn-default delete_multi_image_<?= $input_array['name'] ?>">Удалить</a>' +
                                        '<a style="display: block; padding: 0; width: 160px; margin-bottom: 5px; border: 1px solid #ccc; border-top: none;" class="btn btn-default crop_multi_image_<?= $input_array['name'] ?>" data="/files/uploads/<?=$input_array['folder']?>/' + $(this).text() + '">Обрезать</a>' +
                                        '<input style="display: none;" name="del_img_m_images_<?= $input_array['name'] ?>[]" type="checkbox" value="' + $(this).text() + '">' +
                                        '<input name="m_images_<?= $input_array['name'] ?>[]" type="hidden" value="' + $(this).text() + '"></div>');
                                });
                            }
                        }
                    };

                    $(this).closest('form').ajaxSubmit(options);

                    $('.add_file_<?= $input_array['name'] ?>').val('');
                });

                $("body").off('click', '.delete_all_images_<?= $input_array['name'] ?>').on('click', '.delete_all_images_<?= $input_array['name'] ?>', function () {
                    var isDelete = confirm("Удалить выбранные изображения?");
                    if (isDelete) {

                        var options = {
                            type: "POST",
                            url: '/admin/inside_ajax/add_uploads_multi_image/',
                            data: {table: '<?= $input_array['table']; ?>', folder:'<?= $input_array['folder']; ?>', name:'<?= $input_array['name']; ?>'}
                        };

                        $(this).closest('form').ajaxSubmit(options);
                        $('.on_delete_<?= $input_array['name'] ?>').parent().remove();
                        $('input[name="del_img_m_images_<?= $input_array['name'] ?>[]"]:checked').prop('checked', false);
                        $(this).parent().hide();
                    }
                });
                <?php }  ?>

            });
        </script>
        <?php if ($input_array['value'] == '') { ?>
        <div class="main_images_wrapper_<?= $input_array['name'] ?>"></div>
    <?php } ?>
        <div style="display: none;" class="delete_all_images_wrapper_<?= $input_array['name'] ?>">
            <a style="padding: 0; width: 100px; color: #fff;"
               class="btn btn-warning delete_all_images_<?= $input_array['name'] ?>">Удалить</a>
        </div>
        <div class="clearfix"></div>
        <a style="padding: 0; width: 100px;" class="btn btn-success add_files_<?= $input_array['name'] ?>">Добавить</a>
        <div class="add_files_div_<?= $input_array['name'] ?>">
            <div class="add_file_line_<?= $input_array['name'] ?>" style="display:none; margin-top: 5px;">
                <a style="padding: 0; width: 100px; margin-bottom: 5px;" class="btn btn-danger del_file_<?= $input_array['name'] ?>"><i
                        class="icon-remove icon-white">Удалить</i></a>
                <input type="file" value="" name="add_file_<?= $input_array['name'] ?>[]" capture="camera" multiple class="add_file_<?= $input_array['name'] ?>"
                       placeholder=""/>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }


    public function db_save($input_array)
    {
        $CI =& get_instance();
        $files_arr = Array();

        $my_img_arr = @$_POST['m_images_'.$input_array['name']];
        $del_img_arr = @$_POST['del_img_m_images_'.$input_array['name']];

        //print_r($my_img_arr);
        //print_r($del_img_arr);

        for ($i = 0; $i < count($my_img_arr); $i++) {
            $no_del = true;
            for ($j = 0; $j < count($del_img_arr); $j++) {
                if ($del_img_arr[$j] == $my_img_arr[$i]) {
                    $CI->inside_lib->c7_delete_image($my_img_arr[$i], $input_array['folder'] . "/");
                    $no_del = false;
                }

            }
            if ($no_del) $files_arr[] = $my_img_arr[$i];

        }


        /*$config['upload_path'] = './files/uploads/'.$input_array['folder'].'/';

        $config['allowed_types'] = 'zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|avi|mpeg|mp3|mp4|3gp|gif|jpg|jpeg|png';
        $config['max_size']	= '500';
        $config['max_width']  = '800';
        $config['max_height']  = '600';

        $CI->load->library('upload', $config);*/

        if (isset ($_FILES['add_file_'.$input_array['name']])) {

            $CI->load->library('image_lib');

            $cpt = count($_FILES['add_file_'.$input_array['name']]['name']);
            for ($i = 0; $i < $cpt; $i++) {

                $_FILES['add_file_now']['name'] = $_FILES['add_file_'.$input_array['name']]['name'][$i];
                $_FILES['add_file_now']['type'] = $_FILES['add_file_'.$input_array['name']]['type'][$i];
                $_FILES['add_file_now']['tmp_name'] = $_FILES['add_file_'.$input_array['name']]['tmp_name'][$i];
                $_FILES['add_file_now']['error'] = $_FILES['add_file_'.$input_array['name']]['error'][$i];
                $_FILES['add_file_now']['size'] = $_FILES['add_file_'.$input_array['name']]['size'][$i];

                $folder = $input_array['folder'] . '/';
                $tmp_name = 'add_file_now';
                $config = Array();
                $CI->image_lib->clear();

                // Rename
                $_FILES[$tmp_name]['name'] = $CI->inside_lib->ru2en_img($_FILES[$tmp_name]['name']);

                $_FILES[$tmp_name]['name'] = $CI->inside_lib->C7_fs_file_upload($_FILES[$tmp_name]['tmp_name'], $_FILES[$tmp_name]['name'], "/files/uploads/" . $folder);


                if ($_FILES[$tmp_name]['name']) $files_arr[] = $_FILES[$tmp_name]['name']; // Add File to Array


                //print_r($_FILES['add_file_now']);

                if (isset($input_array['resize'])) {

                    $path_to_image = $_SERVER["DOCUMENT_ROOT"] . "/files/uploads/" . $folder . $_FILES[$tmp_name]['name'];
                    list($width, $height) = getimagesize($path_to_image);

                    //echo $width." x ".$height." !!!";

                    if (isset($input_array['new_width'])) $new_width = intval($input_array['new_width']);
                    else $new_width = 200;

                    if (isset($input_array['new_height'])) $new_height = intval($input_array['new_height']);
                    else $new_height = 200;

                    $config['height'] = $new_height;
                    $config['width'] = $new_width;

                    if (!empty($input_array['crop_center'])) {

                        $config_by_width ['width'] = $new_width;
                        $config_by_width ['height'] = '800';
                        $config_by_width ['master_dim'] = 'width';
                        $config_by_width ['y_axis'] = round(($height * $new_width / $width - $new_height) / 2);
                        $config_by_width ['x_axis'] = 0;

                        $config_by_height['height'] = $new_height;
                        $config_by_height['width'] = '800';
                        $config_by_height['master_dim'] = 'height';
                        $config_by_height['x_axis'] = round(($width * $new_height / $height - $new_width) / 2);
                        $config_by_height['y_axis'] = 0;


                        $config = $config_by_width;
                        $tmp_height = $height * $new_width / $width;
                        if ($tmp_height < $new_height) $config = $config_by_height;


                    } else {
                        if (!empty($input_array['resize_by_width'])) {
                            $config['master_dim'] = 'width';
                        } elseif (!empty($input_array['resize_by_height'])) {
                            $config['master_dim'] = 'height';
                        } else {
                        }
                    }


                    //echo "Do Resize for: ".$path_to_image;
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $path_to_image;
                    // $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;

                    $CI->image_lib->initialize($config);

                    if (!$CI->image_lib->resize()) {
                        echo $CI->image_lib->display_errors();
                    }

                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = $new_width;
                    $config['height'] = $new_height;

                    $CI->image_lib->initialize($config);

                    if (isset($input_array['crop_center'])) {
                        if ($input_array['crop_center']) {

                            if (!$CI->image_lib->crop()) {
                                echo $CI->image_lib->display_errors();
                            }

                        }
                    }


                }

            }
        }
        //print_r($files_arr);

        if (!empty($files_arr)) {
            echo '<ul class="multi_images_response_'.$input_array['name'].'">';
            foreach ($files_arr as $file) {
                echo "<li>$file</li>";
            }
            echo '</ul>';
        }

        return json_encode($files_arr);
    }
}
