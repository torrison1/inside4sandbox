<div style="background: url('/Public/AppFront/app_default_template/img/bg1.jpg'); background-size:cover; background-position:center;" class="pt-4 pb-4">

    <div class="container">

        <div class="row profile_info">

            <div class="col-xs-12 col-sm-12 col-md-6">

                <ul class="list-group text-center">
                    <li class="list-group-item active">[<?=$user['id'];?>] <?=$user['username'];?> (<?=$user['email'];?>)</li>
                    <li class="list-group-item">

                        <!-- --------------------------------------- Profile Form --------------------------------------- -->

                        <div class="mt-3">

                            <?php if ($inside4_auth->in_groups(Array('admin', 'admin_demo'))) {?>
                            <a class="btn btn-primary w_full mb-3" target="_blank" href="<?=$lang_link_prefix?>/inside/admin">Inside Admin Panel &gt;&gt;</a>
                            <?php } ?>
                            <a class="btn btn-secondary mb-3" onclick="$('#user_pass').toggle();" ><?=$t->get('change_password');?></a>

                        </div>


                        <div id="user_pass" class="user_pass" style="display: none;">

                            <ul class="list-group mb-3">
                                <li class="list-group-item">

                                    <form method="post" id="ch_pass_form" class="p-3">

                                        <!-- Easy CSRF Token -->
                                        <input type="hidden" name="csrf_token" value="<?=$inside4_security->make_csfr_token($user['id'])?>">

                                        <div class="form-group row mt-1">
                                            <label for="old_password" class="col-md-5 col-form-label text-left"><?=$t->get('current_password');?></label>
                                            <div class="col-md-7">
                                                <input class="form-control" type="text" id="old_password"  name="old_password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="new_password" class="col-md-5 col-form-label text-left"><?=$t->get('new_password');?></label>
                                            <div class="col-md-7">
                                                <input class="form-control" type="text" id="new_password"  name="new_password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="confirm_password" class="col-md-5 col-form-label text-left"><?=$t->get('repeat_new_password');?></label>
                                            <div class="col-md-7 text-right">
                                                <input class="form-control" type="text" id="confirm_password"  name="confirm_password">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <label class="col-md-5 col-form-labe text-left"></label>
                                            <div class="col-md-7 text-right">

                                                <a class="btn btn-success change_pass"><?=$t->get('save_changes');?></a>
                                                <div class="ch_pass_msg message"></div>
                                            </div>
                                        </div>
                                    </form>

                                </li>
                            </ul>

                        </div>
                        <div>
                            <a title="LogOut" href="<?=$lang_link_prefix?>/auth/logout">Logout from profile</a>
                        </div>
                    </li>
                </ul>

                <ul class="list-group text-center mt-4">
                    <li class="list-group-item active">Your Promocode: <b>ZDK234865</b></li>
                    <li class="list-group-item"> <b>Level 1:</b> -20% Discount for all services</li>
                    <li class="list-group-item"> <img src="/Public/AppFront/app_default_template/img/sale1.jpg" alt="Discount" width="100%" class="wblock2"></li>
                    <li class="list-group-item"> <i>Next Level: Buy more 30 Services and Get -30%</i></li>
                </ul>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div>

                    <ul class="list-group">
                        <li class="list-group-item active text-center"><?=$t->get('personal_data');?></li>
                        <li class="list-group-item">
                            <form action="/auth_api/edit_info/" method="post" id="update_info_form" class="style_form form-inline" enctype="multipart/form-data">

                                <!-- Easy CSRF Token -->
                                <input type="hidden" name="csrf_token" value="<?=$inside4_security->make_csfr_token($user['id'])?>">

                                <div class="form-group row mt-1">
                                <label for="name" class="col-md-3 col-form-label text-left">NickName</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" id="name"  name="name" value="<?=$user['username']?>">
                                </div>
                            </div>
                                <div class="form-group row phone_view_bock">
                                    <label for="verify_phone" class="col-md-3 col-form-label text-left">Phone<br><br></label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" placeholder="+38__________" id="verify_phone"  name="phone" value="<?=$user['phone']?>">
                                        <?php if($user['phone']) { ?>
                                            <?php if(!$user['is_verified_phone']) { ?>
                                                <a class="verify_phone text-danger"><?=$t->get('verify_phone');?></a>
                                            <?php } else { ?>
                                                <a class="text-success"><?=$t->get('verified');?></a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a class="text-secondary"><?=$t->get('no_phone');?></a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label text-left">Email<br><br></label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" value="<?=$user['email']?>" name="email">
                                        <?php if(!$user['is_verified_email']) { ?>
                                            <a class="text-danger verify_email"><?=$t->get('verify_email');?></a>
                                        <?php } else { ?>
                                            <a class="text-success" disabled><?=$t->get('verified');?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            <div class="form-group row mt-1">
                                <label for="lang" class="col-md-3 col-form-label text-left"><?=$t->get('language');?></label>
                                <div class="col-md-9">
                                    <select class="wbgs1 form-control lang_select" name="lang" onchange="location.href = $(this).val();">
                                        <?php foreach ($t->getLanguages() as $lang) {
                                            ?>
                                            <option value="/<?=$lang['lang_alias']?><?=$GLOBALS['inside4']['main']['clear_uri']?>" lang="<?=$lang['lang_alias']?>"<?php if ($lang['lang_alias'] == $GLOBALS['inside4']['translate']['active_language']) echo " selected";?>>
                                                <?=$t->get($lang['lang_name']);?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label class="col-md-3 col-form-label text-left">Изображение</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <?php if ($user['img'] != '') { ?>
                                            <img src="<?= $user['img'] ?>" class="wblock1 profile_img" alt="User Image"/>
                                            <div class="checkbox checkbox_dell_img mt-1">
                                                <input type="checkbox" id="del_image" name="del_image" value="<?= $user['img'] ?>" style="display: inline-block !important;">
                                                <label for="del_image" class="d-inline">Отметка на удаление</label>
                                            </div>
                                        <?php } else { ?>
                                            <input id="file_select" class="form-control" type="file" name="image">
                                            <input id="img_code" name="img_code" type="hidden"/>
                                            <img id="show_img" style="width:100%; margin-top: 5px;"/>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label class="col-md-3 col-form-labe text-left"></label>
                                <div class="col-md-9 text-right">
                                    <a class="btn btn-success update_info"><?=$t->get('save_changes');?></a>
                                    <div class="uinfo_msg message"></div>
                                </div>
                            </div>
                            </form>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>


</div>