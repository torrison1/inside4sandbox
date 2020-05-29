<div class="wblock1" style="padding: 10px; margin-bottom: 10px; width:100%; overflow-x: hidden;">
    <h2 style="margin-bottom: 7px;">Inside 4 System</h2>
    <p>
        <b>Inside 4</b>
        is a modular system for building complex web services. It is necessary because of the complexity and team need a clear understanding of all elements for easy step by step development.
        <br>
        Below is a table with all the modules of this system. Press the function button or double-click on a row in the table to open full information about the module.
        <!--
        - это модульная система для построения сложных <a href="https://ru.wikipedia.org/wiki/%D0%92%D0%B5%D0%B1-%D1%81%D0%BB%D1%83%D0%B6%D0%B1%D0%B0" target="_blank">веб-сервисов</a>.
        Она необходима по причине сложности понимания большого количества элементов и с ее помощью можно последовательно, шаг за шагом, создавать и осваивать все функции и возможности.
        <br>
        Ниже представлена таблица со всеми модулями данной системы. Нажимайте на кнопку функций или двойной клик по строке в таблице чтобы открыть полную информацию о модуле.
        -->

        <br><br>
        Website MAIN:
        <a href="/" target="_blank"><?=$GLOBALS['inside4_main_config']['Website']['base_url']?></a>
        <br>
        GitHub Link:
        <a href="https://github.com/torrison1/inside4sandbox" target="_blank">https://github.com/torrison1/inside4sandbox</a>
        <br>
        Database:
        <a href="/inside/database" target="_blank"><?=$GLOBALS['inside4_main_config']['Website']['base_url']?>/inside/database</a>
        <br>
        Project Files:
        <a href="/inside/projectfiles" target="_blank"><?=$GLOBALS['inside4_main_config']['Website']['base_url']?>/inside/projectfiles</a>
        <br>

        <!--
        Inside 4 Modules (New):
        <a href="/inside/modules" target="_blank">/inside/modules</a>
        <br>
        Inside 4 Modules XML (New):
        <a href="/xTMP/modules.xml" target="_blank">/xTMP/modules.xml</a>
        <br>
        Refresh Modules Data (New):
        <a href="/inside/refresh_modules_data" target="_blank">/inside/refresh_modules_data</a>
        <br>
        -->

        Left Menu Admin Table:
        <a href="/inside_AT/table/inside_top_menu" target="_blank">/inside_AT/table/inside_top_menu</a>
        <br>

        Modules Table:
        <a href="/inside_AT/table/inside_modules" target="_blank">/inside_AT/table/inside_modules</a>
        <br>

    </p>
    <div class="clearfix"></div>
</div>
<ul class="list-group" style="width:100%; overflow-x: hidden;">
    <li class="list-group-item active">
        Inside System Elements and Modules
        <a class="btn btn-sm btn-primary list_group_active_right_button" onclick="filters_toggle()">
            <i class="fa fa-filter text-white"></i>
        </a>
    </li>
    <li class="list-group-item" id="top_filter_holder" style="display: none;">
        <?php
        $main_types_arr = Array(
            '0' => '-',
            '1' => 'Core',
            '2' => 'System',
            '3' => 'User Cases',
            '4' => 'Admin Cases',
            '5' => 'Manager Cases',
            '6' => 'Automatization',
            '7' => 'Usability',
            '8' => 'Advanced',
        );
        ?>
        <b>Filter by type:</b>
        <select name="type" multiple class="multiselect_chosen" data-placeholder="All types"  id="filter_type_select">
            <?php foreach ($main_types_arr as $key => $value) { ?>
                <option value="<?=$key?>"><?=$value?></option>
            <?php } ?>
        </select>


        <a class="btn btn-primary" onclick="filter_send()">Send</a>

    </li>
    <li class="list-group-item">
        <table class="table table-bordered modules-table">
            <thead>
            <tr>
                <th class="text-center" style="background-color:#f6f6f6; width: 60px;">Icon</th>
                <th class="text-center" style="width: 50px;">ID</th>
                <th>Name</th>
                <th class="text-center" style="width: 100px;">Functions</th>
                <th class="text-center" style="width: 100px;">Status</th>
                <th class="text-center" style="width: 100px;">Issues</th>
                <th class="text-center" style="width: 100px;">Type</th>
                <th class="text-center" style="width: 100px;">Main Type</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($modules_arr as $module) { ?>

                <tr main_type="<?=$module['main_type']?>">
                    <td class="text-center"><i class="<?=$module['icon_class']?>"></i></td>
                    <td class="text-center"><?=$module['public_id']?></td>
                    <td><?=$module['name']?></td>
                    <td class="text-center"><a class="btn btn-xs btn-primary open_module_info_btn"><i class="glyphicon glyphicon-cog"></i></a></td>
                    <td class="text-center"><span class="text-success">Active</span></td>
                    <td class="text-center"><span class="text-danger">0/1</span></td>
                    <td class="text-center"><?=$module['type']?></td>
                    <td class="text-center"><?=$main_types_arr[$module['main_type']]?></td>
                </tr>
                <tr style="display:none;" class="module_info_container" module_system_name="<?=$module['system_name']?>"></tr>

            <?php } ?>
            </tbody>
        </table>
    </li>
</ul>

<link rel="stylesheet" href="/Public/InsideAdmin/inside_admin_template/inside/jquery_chosen/chosen.min.css">
<script type="text/javascript" src="/Public/InsideAdmin/inside_admin_template/inside/jquery_chosen/chosen.jquery.min.js"></script>

<script>
    $(function(){

        $('.open_module_info_btn').on('click', function(){

            var block = $(this).parent().parent().next();

            var module_system_name = block.attr('module_system_name');

            // alert(block.html());

            if (block.html() == '') {
                $.get('/Inside_Modules/module_info/?system_name='+module_system_name, function(data){

                    block.html(data);

                })
            }

            block.toggle();

        });

        $('.modules-table tbody tr').on('dblclick', function(){

            $(this).find('.open_module_info_btn').click();

        });


    });

    function filter_send(){
        var values = $('#filter_type_select').val();
        $('.modules-table tr').hide();
        var no_show = false;
        values.forEach(function(element) {
            $('.modules-table tr[main_type='+element+']').show();
            no_show = true;
        });
        if (!no_show) $('.modules-table tr').show();
    };
    var filter_init = false;
    function filters_toggle(){
        $('#top_filter_holder').toggle();
        if (!filter_init) {
            $('.multiselect_chosen').chosen();
            filter_init = true;
        }
    }

</script>

<style>
    .list-group-item.active {
        font-size: 15px;
        padding: 7px 10px;
    }
    .multiselect_chosen {
        min-width: 450px;
    }
</style>