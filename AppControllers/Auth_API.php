<?php
namespace AppControllers;
use Inside4\CommonCore\BaseController as BaseController;

Class Auth_API extends BaseController {

    //i--- Auth API : Check Login /Auth_API/check_login (<a href='https://inside4sandbox.ikiev.biz/Auth_API/check_login?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 1 ---/
    public function check_login(){

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {
            $params = [
                'data' => [
                    'email' => array('type'=>'text', 'value'=>''),
                    'password' => array('type'=>'text', 'value'=>''),
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post', $params);
        }
        // https://inside4sandbox.ikiev.biz/Auth_API/check_login?test_form=1

        $email = $this->security->xss_cleaner($_POST['email']);
        $password = $this->security->xss_cleaner($_POST['password']);
        $res = Array();

        if ( ( $email == "" ) AND ( $password == "" ) )
        {
            $res['status'] = 'error';
            $res['message'] = 'Email, Пароль не может быть пустым! / Email, password cannot be empty!';
        }
        elseif ( $email == "" )
        {
            $res['status'] = 'error';
            $res['message'] = 'Email не может быть пустым! / Email cannot be empty!';
        }
        elseif ( $password == "" )
        {
            $res['status'] = 'error';
            $res['message'] = 'Пароль не может быть пустым! / Password cannot be empty!';
        }
        else
        {
            $email = strtolower($email);
            $id = $this->auth->login($email, $password);

            if ($id)
            {
                $res['status'] = 'success';
                $res['redirect'] = $this->data['lang_link_prefix'].'/auth/profile';
            }
            else
            {
                $res['status'] = 'error';
                $res['message'] = 'Неверный E-mail или Пароль! / Wrong email or password';
            }
        }
        $this->response->echo_json($res);
    }

    //i--- Auth API : Check Registration /Auth_API/check_reg (<a href='https://inside4sandbox.ikiev.biz/Auth_API/check_reg?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 2 ---/
    public function check_reg(){

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {
            $params = [
                'data' => [
                    'email' => array('type'=>'text', 'value'=>''),
                    'password' => array('type'=>'text', 'value'=>''),
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post', $params);
        }
        // https://inside4sandbox.ikiev.biz/Auth_API/check_reg?test_form=1

        $email = $this->security->xss_cleaner($_POST['email']);
        $password = $this->security->xss_cleaner($_POST['password']);
        $email = strtolower($email);

        $res = Array();

        if ( ( $email == "" ) AND ( $password == "" ) )
        {
            $res['status'] = 'error';
            $res['message'] = 'Email, Пароль не может быть пустым! / Email, password cannot be empty!';
        }
        elseif ( $email == "" )
        {
            $res['status'] = 'error';
            $res['message'] = 'Email не может быть пустым! / Email cannot be empty!';
        }
        elseif ( $password == "" )
        {
            $res['status'] = 'error';
            $res['message'] = 'Пароль не может быть пустым! / Password cannot be empty!';
        }
        else
        {
            if ($this->auth->email_check($email)) {
                $res['status'] = 'error';
                $res['message'] = 'Этот Email уже зарегистрирован, попробуйте другой!';
            }
            else {

                $data = Array();
                if ($this->auth->register($email, $password, $data)) {
                    $this->auth->login($email, $password);

                    // $this->mailer->send_reg_email($email);

                    $res['status'] = 'success';
                    $res['redirect'] = '/auth/profile?reg=1';
                } else {
                    $res['status'] = 'error';
                    $res['message'] = 'Register Error!';
                };


            }

        }
        $this->response->echo_json($res);
    }

    //i--- Auth API : Password Recovery /Auth_API/check_recovery (<a href='https://inside4sandbox.ikiev.biz/Auth_API/check_recovery?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 3 ---/
    public function check_recovery() {

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {
            $params = [
                'data' => [
                    'recovery_email' => array('type'=>'text', 'value'=>'')
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post', $params);
        }
        // https://inside4sandbox.ikiev.biz/Auth_API/check_recovery?test_form=1

        $email = $this->security->xss_cleaner($_POST['recovery_email']);

        if ($email  == "" ) {
            $res['status'] = 'error';
            $res['message'] = 'Email не может быть пустым! / Email cannot be empty!';
        }
        else {
            if (!$this->auth->email_check($email)) {
                $res['status'] = 'error';
                $res['message'] = 'Данный e-mail не найден! / This Email is not in the system !';
            }
            else {
                if ($this->auth->password_recovery($email)) {
                    $res['status'] = 'success';
                    $res['message'] = '<span style="color:green;">Информация отправлена на вашу почту.</span>';
                } else {
                    $res['status'] = 'error';
                    $res['message'] = 'Ошибка восстановления пароля!';
                }
            }
        }
        $this->response->echo_json($res);
    }

    //i--- Auth API : Change Password /Auth_API/change_password (<a href='https://inside4sandbox.ikiev.biz/Auth_API/change_password?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 4 ---/
    public function change_password() {

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {
            $params = [
                'data' => [
                    'old_password' => array('type'=>'text', 'value'=>''),
                    'new_password' => array('type'=>'text', 'value'=>''),
                    'confirm_password' => array('type'=>'text', 'value'=>''),
                    'email' => array('type'=>'text', 'value'=>''),
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post', $params);
        }
        // https://inside4sandbox.ikiev.biz/Auth_API/change_password?test_form=1

        if (!isset($this->auth->user['id']) OR $this->auth->user['id'] == 0) $this->website->redirect_refresh_message('/',"Try Change Password for Zero User");

        // CSRF easy security
        $this->security->check_csfr_token($this->auth->user['id']);

        $old_password = $this->security->xss_cleaner($_POST['old_password']);
        $new_password = $this->security->xss_cleaner($_POST['new_password']);
        $confirm_password = $this->security->xss_cleaner($_POST['confirm_password']);

        if ($old_password == '') {
            $res['status'] = 'error';
            $res['message'] = '<strong>Старый пароль</strong> не может быть пустым!';
        }
        elseif ( ($new_password != $confirm_password) || ($new_password == '') || (strlen($new_password) < 5)) {
            $res['status'] = 'error';
            $res['message'] = '<strong>Новый пароль и подтверждение</strong> не совпадают или пустые или короткие (менее 5 символов)!';
        }
        else {

            if ($this->auth->change_password($old_password, $new_password)) {
                $res['status'] = 'success';
                $res['message'] = '<strong>Пароль изменен!</strong>';
            } else {
                $res['status'] = 'error';
                $res['message'] = '<strong>Старый пароль</strong> не верный!';
            }
        }
        $this->response->echo_json($res);

    }

    //i--- Auth API : Update User Data /Auth_API/update_user_data (<a href='https://inside4sandbox.ikiev.biz/Auth_API/update_user_data?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 5 ---/
    public function update_user_data() {

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {

            $email = ''; if (isset($this->auth->user['email'])) $email = $this->auth->user['email'];
            $phone = ''; if (isset($this->auth->user['phone'])) $phone = $this->auth->user['phone'];
            $name = ''; if (isset($this->auth->user['name'])) $name = $this->auth->user['name'];

            $params = [
                'data' => [
                    'email' => array('type'=>'text', 'value'=> $email),
                    'phone' => array('type'=>'text', 'value'=> $phone),
                    'name' => array('type'=>'text', 'value'=> $name),
                ],
            ];
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post', $params);
        }
        // https://inside4sandbox.ikiev.biz/Auth_API/update_user_data?test_form=1

        if (!isset($this->auth->user['id']) OR $this->auth->user['id'] == 0) $this->website->redirect_refresh_message('/',"Try Update Profile for Zero User");

        // CSRF easy security
        $this->security->check_csfr_token($this->auth->user['id']);

        $result = Array();
        $result['message'] = '';

        // Email / Phone Updates

        $phone = $this->security->xss_cleaner($_POST['phone']);
        $email = $this->security->xss_cleaner($_POST['email']);
        $email = strtolower($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) OR ($this->auth->email_check($email) AND $email != $this->auth->user['email'])) {
            $result['status'] = 'error';
            $result['message'] .= $this->t->get('email_not_valid').'<br>';
        }
        elseif ($email != $this->auth->user['email']) {

            // $this->ion_auth->update($user->id, array('email' => $email));
            // $this->ion_auth->update($user->id, array('is_verified_email' => 0));
            $update_arr['email'] = $email;

        }

        if (!preg_match('/^[0-9\-\+]{9,15}$/', $phone) )
        {
            $result['status'] = 'error';
            $result['message'] .= $this->t->get('phone_not_valid').'<br>';
        } elseif ($phone != $this->auth->user['phone']) {

            // $this->ion_auth->update($user->id, array('is_verified_phone' => 0));
            $update_arr['phone'] = $phone;

        }



        $update_arr['username'] = $this->security->xss_cleaner($_POST['name']);

        // $update_arr['company'] = $this->security->xss_cleaner($_POST['cname']);
        // $update_arr['adv_info'] = $this->security->xss_cleaner($_POST['advanced_info']);
        // $update_arr['social_fb'] = $this->security->xss_cleaner($_POST['social_fb']);

        // photo base64
        if (isset($_POST['img_code'])) { if ($_POST['img_code'] != '') {

            // unlink($_SERVER["DOCUMENT_ROOT"]."/files/uploads/users_img/".$user->img);
            $time = time();
            $path = "/Uploads/Users/Avatars/".$this->auth->user['id']."_".$time."_img.jpg";
            $ifp = fopen($_SERVER["DOCUMENT_ROOT"].$path, "wb");

            $save_data = explode(',', $this->security->xss_cleaner($_POST['img_code']));
            $img_save = $save_data[0];
            if (isset($save_data[1])) $img_save = $save_data[1];
            $decode_img = base64_decode($img_save);
            fwrite($ifp, $decode_img);
            fclose($ifp);

            $update_arr['img'] = $path;
        }}

        // delete
        if (isset($_POST['del_image'])) {
            $update_arr['img'] = '';
            // $this->inside_lib->c7_delete_image($this->input->post('del_image', TRUE), "users_img/");
        }

        // update db
        $this->auth->update_user_data($update_arr, $this->auth->user['id']);

        if (!isset($result['status']) OR $result['status'] != 'error') {
            $result['status'] = "success";
            $result['message'] = $this->t->get('data_saved');
        }

        $this->response->echo_json($result);

    }

    //i--- Auth API : Email Verification /Auth_API/email_verification (<a href='https://inside4sandbox.ikiev.biz/Auth_API/email_verification?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 6 ---/
    public function email_verification() {

        if (!isset($this->auth->user['id']) OR $this->auth->user['id'] == 0) $this->website->redirect_refresh_message('/',"Try Verify Email for Zero User");

        if ($this->auth->send_email_verification_code($this->auth->user)){
            $result['status'] = "success";
            $result['message'] = 'Code sent!';
        }
        $this->response->echo_json($result);
    }

    //i--- >> TO DO >> Auth API : Phone Verification /Auth_API/phone_verification (<a href='https://inside4sandbox.ikiev.biz/Auth_API/phone_verification?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 7 ---/
    public function phone_verification() {

    }

    //i--- Auth API : Get User Data /Auth_API/user_row_json (<a href='https://inside4sandbox.ikiev.biz/Auth_API/user_row_json?test_form=1'>Test Form</a>) ; inside_auth ; torrison ; 01.08.2018 ; 7 ---/
    public function user_row_json() {

        // ==========================  Test form  ==========================
        if (isset($_GET['test_form'])) {
            $api_test_form = new \Inside4\APITools\APITestForms;
            $api_test_form->demo_form_api_test(__FUNCTION__, __CLASS__,  'post');
        }
        // https://inside4sandbox.ikiev.biz/Auth_API/user_row_json?test_form=1

        header('Content-Type: application/json');

        if ($this->auth->user) {

            if (isset($_GET['user_id'])) $user_id = intval($_GET['user_id']);
            else {
                $user_id = $this->auth->user['id'];
            }

            $result = $this->auth->get_user_row($user_id, $this->auth->user);

            $result['is_admin'] = 0;
            if ($this->auth->in_groups(Array('admin_demo', 'admin')))$result['is_admin'] = 1;

            $result['csfr_token'] = $this->security->make_csfr_token($user_id);

            $this->response->echo_json($result);
        } else {
            $result['id'] = 0;
            $this->response->echo_json($result);
        }

    }

    public function get_user_app_texts() {
        $res = Array();
        $lang = 'en';
        foreach ($this->t->get_all_vocabulary_arr($lang) as $row) {
            $res[$lang][$row['vocabulary_alias']] = $row['vocabulary_name'];
        }
        $lang = 'ru';
        foreach ($this->t->get_all_vocabulary_arr($lang) as $row) {
            $res[$lang][$row['vocabulary_alias']] = $row['vocabulary_name'];
        }
        $lang = 'ua';
        foreach ($this->t->get_all_vocabulary_arr($lang) as $row) {
            $res[$lang][$row['vocabulary_alias']] = $row['vocabulary_name'];
        }

        $this->response->echo_json($res);
    }
}