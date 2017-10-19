<?php

class Common_ajax extends CV_Controller {

	var $data = array();
	private $allSelection = array(
		'label' => '-- All --',
		'value' => '__all'
	);

	function __construct() {
		parent::CV_Controller();
		$this->load->model("serviceareas_model");
	}

	function valid_user() {
		$user_id = $this->session->userdata('uid');
		if ($user_id > 0) {
			echo $user_id;
		}
		else {
			echo 0;
		}
	}
	
	function echoDataAtAGlance() {
		$content = $this->common->getDataAtAGlance();
		echo json_encode($content); // array['table'=>html, 'has_data'=>bool]
	}

	// The following functions are imported in from the original developer
	// they are AJAX functions returning JSON formatted data
	public function delegate() {
		$action = $_REQUEST['action'];
		$this->$action();
	}

	public function getServiceAreas() {
		$service_areas = $this->serviceareas_model->get_service_areas();
		$results = array();
		$results[] = $this->allSelection;
		foreach ($service_areas as $sa) {
			$rowData = array();
			$rowData['label'] = $sa->AREA;
			$rowData['value'] = $sa->AREA_ID;
			$results[] = $rowData;
		}
		echo json_encode($results);
	}

	public function getSegments() {
		$sa = $_REQUEST['sa'];
		$this->load->model("block_model");
		$segments = $this->block_model->get_segments_by_sa($sa);
		$results = array();
		$results[] = $this->allSelection;
		if (is_array($segments)) {
			foreach ($segments as $s) {
				$rowData = array();
				$rowData['label'] = $rowData['value'] = $s->TAPSEGNAM;
				$results[] = $rowData;
			}
		}
		echo json_encode($results);
	}

	public function getTypes() {
		$type = $_REQUEST['type'];
		$results = array();
		$results['success'] = true;
		if ('materials' == $type) {
			$results['results'] = $this->getMaterials();
		} elseif ('items_category' == $type) {
			$results['results'] = $this->getSpecificItems();
		} elseif ('items_specific' == $type) {
			$results['results'] = $this->getSpecificItems();
		} else {
			$results['success'] = false;
		}
		echo json_encode($results);
	}

	private function getMaterials() {
		$this->load->model("material_types_model");
		$material_types = $this->material_types_model->get_material_types();
		$results = array();
		$results[] = $this->allSelection;
		foreach ($material_types as $mt) {
			$results[] = array('label' => $mt->MATERIAL, 'value' => $mt->MATERIAL_ID);
		}
		return $results;
	}

	private function getSpecificItems() {
		$this->load->model("item_types_model");
		$item_types = $this->item_types_model->get_item_types();
		$results = array();
		$results[] = $this->allSelection;
		foreach ($item_types as $it) {
			$results[] = array('label' => $it->FULL_NAME, 'value' => $it->ITEM_ID);
		}
		return $results;
	}
}
?>
