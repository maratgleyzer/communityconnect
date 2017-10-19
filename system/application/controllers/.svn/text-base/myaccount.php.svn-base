<?php

class Myaccount extends CV_Controller {
    var $data = array();
    function __construct() {
        parent::CV_Controller();
        $this->load->model('users_model');
        $this->load->library('session');
    }

    function index() {
        $data = $this->data;
        $data['pageTitle'] = "My Account";
		$data['pageClass']	= "myAccount";
        $data['study_areas'] = $this->users_model->get_study_areas();
        $user_id = $this->session->userdata('uid');
        $user_info = $this->users_model->get_user_by_ID($user_id);
        $data['user_info'] = $user_info[0];
        $this->load->view('myaccount/index', $data);
    }

    function save_preferences(){
        extract($_GET);
        $user_data = array("STUDYAREA"=>$studyarea, "RPTFORMAT"=>$rptformat, "RPTSUBTITLE"=>$rptsubtitle, "RPTUSERNAME"=>$rptusername, "LITCOMPARE"=>$litcompare);
        $user_id = $this->session->userdata('uid');
        $this->users_model->update_user($user_id, $user_data);
		$this->session->set_userdata($user_data);
        if ($act == "save")
            echo json_encode(array("Message"=>"Your preference settings have been successfully updated."));
        if ($act == "reset")
            echo json_encode(array("Message"=>"Your preference settings have been successfully restored to default values."));
    }

    function change_password(){
        $password = sha1($_GET['new_pass']);
        $current_pass = sha1($_GET['current_pass']);
        $user_id = $this->session->userdata('uid');
        $valid = $this->users_model->validate_password($user_id, $current_pass);
        if ($valid){
            $user_data = array("PASSWORD" => $password);
            $this->users_model->update_user($user_id, $user_data);
            $email = $this->session->userdata('email');
            $subject = "Confirming New Password for CommunityConnect with LiteracyDecision";
            $email_content = "<p>Thanks for visiting CommunityConnect with LiteracyDecision.</p><p>Per your request, you have successfully changed your password.</p><p>Should you need to contact us for any reason, please know that we can give out information only to the e-mail address associated with your account.</p><p>Thank you!</p>";
            $this->sendmail('support@civictechnologies.com', 'support@civictechnologies.com',$email, $subject, $email_content);
            echo json_encode(array("Message"=>"Your password has been successfully updated."));
        }else{
            echo json_encode(array("Message"=>"Your current password is not valid."));
        }
    }

    function sendmail($myemail, $myname, $toemail, $subject, $message) {
        $config = Array(
                      'protocol' => 'smtp',
                      'smtp_host' => 'ssl://smtp.gmail.com',
                      'smtp_port' => 465,
                      'smtp_user' => 'gg.portland88@gmail.com',
                      'smtp_pass' => 'huamei88',
                      'smtp_timeout' => 30);

        $config['mailtype'] = "html";
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->load->library('email',$config);
        $config['mailtype'] = "html";
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from($myemail, $myname);
        $this->email->to($toemail);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

}
?>
