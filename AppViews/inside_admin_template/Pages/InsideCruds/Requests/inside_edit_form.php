<div id="cell_tabs_<?php echo $dialog_id; ?>">
    <div class="dialog_edit" edit_id="<?= $cell_id ?>" hidden></div>
    <!-- //i--- Tabs UL ; inside_custom_cruds ; torrison ; 01.06.2020 ; 1 ---/ -->
    <ul class="nav nav-tabs" role="tablist">
        <li style="float: right; width: 117px; height: 44px;"></li>
        <?php $first_tab = true;
        foreach ($table_config['cell_tabs_arr'] as $key => $value) { ?>
            <li role="presentation"<?php if ($first_tab) echo ' class="active"'; ?>><a href="#<?= $key ?>"
                                                                                       aria-controls="<?= $key ?>"
                                                                                       role="tab"
                                                                                       data-toggle="tab"><?= $value ?></a>
            </li>
            <?php $first_tab = false;
        } ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php foreach ($table_config['cell_tabs_arr'] as $key => $value) { ?>
            <div role="tabpanel" class="tab-pane active" id="<?= $key ?>">

                    <!-- //i--- Edit Request Forms (for every Tab) ; inside_custom_cruds ; torrison ; 01.06.2020 ; 2 ---/ -->
                    <div class="row">
                        <form method="post" enctype="multipart/form-data"
                              action="<?=$default_API_path?>edit_request/?table_name=<?= $table_name ?>&tab=<?= $key ?>&cell_id=<?= $edit_cell_arr[$key_field] ?>"
                              class="edit_tab_form" tab_id="<?= $key ?>">
                            <div class="top_controls">

                                <?php if (isset($table_config['edit_controls_off']) AND in_array($key, $table_config['edit_controls_off'])) { ?>
                                    <a style="" class="btn btn-info btn-success edit_dialog_update"
                                       table="<?= $table_name ?>" line_id="<?= $cell_id ?>"
                                       dialog_id="<?= $dialog_id ?>" tab_id="<?= $key ?>"><i class="fa fa-refresh"
                                                                                             aria-hidden="true"></i></a>
                                <?php } else { ?>
                                    <input type="button" style="" class="btn btn-info cell_tab_submit"
                                           tab_id="<?= $key ?>"value="Save"/>

                                    <a style="" class="btn btn-info btn-success edit_dialog_update"
                                       table="<?= $table_name ?>" line_id="<?= $cell_id ?>"
                                       dialog_id="<?= $dialog_id ?>" tab_id="<?= $key ?>"><i class="fa fa-refresh"
                                                                                             aria-hidden="true"></i></a>
                                <?php } ?>

                            </div>
                            <!-- //i--- Make Tabs with Inputs ; inside_custom_cruds ; torrison ; 01.06.2020 ; 3 ---/ -->
                            <?php for ($tab_column = 1; $tab_column <= 4; $tab_column++) { ?>
                                <div style="max-width: 700px; width: 100%; display: inline-block;">

                                    <?php
                                    // For Columns Inputs
                                    foreach ($table_columns as $config_row) {
                                        if (isset($gen_inputs_arr[$config_row['name']])) {
                                            if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                                            if (((isset($config_row['tab'])) && ($config_row['tab'] == $key)) AND $config_row['tab_column'] == $tab_column) { ?>

                                                <div class="form-group">
                                                    <label data-toggle="tooltip" data-placement="right"
                                                           class="color-tooltip"
                                                           title="<?php if (isset($config_row['help'])) echo $config_row['help']; ?>"><?= $config_row['text'] ?></label>
                                                    <?= $gen_inputs_arr[$config_row['name']] ?>
                                                </div>

                                            <?php }
                                        }
                                    } ?>

                                    <?php
                                    // For Relations Inputs
                                    if (isset($adv_rel_inputs)) {
                                        foreach ($adv_rel_inputs as $config_row) {

                                            if (isset($gen_inputs_arr[$config_row['name']])) {

                                                    if (!isset($config_row['tab_column'])) $config_row['tab_column'] = 1;
                                                    if (((isset($config_row['tab'])) && ($config_row['tab'] == $key)) AND $config_row['tab_column'] == $tab_column) { ?>

                                                        <div class="form-group">
                                                            <label data-toggle="tooltip" data-placement="right"
                                                                   class="color-tooltip"
                                                                   title="<?php if (isset($config_row['help'])) echo $config_row['help']; ?>"><?= $config_row['text'] ?></label>
                                                            <?= $gen_inputs_arr[$config_row['name']] ?>
                                                        </div>

                                                    <?php }
                                            }
                                        }
                                    } ?>

                                </div>
                            <?php } ?>
                            <div class="dialog_controls">

                                <!-- //i--- Make Save Buttons ; inside_custom_cruds ; torrison ; 01.06.2020 ; 4 ---/ -->
                                <?php if (!isset($table_config['edit_controls_off'])) { ?>
                                    <input type="button" style="position: absolute;right: 5px;bottom: 15px;"
                                           class="btn btn-info cell_tab_submit" tab_id="<?= $key ?>" value="Save"/>
                                <?php } elseif (!in_array($key, $table_config['edit_controls_off'])) { ?>
                                    <input type="button" style="position: absolute;right: 5px;bottom: 15px;"
                                           class="btn btn-info cell_tab_submit" tab_id="<?= $key ?>" value="Save"/>
                                <?php } ?>

                            </div>
                        </form>
                    </div>


            </div>

        <?php } ?>
    </div>
</div>
<script>
    //i--- Insert Add tooltips for help data ; inside_custom_cruds ; torrison ; 01.06.2020 ; 4 ---/
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('.selectpicker').selectpicker();
    });
</script>