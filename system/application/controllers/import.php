<?php

class Import extends CV_Controller {

	var $data = array();
	var $opendir = '../web/imports/';
	var $movedir = '../web/imports/processed/';
	var $opts = array('patrons', 'checkouts', 'demographics','blocks');
	var $field_maps = array(
		'patrons' => array(
			'PATID' => 'PATRON_ID',
			'ADDRESS' => 'ADDRESS',
			'CITY' => 'CITY',
			'STATE' => 'STATE',
			'ZIP_CODE' => 'ZIP_CODE',
			'MAT_LAT' => 'LATITUDE',
			'MAT_LON' => 'LONGITUDE',
			'EXP_DATE' => 'EXPIRE_DATE',
			'HISTCKO' => 'HISTCKO',
			"SQMI" => "SQMI",
			'FIPS' => 'BLOCK_ID'
		),
		'checkouts' => array(
			'PATRON#' => 'PATRON_ID',
			'OUT_DATE' => 'CHECKOUT_TIME',
			'MAT_TYPE' => 'MATERIAL_ID',
			'I_TYPE' => 'ITEM_ID'
		),
		'demographics' => null, // not used
		'blocks'	=> array(
			'FIPS'			=> 'BLOCK_ID',
			'HISTCKO'		=> 'HISTCKO',
			'TCKO_SMPLPERD'	=> 'TCKO_SMPLPERD',
			'DOMTAP'		=> 'DOMTAP'
		)
	);

	function __construct() {
		parent::CV_Controller();
	}

