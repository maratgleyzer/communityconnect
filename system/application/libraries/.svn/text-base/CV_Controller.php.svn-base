<?php
class CV_Controller extends Controller {
	function CV_Controller() {
		parent::Controller();
		$url_part = $this->uri->segment(1);
		$redirect = $this->uri->uri_string();
		$session_validate = $this->session->userdata('auth');
		if ($session_validate != date('d') && $url_part != 'logon') {
			$this->session->set_userdata('redirect', $redirect);
			redirect("/logon");
		}

	}
}
?>
