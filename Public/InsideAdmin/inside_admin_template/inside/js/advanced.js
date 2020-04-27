//MASSIVE REALTY EMAILING
function mass_realty_emailing_filters() {

    $.ajax({
        url: '/admin/inside_ajax/mass_realty_emailing_select_data/',
        success: function (data) {

            var options = '';
            data = JSON.parse(data);
            for (var key in data) {
                options += '<option value="' + data[key].id + '">' + data[key].name + '</option>';
            }

            //form filters
            var html = '<br><div style="border: 1px solid #ccc; padding: 10px; display: inline-block; width: 285px">' +
                '<select name="type" multiple style="width: 100%">' +
                options +
                '</select>' +
                '<br><br>' +
                '<input type="number" name="price_from" type="text" style="width: 49%" placeholder="Бюджет от" min="0"> ' +
                '<input type="number" name="price_to" type="text" style="width: 49%" placeholder="Бюджет до" min="0">' +
                '<br><br>' +
                '<input type="number" name="m_from" type="text" style="width: 49%" placeholder="Площадь от" min="0"> ' +
                '<input type="number" name="m_to" type="text" style="width: 49%" placeholder="Площадь до" min="0">' +
                '<br><br>' +
                'Отправить партнёрам <input class="send_partners" name="partners" type="checkbox">' +
                '<button class="btn btn-warning m_submit_realty_emailing_filter" type="button" style="margin-left: 16px">Показать</button></div><br><br>';

            //create dialog
            form_dialog(html, 'auto', 'auto', 'Massive mailing system', 'm_filter_dialog');
            //chosen
            $('select[name="type"]').chosen({width: '100%', search_contains: true});
            mass_realty_emailing_filters_request();

        },
        error: function () {
            alert('Ошибка');
        }
    });
}

function mass_realty_emailing_filters_request() {
    $('.m_submit_realty_emailing_filter').on('click', function () {
        //block on
        $(this).prop('disabled', true);

        var mailing_params = {
            'type': $('select[name="type"]').val(),
            'price_from': $('input[name="price_from"]').val(),
            'price_to': $('input[name="price_to"]').val(),
            'm_from': $('input[name="m_from"]').val(),
            'm_to': $('input[name="m_to"]').val(),
            'partners': $('input[name="partners"]').val()
        };

        //-------------------------------------------------------------------------------
        $.ajax({
            url: '/admin/inside_ajax/realty_emailing_table/',
            type: 'POST',
            data: mailing_params,
            success: function (data) {

                //++++++++++++++++++++++++++++++++++++
                if (data) {

                    data = JSON.parse(data);

                    var html = '<div align="center"style="margin-top: 10px; ">' +
                        '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_filters_currency" value="uah" checked>Гривна</label>' +
                        '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_filters_currency" value="usd">Доллар</label>' +
                        '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_filters_currency" value="eur">Евро</label>' +
                        '</div>';

                    html += '<br><table class="table table-bordered"><tr><th>ID</th><th>FIO</th><th>EMAIL</th><th>COMPANY</th><th>&#9998;</th><th class="m_checkall" style="cursor: pointer;">&#10004;</th></tr>';
                    for (var key in data) {
                        html += '<tr><td>' + data[key].id + '</td><td>' + data[key].fio + '</td><td>' + data[key].email + '</td><td>' + data[key].company + '</td><td class="m_mailing_edit_user" user_id="' + data[key].id + '" style="cursor: pointer"><i class="fa fa-edit"></i></td><td class="m_check_user_mail" style="cursor: pointer"><input style="cursor: pointer" name="m_mailing_users"  email="' + data[key].email + '" value="' + data[key].id + '" type="checkbox"></td></tr>';
                    }

                    html += '<table>';
                    html += '<button type="button" class="m_send_mails_to_users btn btn-warning">Отправить</button><br><br>';

                    //create dialog
                    if ($(document).width() > 800) {
                        form_dialog(html, 'auto', 'auto', 'Massive mailing system', 'm_mailing_list');
                    } else {
                        form_dialog(html, 350, 'auto', 'Massive mailing system', 'm_mailing_list');
                    }

                    //delete filter dialog
                    $('.m_filter_dialog').remove();

                    //scripts
                    $('.m_check_user_mail').on('click', function () {
                        $(this).find('input').click();
                    });
                    $('.m_check_user_mail input[type=checkbox]').click(function (e) {
                        e.stopPropagation();
                    });

                    $('.m_mailing_edit_user').click(function () {
                        open_edit_dialog($(this).attr('user_id'), 'users');
                    });

                    //click on all checkboxes
                    $('.m_checkall').on('click', function () {
                        $('.m_check_user_mail input[type=checkbox]').prop('checked', true);
                    });

                    //gathering mails
                    $('.m_send_mails_to_users').on('click', function () {
                        //block on
                        $(this).prop('disabled', true);
                        users_data = [];
                        $('.m_mailing_list input:checkbox:checked').each(function () {
                            users_data.push({email: $(this).attr('email'), id: this.value});
                        });

                        //===============================================
                        if (users_data.length > 0) {
                            $.ajax({
                                url: '/admin/inside_ajax/mass_realty_emailing_filters/',
                                type: 'POST',
                                data: {
                                    cell_ids: inside_make_selected_string(),
                                    data: users_data,
                                    currency: $('input[name="mass_realty_emailing_filters_currency"]:checked:enabled').val(),
                                    params: mailing_params //for next step
                                },
                                success: function () {
                                    alert('Выполнено!');
                                    //delete mailing list dialog
                                    $('.m_mailing_list').remove();
                                    //block off
                                    setTimeout(function () {
                                        $('.m_send_mails_to_users').prop('disabled', false);
                                    }, 100);
                                },
                                error: function () {
                                    alert("Ошибка");
                                    //block off
                                    setTimeout(function () {
                                        $('.m_send_mails_to_users').prop('disabled', false);
                                    }, 100);
                                }
                            });
                        } else {
                            alert('Пользователи не выбраны!');
                            //block off
                            setTimeout(function () {
                                $('.m_send_mails_to_users').prop('disabled', false);
                            }, 100);
                        }
                        //===============================================
                    });

                    //if data
                    //block off
                    setTimeout(function () {
                        $('.m_submit_realty_emailing_filter').prop('disabled', false);
                    }, 100);

                } else {
                    alert('Пользователей по данным критериям не найдено');
                    //block off
                    setTimeout(function () {
                        $('.m_submit_realty_emailing_filter').prop('disabled', false);
                    }, 100);
                }
            },
            //++++++++++++++++++++++++++++++++++++

            error: function () {
                alert("Ошибка");
                //block off
                setTimeout(function () {
                    $('.m_submit_realty_emailing_filter').prop('disabled', false);
                }, 100);
            }

        });
        //-------------------------------------------------------------------------------
    });
}

