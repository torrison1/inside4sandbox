<script>
    $(function() {
        // ------------------------------------------ Login ----------------
        $('#login-ok').on('click', function() {

            var options = {
                url: "<?=$lang_link_prefix?>/Auth_API/check_login/",
                success: function(obj) {
                    if (obj.status == "success") {

                        if (typeof(obj.redirect) != "undefined") {
                            document.location = obj.redirect;
                        } else {
                            document.location.reload();
                        }
                    } else {
                        $('#login-email').addClass('red_border');
                        $('#login-pass').addClass('red_border');
                        $('#login_message').html(obj.message);
                    }
                }
            };
            // передаем опции в  ajaxSubmit
            $("#auth_form").ajaxSubmit(options);
        });


        // ---------------------------------------- Dublicate For KeyDown ---
        $('#login-pass').keyup(function (event) {
            if(event.keyCode=='13') {
                $('#login-ok').click();
            }

        });
        // ------------------------------------------ Reg ----------------
        $('#reg-ok').on('click', function() {

            var options = {
                url: "<?=$lang_link_prefix?>/Auth_API/check_reg/",
                success: function(obj) {
                    if (obj.status == "success") {

                        if (typeof(obj.redirect) != "undefined") {
                            document.location = obj.redirect;
                        } else {
                            document.location.reload();
                        }
                    } else {
                        $('#reg-email').addClass('red_border');
                        $('#reg-pass').addClass('red_border');
                        $('#register_message').html(obj.message);
                    }
                }
            };
            // передаем опции в  ajaxSubmit
            $("#auth_reg_form").ajaxSubmit(options);

        });

        $('#fgot_pass').on('click', function() {
            $("#register").toggle()
            $("#recovery").toggle()

        });
        $('#cancel_recovery').on('click', function() {
            $("#recovery").hide()
            $("#register").show()

        });

        // ---------------------------------------- Dublicate For KeyDown ---
        $('#reg-pass').keyup(function (event) {
            if(event.keyCode=='13') {
                $('#reg-ok').click();
            }

        });

        // ------------------------------------------ Recovery ----------------
        $('#instruction-ok').on('click', function() {

            var options = {
                url: "<?=$lang_link_prefix?>/Auth_API/check_recovery/",
                success: function(obj) {
                    if (obj.status == "success") {
                        $('#recovery_message').html(obj.message);
                        $('#instruction-ok').hide();
                    } else {
                        $('#rec-email').addClass('red_border');
                        $('#recovery_message').html(obj.message);
                    }
                }
            };
            // передаем опции в  ajaxSubmit
            $("#auth_recovery_form").ajaxSubmit(options);
        });


        // ---------------------------------------- Dublicate For KeyDown ---
        $('#rec-email').keyup(function (event) {
            if(event.keyCode=='13') {
                $('#instruction-ok').click();
            }

        });

    });

    // Login register tabs
    $(".tab_btn").on("click", function(){
        var target = $(this).attr("data-target");

        $(".tab_btn").removeClass("active");
        $(this).addClass("active");

        $(".tab").hide();
        $(".tab." + target).show("fast");
    });



    $(function(){
        <?php if (isset($_GET['reg'])) { ?>

        $(".register_btn_login").trigger('click');

        var cookie_req_user_type = $.cookie('req_user_type');

        setTimeout ( function(){
            if (typeof cookie_req_user_type !== 'undefined')
            {
                $.removeCookie('req_user_type', { path: '/' });
                $.cookie('req_user_type', <?php echo intval($_GET['reg']); ?>, { expires: 1, path: '/' });
            }
            else {
                $.cookie('req_user_type', <?php echo intval($_GET['reg']); ?>, { expires: 1, path: '/' });
            }
        });


        <?php } ?>
    });

</script>