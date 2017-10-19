<?php

class Literacydecision extends CV_Controller {

	var $data = array();
	private $allSelection = array(
		'label' => '-- All --',
		'value' => '__all'
	);

	function __construct() {
		parent::CV_Controller();
		$this->data['pageTitle'] = "Literacy Decision";
		$this->load->model("serviceareas_model");
		$this->data['literacy_levels'] = array(
			4	=> array('label'=>'Literacy: High Challenge','tooltip'=>'Locations of people with the lowest literacy skills'),
			3	=> array('label'=>'Literacy: Moderate/High Challenge','tooltip'=>'Locations of people with low to moderate literacy skills'),
			2	=> array('label'=>'Literacy: Low/Moderate Challenge','tooltip'=>'Locations of people with moderate to high literacy skills'),
			1	=> array('label'=>'Literacy: Low Challenge','tooltip'=>'Locations of people with the highest literacy skills')
		);
	}

	function index() {
		$data = $this->data;
//		$data['extraJS'] = array('reports');
		$data['extraJS'] = array('reports');
		$data['pageClass'] = "literacyDecision";
		$data['skip_studyarea'] = true;
		$data['currentServiceArea'] = "Whole District";
		$data['data_at_a_glance'] = $this->common->getDataAtAGlance('literacy');
		$data['service_areas'] = $this->serviceareas_model->get_service_areas_whole();
		$data['summary_text'] = 'LiteracyDecision will help the library measure literacy levels throughout the District, and has valuable information to help you design services and programs to overcome literacy problems. Information in this section measures literacy levels by service area and census block group. In the Literacy Profile tab you can measure literacy levels by geographic area. In the other tabs (Demographic Profile, Library Use Profile, and Employment Profile), you can obtain detailed data for use in designing literacy supporting services and programs.';
		$this->load->view('literacydecision/index', $data);
	}

	function ajax_summary() {
		$literacy_levels = $this->data['literacy_levels'];
		$this->load->model('block_model');
		$sa = $this->input->post('sa');
		$levels = $this->input->post('levels');
		$rows = $this->block_model->getBlockLiteracy(array($sa), $levels);
		if (!$rows) {
			$return->error = '<div class="instructions">No data to display</div>';
		}
		else {
			$prows = $this->block_model->getAllBlockPatrons(array($sa));
			$thead = '<table class="pivot tableSorter"><thead><tr class="header"><th>Literacy Level</th><th>Literacy Score</th><th>Blockgroup</th><th>Service Area</th> <th>Segment</th><th>Population</th><th>Patrons</th><th>New Market</th></tr></thead>';
			$tbody = '<tbody>';
			$patron_arr = array();
			$new_market_arr = array();
			if ($rows) {
				foreach ($rows as $r) {
					$patrons = 0;
					$new_market = 0;
					$litscore = round(100 * $r->LITSCORE, 3);
					if ($r->BLOCK_ID != 'Not Available') {
						$data_array[$r->BLOCK_ID]['Literacy Score'] = $litscore;
						$data_array[$r->BLOCK_ID]['Literacy Level'] = $literacy_levels[$r->LITLEVEL]['label'];
						$data_array[$r->BLOCK_ID]['Population'] = $r->TOTPOP_CY;
						$table_array[$r->BLOCK_ID]['Literacy Score'] = $litscore;
						$table_array[$r->BLOCK_ID]['Literacy Level'] = $literacy_levels[$r->LITLEVEL]['label'];
						$table_array[$r->BLOCK_ID]['Service Area'] = $r->AREA;
						$table_array[$r->BLOCK_ID]['Segment'] = $r->TAPSEGNAM;
						$table_array[$r->BLOCK_ID]['Population'] = $r->TOTPOP_CY;
						if ($prows) {
							foreach ($prows as $p) {
								if ($p->BLOCK_ID == $r->BLOCK_ID) {
									$patrons = $p->patrons;
									$non_patrons = $r->TOTPOP_CY - $patrons;
									$market_potential = $non_patrons / $r->TOTPOP_CY;
									$data_array[$r->BLOCK_ID]['Patrons'] = $patrons;
									$data_array[$r->BLOCK_ID]['Market Potential'] = $market_potential;
									$table_array[$r->BLOCK_ID]['Patrons'] = $patrons;
								}
							}
						}
						$table_array[$r->BLOCK_ID]['Patron Potential'] = ($r->TOTPOP_CY * $market_potential) + 1;
						$table_array[$r->BLOCK_ID]['Checkouts'] = '';
						$table_array[$r->BLOCK_ID]['Checkout Potential'] = '';
						$table_array[$r->BLOCK_ID]['Use Rate'] = '';
						$table_array[$r->BLOCK_ID]['Average Checkouts'] = '';
					} else {
						$patrons = 0;
						$new_market = 0;
						$table_array[$r->BLOCK_ID]['Patrons'] = $patrons;
						$table_array[$r->BLOCK_ID]['New Market'] = $new_market;
					}
					array_push($patron_arr, $patrons);
					array_push($new_market_arr, $new_market);
					$tbody .= "<td class='text-right'>" . $litscore . "</td>";
					$tbody .= "<tr><td>" . $literacy_levels[$r->LITLEVEL]['label'] . "</td>";
					$tbody .= "<td>" . $r->BLOCK_ID . "</td>";
					$tbody .= "<td>" . $r->AREA . "</td>";
					$tbody .= "<td>" . $r->TAPSEGNAM . "</td>";
					$tbody .= "<td class='text-right'>" . $r->TOTPOP_CY . "</td>";
					$tbody .= "<td class='text-right'>" . $patrons . "</td>";
					$tbody .= "<td class='text-right'>" . $new_market . "</td></tr>";
				}
			}
			$tbody .= '</tbody>';
			$chart_data = $this->common->FIND_LITERACY_generate_FC_MSColumn2D_chart_json($rows, $patron_arr, $new_market_arr);
			$return->chart = $chart_data;
			$return->table = $this->common->convert_data_to_common_structure($table_array, 'Block Group No.', false);
			$return->map = $this->common->convert_data_to_common_structure($table_array, 'Block Group No.', false);
		}
		echo json_encode($return);
	}

}

?>