//===========================================================CLIENTS EMAILING
function mass_realty_emailing_clients() {

    $.ajax({
        url: '/admin/inside_ajax/mass_realty_emailing_get_users/',
        success: function (data) {

            //alert(data);
            var options = '';
            var tmp_users_company;
            data = JSON.parse(data);

            if ($(document).width() > 800) {
                for (var key in data) {
                    tmp_users_company = (data[key].company != '') ? ' (' + data[key].company + ')' : '';
                    options += '<option data-icon="glyphicon-envelope" data-subtext="' + data[key].email + '" value="' + data[key].id + '">[' + data[key].id + '] ' + data[key].fio + tmp_users_company + '</option>';
                }
                //form users list
                var html = '<br><div style="border: 1px solid #ccc; padding: 10px; display: inline-block;">' +
                    '<select  class="selectpicker" name="type_all_users" data-show-subtext="true" data-live-search="true" data-size="5" multiple data-selected-text-format="count">' +
                    options +
                    '</select>' +
                    '<div align="center" style="margin-top: 10px; ">' +
                    '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_clients_currency" value="uah" checked>Гривна</label>' +
                    '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_clients_currency" value="usd">Доллар</label>' +
                    '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_clients_currency" value="eur">Евро</label></div>' +
                    '<button class="btn btn-warning send_realty_emailing" type="button" style="width: 100%; margin-top: 10px">Разослать</button></div>';
                //create dialog
                form_dialog(html, 560, 350, 'All clients massive emailing', 'massive_emailing_all_users');
            } else {
                for (var key in data) {
                    options += '<option  data-icon="glyphicon-envelope" value="' + data[key].id + '">[' + data[key].id + '] ' + data[key].fio + '</option>';
                }
                //form users list
                var html = '<br><div style="border: 1px solid #ccc; padding: 10px; display: inline-block;">' +
                    '<select  class="selectpicker" name="type_all_users" data-show-subtext="true" data-live-search="true" data-size="5" multiple data-selected-text-format="count">' +
                    options +
                    '</select>' +
                    '<div align="center" style="margin-top: 10px; ">' +
                    '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_clients_currency" value="uah" checked>Гривна</label>' +
                    '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_clients_currency" value="usd">Доллар</label>' +
                    '<label class="radio-inline"><input type="radio" name="mass_realty_emailing_clients_currency" value="eur">Евро</label></div>' +
                    '<button class="btn btn-warning send_realty_emailing" type="button" style="width: 100%; margin-top: 10px">Разослать</button></div>';
                //create dialog
                form_dialog(html, 350, 300, 'All clients massive emailing', 'massive_emailing_all_users');
            }

            $('.selectpicker').selectpicker({dropupAuto: false});

            //===============================================
            $('.send_realty_emailing').on('click', function () {

                //block on
                $('.send_realty_emailing').prop('disabled', true);

                var users_ids = $('select[name="type_all_users"]').val();

                if (users_ids.length > 0) {
                    $.ajax({
                        url: '/admin/inside_ajax/mass_realty_emailing_clients/',
                        type: 'POST',
                        data: {
                            cell_ids: inside_make_selected_string(),
                            currency: $('input[name="mass_realty_emailing_clients_currency"]:checked:enabled').val(),
                            users_ids: users_ids
                        },
                        success: function () {
                            alert('Выполнено!');
                            //delete mailing list dialog
                            $('.massive_emailing_all_users').remove();
                            //block off
                            setTimeout(function () {
                                $('.send_realty_emailing').prop('disabled', false);
                            }, 100);
                        },
                        error: function () {
                            alert("Ошибка");
                            //block off
                            setTimeout(function () {
                                $('.send_realty_emailing').prop('disabled', false);
                            }, 100);
                        }
                    });
                } else {
                    alert('Пользователи не выбраны!');
                    //block off
                    setTimeout(function () {
                        $('.send_realty_emailing').prop('disabled', false);
                    }, 100);
                }
            });
            //===============================================

        },
        error: function () {
            alert('Ошибка');
        }
    });
}

//=========================================================== EMAILING STATISTIC
function get_emailing_statistics() {

    var html = '';
    // get html statistics data from php
    $.get('/admin/inside_ajax/get_emailing_statistics/', function (data) {
        html += data;
    });

    //create dialog
    form_dialog(html, 'auto', 'auto', 'Emailing statistics', 'emailing_statistics');
}


/* ПЕРЕНЁС В INTERFACE_FOOTER
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
 */
