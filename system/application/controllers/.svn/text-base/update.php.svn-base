<?php

class Update extends CV_Controller {

	function __construct()
	{
		parent::CV_Controller();
		ini_set('set_time_limit', 600000);
		ini_set('max_execution_time', 600000); // 600K seconds.
		ini_set('default_socket_timeout', 600000); // 600K seconds.
	}
	
	public function index()
	{
		echo "ACCESS DENIED - please select a function to execute";
	}

	public function rank_tables()
	{
		$this->load->model("rank_checkout_model");
		$this->load->model("rank_patron_model");
		$this->load->model("rank_population_model");
		$this->load->model("rank_market_share_model");
		$this->load->model("rank_potential_model");

		$this->rank_checkout_model->dataUpdate();
		$this->rank_patron_model->dataUpdate();
		$this->rank_population_model->dataUpdate();
		$this->rank_market_share_model->dataUpdate();
		$this->rank_potential_model->dataUpdate();

		echo "RANK TABLE UPDATE COMPLETE";
	}
	
	public function checkout_sum()
	{
		$this->load->model("checkout_sum_model");
		$this->checkout_sum_model->dataUpdate();

		echo "CHECKOUT_SUM TABLE UPDATE COMPLETE";
	}
	
	public function block_sum()
	{
		$this->load->model("block_sum_model");
		$this->block_sum_model->dataUpdate();

		echo "BLOCK_SUM TABLE UPDATE COMPLETE";
	}

}