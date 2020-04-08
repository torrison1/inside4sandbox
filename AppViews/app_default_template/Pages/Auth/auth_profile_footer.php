<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!-- Confirm JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>

<script src="/Public/JQuery/canvas/jquery.exif.js"></script>
<script src="/Public/JQuery/canvas/jquery.canvasResize.js"></script>

<script>

	$(function(){

		$('#verify_phone').mask('+000000000000');

		// --------------- For Analytics -------------- //
		<?php if (isset($_GET['reg'])) { ?>

        if ("ga" in window) { tracker = ga.getAll()[0]; if (tracker) tracker.send('event', 'Auth', 'reg_<?=$user['id']?>'); }

		setTimeout(function(){
			if (!confirm('<?=$t->get('agreement_alert');?>')) {
				location.href = '<?=$lang_link_prefix?>/main/privacy';
			};
		}, 3000);

		<?php } ?>

		// ------------ Change Password JS -------------- //
		$('.change_pass').on('click', function(){

			var options = {
				url: "<?=$lang_link_prefix?>/Auth_API/change_password/",
				success: function(obj) {

					if (obj.status == "success") {

						$('.ch_pass_msg').removeClass('red');
						$('.ch_pass_msg').addClass('green');
						$('.ch_pass_msg').html(obj.message);
						$('#old_password').removeClass('red_border');
						$('#new_password').removeClass('red_border');
						$('#confirm_password').removeClass('red_border');
						$('#email').removeClass('red_border');

					} else {

						$('#old_password').addClass('red_border');
						$('#new_password').addClass('red_border');
						$('#confirm_password').addClass('red_border');
						$('#email').addClass('red_border');
						$('.ch_pass_msg').removeClass('green');
						$('.ch_pass_msg').addClass('red');
						$('.ch_pass_msg').html(obj.message);


					}
				}
			};

			$("#ch_pass_form").ajaxSubmit(options);
		});


		// ------------ Update Profile JS -------------- //
		$('.update_info').on('click', function(){

			$('.uinfo_msg').html('<?=$t->get('loading');?>');

			var options = {
				url: "<?=$lang_link_prefix?>/Auth_API/update_user_data/",
				success: function(obj) {
					if (obj.status == "success") {

						$('.uinfo_msg').removeClass('red');
						$('.uinfo_msg').addClass('green');
						$('.uinfo_msg').html(obj.message);

						// document.location.href='<?=$lang_link_prefix?>/auth/profile/';
						// Reload avatar?

						setTimeout(function(){
							$('.uinfo_msg').html('');
						}, 400);

					} else {
						$('.uinfo_msg').removeClass('green');
						$('.uinfo_msg').addClass('red');
						$('.uinfo_msg').html(obj.message);

					}
				}
			};
			$("#update_info_form").ajaxSubmit(options);
		});


		/* ------------- Ava Cut And Upload ---------- */
		$('#file_select').change(function(e) {
			// alert(111);
			var file = e.target.files[0];
			$.canvasResize(file, {
				width: 400,
				height: 400,
				quality: 80,
				callback: function(data, width, height) {
					$("#show_img").attr('src', data);
					$("#file_select").val('');
					$("#img_code").val(data);
					// alert(data);
				}
			});
		});

		/* Phone verification */

		$('.verify_phone').on('click', function() {
			$.confirm({
				title: 'Верификация',
				content: 'Отправить код верификации на Ваш номер?',
				buttons: {
					confirm: {
						text: 'Отправить',
						btnClass: 'btn-blue',
						action: function () {
							$.post('/Auth_API/phone_verification', {},
								function (data) {
									var info = jQuery.parseJSON(data);
									if(info.status == 'error') {
										$.alert({
											type: 'red',
											title: false,
											content: info.message,
											backgroundDismiss: true
										});
									} else if(info.status == 'success') {
										check_phone_vefification_dialog();
									}
								}
							);
						}
					},
					cancel: {
						text: 'Отмена',
						action: function () {
						}
					}
				}

			});
		});

		/* Email verification */
		$('.verify_email').on('click', function() {
			$.confirm({
				title: 'Верификация',
				content: 'Верифицировать ваш email??',
				buttons: {
					confirm: {
						text: 'Да',
						action: function () {
							$.post('/Auth_API/email_verification', {},
								function () {
									$.alert({
										type: 'green',
										title: 'Верификация',
										content:  'На ваш email отправлено письмо с инструкцией',
										backgroundDismiss: true
									});
								}
							);
						}
					},
					cancel: {
						text: 'Отмена',
						action: function () {
						}
					}
				}
			});
		});

		function check_phone_vefification_dialog() {

			$.confirm({
				title: 'Код отправлен!',
				content: '' +
				'<form action="" class="formName">' +
				'<div class="form-group">' +
				'<label>Введите код верификации</label>' +
				'<input type="text" placeholder="Ваш код" class="vefication_code form-control" required />' +
				'<div class="vefication_code_message"></div>' +
				'</div>' +
				'</form>',
				buttons: {
					formSubmit: {
						text: 'Отправить',
						btnClass: 'btn-blue',
						action: function () {
							var content_message_div = this.$content.find('.vefication_code_message');
							var code = this.$content.find('.vefication_code').val();
							console.log(code);
							if(code.length != 5){
								content_message_div.text('Введите правильный код!').css('color', 'red');
								return false;
							} else {
								$.post('/auth_api/check_phone_verification_code', {code: code},
									function (data) {
										var info = jQuery.parseJSON(data);
										if(info.status == 'error') {
											content_message_div.text(info.message).css('color', 'red');
										} else if(info.status == 'success') {
											content_message_div.text(info.message).css('color', 'green');
											setTimeout(function(){
												window.location.href = '/auth/profile';
											},1000);
										}
									}
								);
								return false;
							}
						}
					},
					cancel: {
						text: 'Отмена',
						action: function () {
							var main_confirm = this;
							$.confirm({
								title: 'Предупреждение!',
								content: 'Отправка сообщения может занять до двух минут. Вы уверены что хотите прекратить верификацию?',
								buttons: {
									confirm: {
										text: 'Прекратить',
										btnClass: 'btn-red',
										action: function () {
											main_confirm.close();
										}
									},
									cancel: {
										text: 'Продолжить',
										btnClass: 'btn-blue',
										action: function () {
											main_confirm.open();
										}
									}
								}
							});
						}
					}
				}
			});

		}

	});

</script>