	function index($type = null) {
		header("Content-type: text/html");
		set_time_limit(0);
		echo '<h1>Import Functions</h1>';
			echo '<ul>';
			foreach ($this->opts as $opt) {
				echo '<li><a href="/import/' . $opt . '">' . ucfirst($opt) . '</a></li>';
			}
			echo '</ul>';
		if ($type == null) {
			echo '<p>Select from the options above.</p>';
		}
		else {
			if (in_array($type, $this->opts)) {
				$map = $this->field_maps[$type];
				$this->load->model('import_model');
				$this->load->model('block_model');
				echo '<h2>Import ' . ucfirst($type) . ' Data</h2>';
				$files = array();
				$dir = $this->opendir . $type . '/';
				if ($handle = opendir($dir)) {
					echo "<h3>" . ucfirst($type) . " files to process:</h3>";
					while (false !== ($file = readdir($handle))) {
						if (!is_dir($dir . $file) && $file != '..' && !preg_match('/\.svn/', $file)) {
							$files[] = $file;
						}
					}
					closedir($handle);
				}
				if (count($files) >= 1) {
					echo '<ul>';
					foreach ($files as $f) {
						echo '<li>' . $f . '</li>';
					}
					echo '</ul>';
					if ($this->input->post('process') == 'yes') {
						ini_set('set_time_limit', 600000);
						ini_set('max_execution_time', 600000); // 600K seconds.
						ini_set('default_socket_timeout', 600000); // 600K seconds.
						echo "<p>Processing " . count($files) . " file";
						echo (count($files) > 1) ? 's <br />' : '<br />';
						$inserted = 0;
						foreach ($files as $file) {
							echo "<h4><em> $file</em></h4>";
							$first = true;
							$indices = array();
							$i = 0;
							$print = array('Inserted' => 0, 'Duplicates' => 0, 'Failed' => 0, 'Malformed' => 0, 'No Block ID' => 0, 'Updated' => 0);
							$f = fopen ($dir . $file, "r");
							while ($row = fgets($f)) {
								++$i;
								$insert = array(); 
								$split = array();
								$tmp = array();
								$split = explode("\t", $row);
								if (count($split) == 1) {
									continue; // empty row
								}
								if ($first == true) { // header row. collect our indices!
									$indices = $this->generate_index($split, $map);
									$first = false;
								}
								else { // process each entry
									if (count($split) < count($indices)) {
										$print['Malformed']++;
										continue; // in case of malformed rows
									}
									$insert = array();
									if ($type == 'checkouts') {
										$patron_id = str_replace('"', '', $split[0]);
										$block_id = $this->block_model->get_block_id_by_patron_id($patron_id);
										if ($block_id == false) { // we can't insert the row with contraints
											$print['No Block ID']++;
											continue;
										}
										else {
											$insert['BLOCK_ID'] = $block_id;
										}
									}
									foreach ($indices as $index => $field_name) {
										$value = preg_replace('/[\n\r"\']/', '', $split[$index]);
										if ($type == 'checkouts') {
											if ($field_name == 'CHECKOUT_TIME') {
												$tmp = explode(' ', $value);
												$time = $tmp[1];
												$tmp2 = $tmp[0]; // remove latter half
												$tmp3 = explode('/', $tmp2);
												$value = $tmp3[2] . '-' . $tmp3[0] . '-' . $tmp3[1] . ' ' . $time;
											}
											if ($field_name == 'ITEM_ID') { // PAD WITH 0 TO ADHERE TO CONSTRAINT?
												$value = substr('000' . $value, -3);
											}
										}
										if ($type == 'patrons') {
											if ($field_name == 'EXPIRE_DATE') {
												$tmp = explode(' ', $value);
												$tmp2 = $tmp[0]; // remove latter half
												$tmp3 = explode('/', $tmp2);
												if (count($tmp3) > 1) {
													$value = $tmp3[2] . '-' . substr('0' . $tmp3[0], -2) . '-' . substr('0' . $tmp3[1], -2);
												}
												else {
													$value = '0000-00-00';
												}
											}
											elseif ($field_name == 'BLOCK_ID') {
												$area_id = $this->block_model->get_area_id_by_block_id($value);
												if ($area_id != null) {
													$insert['AREA_ID'] = $area_id;
												}
											}
										}
										$insert[$field_name] = $value;
									}
									$test = false;
									if ($type == 'checkouts') {
										$test = $this->import_model->add_checkout($insert);
									}
									elseif ($type == 'patrons') {
										$test = $this->import_model->add_patron($insert);
									}
									elseif ($type == 'demographics') {
										$test = $this->import_model->add_demographic($insert);
									}
									elseif ($type == 'blocks') {
										$block_id = $insert['BLOCK_ID'];
										$test = $this->import_model->update_block($block_id, $insert);
									}
									if ($test == 'duplicate') {
										$print['Duplicates']++;
									}
									elseif ($test == false) {
										$print['Failed']++;
									}
									elseif ($test == 'updated') {
										++$inserted;
										$print['Updated']++;
									}
									else { // success
										++$inserted;
										$print['Inserted']++;
									}
								}
							}
							fclose($f);
							echo "<br />...done.";
							foreach ($print as $p => $v) {
								echo "<br />$p: $v";
							}
							echo "<br />Archiving <em> $file</em>... ";
							echo $this->archive_file($dir, $file, $type);
						}
						print '<br />Inserted or Updated ' . $inserted . ' Rows</p>';
					}
					else {
						echo '<p><form action="/import/' . $type . '" name="' . $type . '" method="post"><input type="checkbox" name="process" value="yes" /> Process? <input type="submit" value="Submit" /></form></p>';
					}
				}
				else {
					echo "None";
				}
			}
			else {
				echo '<h3>There is no matching import function for <em>' . $type . '</em></h3>';
			}
		}
	}
	
	private function generate_index($split, $map = null) {
		$x = 0;
		$indices = array();
		foreach ($split as $field) {
			$field = preg_replace('/[^a-z_#\s]+/i', '', $field);
			if ($map == null) { // demographics, where header row == field name.
				$indices[$x] = false;
				if ($this->import_model->lookup_field($field) == true) {
					$indices[$x] = $this->import_model->lookup_field($field);
				}
			}
			elseif (isset($map[$field])) {
				$indices[$x] = $map[$field];
			}
			++$x;
		}
		return $indices;
	}

	private function archive_file($dir, $file, $type) {
		$filename = $type . '_' . $file . '_' . date('Y-m-d');
		$i = 1;
		$newfilename = $filename;
		while (is_file($dir . $newfilename)) {
			++$i;
			$newfilename = $filename . '_' . $i;
		}
		if (copy($dir . $file, $this->movedir . $newfilename)) {
			if (unlink($dir . $file)) {
				return 'Archived file'; // success
			}
			else {
				return 'File copied but original remains';
			}
		}
		return 'Failed to archive file';
	}
}