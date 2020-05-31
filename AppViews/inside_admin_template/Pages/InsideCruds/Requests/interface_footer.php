
<!-- //i--- Pre-load JS Scripts and CSS Files ; inside_custom_cruds ; torrison ; 01.06.2020 ; 1 ---/ -->

<link rel="stylesheet" href="/Public/InsideAdmin/inside_admin_template/inside/css/ui.multiselect.css">
<link rel="stylesheet" href="/Public/InsideAdmin/inside_admin_template/inside/css/ui.combobox.css">

<script src="/Public/InsideAdmin/inside_admin_template/inside/js/jquery.dialog.extra.js"></script>

<script type="text/javascript" src="/Public/InsideAdmin/inside_admin_template/inside/js/scrollTo/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="/Public/InsideAdmin/inside_admin_template/inside/js/ui.multiselect.js"></script>
<script type="text/javascript" src="/Public/InsideAdmin/inside_admin_template/inside/js/ui.combobox.js"></script>

<script src="/Public/InsideAdmin/inside_admin_template/inside/js/jquery.stickytableheaders.min.js" type="text/javascript"></script>

<script>

    <!-- //i--- Legacy Code from Inside System + PowerDataGrid v. 2.1. ; inside_custom_cruds ; torrison ; 01.06.2020 ; 2 ---/ -->

    var global_pdg_table = $('#pdg_table').val();
    var global_api_path = '<?=$default_API_path?>';

    $(document).ready(function () {

        // Swith off async AJAX
        $.ajaxSetup({async: false});

        //i--- Open edit dialog from GET link ?site_open={$row_id}  ; inside_custom_cruds ; torrison ; 01.06.2020 ; 3 ---/
        if(Number(getUrlParameter('site_open')) > 0) {
            open_edit_dialog(getUrlParameter('site_open'), global_pdg_table);
        }

        //i--- Send First Control Form On Load  ; inside_custom_cruds ; torrison ; 01.06.2020 ; 4 ---/
        inside_send_control_form();

        //i--- CONTROL FORM actions : Send/Update, Order by Column, Fast Search, Limit Change, Pagination  ; inside_custom_cruds ; torrison ; 01.06.2020 ; 5 ---/

        // Send Button Click
        $("#pdg_send").on('click', inside_send_control_form);
        // Order Column Click
        $("#inside_terminal").on('click', '.pdg_column_header', function () {
            $("#pdg_order").val($(this).attr('column'));
            if ($("#pdg_asc").val() == 'asc') $("#pdg_asc").val('desc');
            else {
                if ($("#pdg_asc").val() == 'desc') $("#pdg_asc").val('asc');
            }
            inside_send_control_form();
        });
        // Fast Search
        $("#pdg_fsearch").on("keydown", function () {
            if (pdg_timer[this.id] !== undefined) clearTimeout(pdg_timer[this.id]);
            pdg_timer[this.id] = setTimeout("inside_send_control_form()", 700);
        });
        // Select Limit
        $("#pdg_limit").on("keydown", function () {
            if (pdg_timer[this.id] !== undefined) clearTimeout(pdg_timer[this.id]);
            pdg_timer[this.id] = setTimeout("inside_send_control_form()", 700);
        });

        // Page Prev
        $("#pdg_page_prev").on("click", function () {
            if ($('#pdg_page').val() > 1) {
                var tmp_page = parseInt($('#pdg_page').val()) - 1;
                $('#pdg_page').val(tmp_page);
                $('#pdg_page_text').html(tmp_page);
                inside_send_control_form();
            }
        });

        // Page Next
        $("#pdg_page_next").on("click", function () {
            if (1) {
                var tmp_page = parseInt($('#pdg_page').val()) + 1;
                $('#pdg_page').val(tmp_page);
                $('#pdg_page_text').html(tmp_page);
                inside_send_control_form();
            }
        });

        //i--- TERMINAL table actions : click on line, checkboxes, add, copy, delete buttons ; inside_custom_cruds ; torrison ; 01.06.2020 ; 6 ---/

        // Click on Line
        $("#inside_terminal").on('click', 'tr.table_row', function () {
            var line = $(this);
            if (!line.hasClass('hover_line')) {
                line.addClass('hover_line');
                line.find('.pdg_column_checkbox').prop('checked', true);
            }
            else {
                line.removeClass('hover_line');
                line.find('.pdg_column_checkbox').prop('checked', false);
            }
        });
        $("#inside_terminal").on('click', '.pdg_column_checkbox', function (e) {
            // Stop more Events
            e.stopPropagation();
        });

        // Add Button
        $(".add_btn").on('click', function () {
            open_add_dialog(global_pdg_table)
        });

        // Copy Button
        $(".pdg_bcopy").on('click', function () {
            $('input:checkbox:checked.pdg_column_checkbox').each(function () {
                open_copy_dialog(this.value, global_pdg_table);
            });
        });
        $('#inside_terminal').on('click', '.mobile_copy_btn', function () {
            open_copy_dialog($(this).attr('line_id'), global_pdg_table);
        });

        //i--- Delete Dialogs with API Requests ; inside_custom_cruds ; torrison ; 01.06.2020 ; 7 ---/

        // Mobile delete
        $('#inside_terminal').on('click', '.mobile_del_btn', function (e) {

            var mob_line_id = $(this).attr('line_id');

            var input = '<input type="hidden" name="del_ids[]" value="' + mob_line_id + '" />';
            var text = "Selected cell ID: <br />" + mob_line_id;
            var button = '<br /><br /><div class="del_btn_div"><input type="button" class="btn btn-danger cell_tab_submit" tabindex="-1" dialog_id="' + dialog_id + '" value="Delete" /></div>';

            // Make Dialog
            $("<div cell_id='" + mob_line_id + "'><form method='post' action='"+global_api_path+"del_request/?table_name=" + global_pdg_table + "' dialog_id=" + dialog_id + ">" + text + input + button + "</form></div>").dialog({
                autoOpen: true,
                title: 'Delete fields',
                width: 300,
                height: 200,
                canMinimize: true,
                canMaximize: true,
                position: {
                    collision: 'none'
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });
            // Dialog Shift
            dialog_shift();
        });

        // Delete Elements
        $(".pdg_bdel").on('click', function () {

            var del_ids = "";
            var input = "";

            $('input:checkbox:checked.pdg_column_checkbox').each(function () {
                del_ids = del_ids + this.value + ', ';
                input += '<input type="hidden" name="del_ids[]" value="' + this.value + '" />';
            });

            var text = "Selected cells IDs: <br />" + del_ids.slice(0, -2);
            var button = '<br /><br /><div class="del_btn_div"><input type="button" class="btn btn-danger cell_tab_submit" tabindex="-1" dialog_id="' + dialog_id + '" value="Delete" /></div>';

            // Delete Dialog
            $("<div cell_id='" + this.value + "'><form method='post' action='"+global_api_path+"del_request/?table_name=" + global_pdg_table + "' dialog_id=" + dialog_id + ">" + text + input + button + "</form></div>").dialog({
                autoOpen: true,
                title: 'Delete fields',
                width: 300,
                height: 200,
                canMinimize: true,
                canMaximize: true,
                position: {
                    collision: 'none'
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });
            // Dialog Shift
            dialog_shift();

        });

        //i--- CRUD Edit, Delete Dialogs Load on Table Cells DblClick or Buttons Click ; inside_custom_cruds ; torrison ; 01.06.2020 ; 8 ---/

        // Dbl Clink on Line
        $("#inside_terminal").on('dblclick', '.pdg_column_cell', function () {
            open_edit_dialog($(this).attr('line_id'), global_pdg_table);
        });

        // Edit Button
        $("#inside_terminal").on('click', '.pdg_button_edit', function () {
            open_edit_dialog($(this).attr('line_id'), global_pdg_table);
        });

        // Update Edit Dialog
        $("body").on('click', '.edit_dialog_update', function () {
            update_edit_dialog($(this).attr('line_id'), $(this).attr('dialog_id'), $(this).attr('table'))
        });


        //i--- Edit, Delete Dialogs Requsts Answers ; inside_custom_cruds ; torrison ; 01.06.2020 ; 9 ---/
        $("body").on('click', '.cell_tab_submit', function () {

            $(this).attr('disabled', 'disabled');

            var inside_temporary_dialog_message;
            that = $(this);

            $(this).parent().parent().ajaxSubmit({
                error: function () {
                    inside_temporary_dialog_message = 'Error';
                    inside_temporary_dialog(inside_temporary_dialog_message);
                    that.removeAttr('disabled');

                },
                success: function (data) {
                    if (!data) {
                        inside_temporary_dialog_message = 'Access Denied';
                        that.removeAttr('disabled');
                    } else {
                        inside_temporary_dialog_message = 'Data Saved!';
                    }
                    inside_temporary_dialog(inside_temporary_dialog_message);
                    that.removeAttr('disabled');
                }
            });
        });


        //i--- Checkboxes Click ALL ; inside_custom_cruds ; torrison ; 01.06.2020 ; 10 ---/
        $('#inside_terminal').on('click', 'input#box0', function () {

            var check_all = this;
            var line = $(this);

            if (check_all.checked) {
                $('.pdg_column_checkbox').prop("checked", true);
                $("#inside_terminal tr.table_row").addClass('hover_line');
            } else {
                $('.pdg_column_checkbox').prop("checked", false);
                $("#inside_terminal tr.table_row").removeClass('hover_line');
            }
        });

        $('#inside_terminal').on('click', '.pdg_column_checkbox_label', function (e) {
            e.stopPropagation();
            $(this).prev().trigger('click');
        });


        $('#inside_terminal').on('click', '.pdg_column_cell', function (e) {
            $(this).find('.crud_edit_btn').trigger('click');
        });

        //i--- Cells FAST CRUD EDIT System ; inside_custom_cruds ; torrison ; 01.06.2020 ; 11 ---/
        $('#inside_terminal').on('click', '.crud_edit_btn', function (e) {
            var table_text = $(this).next();
            var new_value = prompt('', table_text.html());
            if (new_value !== null) {
                $.post(global_api_path+'fast_edit/', {
                    table: global_pdg_table,
                    column: $(this).attr('column'),
                    key_id: $(this).attr('key_id'),
                    line_id: $(this).attr('line_id'),
                    value: new_value
                }, function () {
                    table_text.html(new_value);
                });
            }
            e.stopPropagation();
        });

    // End of Ready.Document Functions
    });

    //===========================================================================================================
    // -------------------------------------    MAIN FUNCTIONS    -----------------------------------------------
    //===========================================================================================================

    //i--- Open ADD tabs Forms in Dialog ; inside_custom_cruds ; torrison ; 01.06.2020 ; 12 ---/
    function open_add_dialog(pdg_table) {
        var dialog_height;
        var screen_width = $(document).width();
        if (screen_width > 800) screen_width = 800;
        if (screen_width == 800) dialog_height = 600; else dialog_height = 'auto';

        $("<div dialog_id='" + dialog_id + "'></div>").dialog({
            autoOpen: true,
            title: 'Add',
            width: screen_width,
            height: dialog_height,
            canMinimize: true,
            canMaximize: true,
            position: {
                my: "top",
                at: "top",
                of: document,
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        // AJAX load information
        var array = {pdg_table: pdg_table, dialog_id: dialog_id};
        $.post(global_api_path+'add_dialog/', array, function (data) {
            // Add new AJAX Data
            $('div[dialog_id=' + dialog_id + ']').html(data);
            // Activate Tabs
            $("#cell_tabs_" + dialog_id).tabs();
            // Load HTML Editor if it created
            $('div[dialog_id=' + dialog_id + '] .html_editor').each(function (i, val) {
                CKEDITOR.replace(val);
            });
            $('div[dialog_id=' + dialog_id + '] .ac_select').combobox();
            $('div[dialog_id=' + dialog_id + '] .pdg_mselect').multiselect();
        });
        // Dialog Shift
        dialog_shift();
    }

    //i--- Open COPY tabs Forms in Dialog ; inside_custom_cruds ; torrison ; 01.06.2020 ; 13 ---/
    function open_copy_dialog(tmp_line_id, pdg_table) {
        var dialog_height;
        var screen_width = $(document).width();
        if (screen_width > 800) screen_width = 800;
        if (screen_width == 800) dialog_height = 600; else dialog_height = 'auto';

        $("<div dialog_id='" + dialog_id + "'></div>").dialog({
            autoOpen: true,
            title: 'Copy #' + tmp_line_id,
            width: screen_width,
            height: dialog_height,
            canMinimize: true,
            canMaximize: true,
            position: {
                my: "top",
                at: "top",
                of: document,
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        // AJAX load information
        var array = {cell_id: tmp_line_id, pdg_table: pdg_table, dialog_id: dialog_id};
        $.post(global_api_path+'add_dialog/' + tmp_line_id, array, function (data) {
            // Add new AJAX Data
            $('div[dialog_id=' + dialog_id + ']').html(data);
            // Activate Tabs
            $("#cell_tabs_" + dialog_id).tabs();
            // Load HTML Editor if it created
            $('div[dialog_id=' + dialog_id + '] .html_editor').each(function (i, val) {
                CKEDITOR.replace(val);
            });
            $('div[dialog_id=' + dialog_id + '] .ac_select').combobox();
            $('div[dialog_id=' + dialog_id + '] .pdg_mselect').multiselect();
        });
        // Dialog Shift
        dialog_shift();
    }

    //i--- Open Edit tabs Forms in Dialog ; inside_custom_cruds ; torrison ; 01.06.2020 ; 14 ---/
    function open_edit_dialog(tmp_line_id, pdg_table) {

        if ($('.dialog_edit[edit_id=' + tmp_line_id + ']').length > 0 && global_pdg_table == pdg_table) {
            alert('Dialog already Opened!');
        }
        else {

            var dialog_height;
            var screen_width = $(document).width();
            if (screen_width > 800) screen_width = 800;
            if (screen_width == 800) dialog_height = 600; else dialog_height = 'auto';

            $("<div dialog_id='" + dialog_id + "'></div>").dialog({
                autoOpen: true,
                title: 'Edit #' + tmp_line_id,
                width: screen_width,
                height: dialog_height,
                canMinimize: true,
                canMaximize: true,
                position: {
                    my: "top",
                    at: "top",
                    of: document,
                    collision: 'none'
                },
                close: function (event, ui) {
                    $(this).remove();
                }
            });

            // AJAX load information
            var array = {cell_id: tmp_line_id, pdg_table: pdg_table, dialog_id: dialog_id};

            update_edit_dialog(tmp_line_id, dialog_id, pdg_table);

            dialog_shift();
        }
    }
    // Update Edit tabs Forms in Dialog
    function update_edit_dialog(tmp_line_id, dialog_id, pdg_table) {
        //dump_alert(pdg_table);
        $('div[dialog_id=' + dialog_id + ']').html('...');
        // AJAX load information
        var array = {cell_id: tmp_line_id, pdg_table: pdg_table, dialog_id: dialog_id};
        $.post(global_api_path+'edit_dialog/', array, function (data) {
            $('div[dialog_id=' + dialog_id + ']').html(data);
            $('div[dialog_id=' + dialog_id + ']').show();
            // Activate Tabs
            $("#cell_tabs_" + dialog_id).tabs();
            // Load HTML Editor if it created
            $('div[dialog_id=' + dialog_id + '] .html_editor').each(function (i, val) {
                CKEDITOR.replace(val);
            });
            $('div[dialog_id=' + dialog_id + '] .ac_select').combobox();
            $('div[dialog_id=' + dialog_id + '] .pdg_mselect').multiselect();
        });
    }

    //i--- Temporary Dialogs ; inside_custom_cruds ; torrison ; 01.06.2020 ; 15 ---/
    function inside_temporary_dialog($message) {
        $("<div class='success_info' dialog_id=" + dialog_id + "><b>" + $message + "</b></div>").dialog({
            autoOpen: true,
            title: 'Message',
            width: 200,
            height: 90,
            canMinimize: true,
            canMaximize: true,
            position: {
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        setTimeout("$('.success_info[dialog_id=" + dialog_id + "]').fadeIn('slow', function(){$(this).remove()})", 1200);
        dialog_id++;
    }

    function inside_temporary_dialog_with_time($message, $time) {
        $("<div class='success_info' dialog_id=" + dialog_id + "><b>" + $message + "</b></div>").dialog({
            autoOpen: true,
            title: 'Message',
            width: 230,
            height: 110,
            canMinimize: true,
            canMaximize: true,
            position: {
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        setTimeout("$('.success_info[dialog_id=" + dialog_id + "]').fadeIn('slow', function(){$(this).remove()})", $time);
        dialog_id++;
    }

    //=====================================================================

    //i--- Get Scope API Request ; inside_custom_cruds ; torrison ; 01.06.2020 ; 15 ---/
    function inside_send_control_form() {
        $('#inside_terminal').animate(
            {
                opacity: 0.1,
            }, 200, function () {

                var options = {
                    target: "#inside_terminal",
                    url: global_api_path+"requests_scope/",
                    success: function () {

                        // Resizable
                        $(".pdg_column").resizable({handles: 'e'});

                        // Add fixed table-head
                        $(".stickytable").stickyTableHeaders();
                    }
                };
                // передаем опции в  ajaxSubmit
                $("#control_form").ajaxSubmit(options);

                $('#inside_terminal').animate({opacity: 1}, 500);
            });
    };

    //i--- Reset Filters Form Action ; inside_custom_cruds ; torrison ; 01.06.2020 ; 16 ---/
    function refresh_control_form() {

        $('#control_form')[0].reset();

        $('#control_form').find('.selectpicker').each(function () {

            $(this).val('').selectpicker('refresh');

        });

    }

    //i--- INSIDE FUNCTIONS Helpers ; inside_custom_cruds ; torrison ; 01.06.2020 ; 17 ---/
    function inside_make_selected_array() {
        var ids = [];

        $('input:checkbox:checked.pdg_column_checkbox').each(function () {
            ids.push(this.value);
        });

        return ids;
    }

    function inside_make_selected_string() {
        var ids = "";

        $('input:checkbox:checked.pdg_column_checkbox').each(function () {
            ids += this.value + ', ';
        });

        return $.trim(ids).replace(/^,|,$/g,''); //обрезает запятые  с начала и конца
    }

    function form_dialog(html, width, height, title, div_class) {
        // Make Dialog
        $('<div class="' + div_class + '" >' + html + '</div>').dialog({
            autoOpen: true,
            title: title,
            width: width,
            height: height,
            canMinimize: true,
            canMaximize: true,
            position: {
                collision: 'none'
            },
            close: function (event, ui) {
                $(this).remove();
            }
        });
        // Dialog Shift
        dialog_shift();
    }

    // GET PARAMETERS
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

</script>
		