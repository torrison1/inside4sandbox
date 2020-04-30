<td colspan="7">
    <ul class="list-group">
        <li class="list-group-item active"><?=$module_name?></li>
        <li class="list-group-item">
            <div class="wblock1" style="padding: 10px; margin-bottom: 20px;">
                <!--
                <img src="<?=$module_img?>" style="display: block; float: left; width: 15%; margin-right: 10px;" class="wblock1">
                -->
                <h2 style="margin-bottom: 7px;"><?=$module_name?></h2>
                <p>
                    <b><?=$module_name?></b> - <?=$module_description?>
                </p>
                <div class="clearfix"></div>
            </div>

            <?php if ($module_terminal != '') { ?>
                <ul class="list-group">
                    <li class="list-group-item active">Терминал / Dashboard</li>
                    <li class="list-group-item">
                        <?=$module_terminal?>
                    </li>
                </ul>
            <?php } ?>

            <?php if ($system_elements != '') { ?>
                <ul class="list-group">
                    <li class="list-group-item active">Main System Elements</li>
                    <li class="list-group-item">
                        <?=$system_elements?>
                    </li>
                </ul>
            <?php } ?>

            <?php if ($module_how_to_use != '') { ?>
                <ul class="list-group">
                    <li class="list-group-item active">Как использовать?</li>
                    <li class="list-group-item">
                        <?=$module_how_to_use?>
                    </li>
                </ul>
            <?php } ?>

            <ul class="list-group">
                <li class="list-group-item active">Функции и настройки</li>
                <li class="list-group-item">
                    <a class="btn btn-xs btn-success">Я ознакомлен с функционалом!</a>
                </li>
            </ul>

            <?php if ($manual_html != '') { ?>
                <ul class="list-group">
                    <li class="list-group-item active">Файлы системы и функции</li>
                    <li class="list-group-item">
                        <?=$manual_html?>
                    </li>
                </ul>
            <?php } ?>
        </li>
    </ul>
</td>