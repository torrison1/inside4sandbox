<?php

namespace Inside4\CRM;

Class CRM
{
    // Dependencies
    var $website;
    var $view;
    var $mailer;
    var $db;

    public function init() {
        return true;
    }
    public function init_from_controller($controller) {

        $this->db =& $controller->db;
        $this->view =& $controller->view;
        $this->mailer =& $controller->mailer;
        $this->website =& $controller->website;
        return true;
    }
    public function website_request($data) {

        $this->db->insert('it_requests', $data);

        // Send to Email
        $data['header'] = "Contacts Request";
        $data['content'] = "
			<b>Name &amp; Contacts:</b> ".$data['requests_user_contacts']."<br /><br />
			<b>Message:</b> ".$data['requests_message']."<br /><br />
			<b>Time:</b> ".date("Y-m-d H:i:s").
            "<br /><br /><b>Link: </b><a href=\"".$this->website->config['main']['base_url']."/inside/table/it_requests\">Requests Table</a>";
        $data['footer'] = $this->website->config['mailer']['footer'];

        $message = $this->view->render_to_var($data, 'Mail/mail_template.php');

        $subject = "Contacts Request on ".$this->website->config['main']['base_url'];
        $this->mailer->send_email($this->website->config['mailer']['admin_email'], $message, $subject);

    }
}