<?php

class Home extends CV_Controller {

	var $data = array();

	function __construct()
	{
		parent::CV_Controller();	
	}
	
	function index()
	{
		$data = $this->data;
		$data['pageTitle'] = "Home";
		$data['pageClass'] = "homePage";

		$this->load->model("serviceareas_model");
		$this->load->model("block_model");
		$data['service_areas'] = $this->common->get_service_areas();
		$data['segments'] = $this->block_model->get_segments();
       	$data['areas_json'] = $this->common->get_service_areas_json();
       	$data['segments_json'] = $this->common->get_segments_json();
		$fetch_distinct = true;
		$include_all = false;
       	$data['distinct_segments_json'] = $this->common->get_segments_json($fetch_distinct, $include_all);

		$this->load->view('home/index', $data);
	}
	function about() {
		$data = $this->data;
		$data['pageTitle'] = "About";

		$this->load->view('home/about', $data);
	}
	function support() {
		$data = $this->data;
		$data['pageTitle'] = "Support";

		$this->load->view('home/support', $data);
	}

	function feedback() {
		$data = $this->data;
		$data['pageTitle'] = "Feedback";
		$this->load->view('home/feedback', $data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
