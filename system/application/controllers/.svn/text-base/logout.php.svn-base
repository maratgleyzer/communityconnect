<?php

class Logout extends CV_Controller {

	var $data = array();

	function __construct () 
	{
		parent::CV_Controller();
	}

	function index (){
        $session_data = array(
            'auth' => date('d'),
            'email' => '',
            'uid' => '',
            'role' => '',
			'STUDYAREA' => ''
        );
        $this->session->set_userdata($session_data);
        $this->session->unset_userdata($session_data);
        $redirect = ($this->session->userdata('redirect'))?$this->session->userdata('redirect'):'/logon';
        $this->session->unset_userdata('redirect');
        redirect($redirect);
	}
}
?>
