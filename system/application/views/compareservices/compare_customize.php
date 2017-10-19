<?php $subtab = array("subtab" => "compare"); ?>
<script type="text/javascript">
	function toggleDisplay (c,k) {

		var e = document.getElementById(c);
	
		//if (e.style.display == 'none')
		//	e.style.display = 'block';
	
		for (var i = 0; i < document.forms[1].CustomizeData.length; ++i) {
			document.forms[1].CustomizeData[i].checked = false;
			var v = document.forms[1].CustomizeData[i].value;
			//if (e = document.getElementById(v))
			//	e.style.display = 'none';
			//if (c != 'CustomizeData_'+i)
			//	if (e = document.getElementById('CustomizeData_'+i))
			//		e.style.display = 'none';
		}
	
		document.forms[1].CustomizeData[k].checked = true;
		var toggleOption = document.getElementById('toggle_analysis_way');
		if (k == 0) toggleOption.innerHTML = 'By Statistic';
		if (k == 1) toggleOption.innerHTML = 'By Segment';
	
	}
	function checkUrban (s) {
		<?php 
			foreach ($service_areas as $sa) { 
				if ($sa->TYPE == 'urban') {
					$urban[] = $sa;
				}
			} ?>
		var urban_areas = <?php echo json_encode($urban); ?>;
		if (s == true)
			for (var i = 0; i < document.forms[1].cd_area.length; ++i) {
				for (var j = 0; j < urban_areas.length; j++) {
					if (urban_areas[j].TYPE == 'urban' && urban_areas[j].AREA_ID == document.forms[1].cd_area[i].value) {
						document.forms[1].cd_area[i].checked = true;
					}
				}
			}
		if (s == false)
			for (var i = 0; i < document.forms[1].cd_area.length; ++i) {
				for (var j = 0; j < urban_areas.length; j++) {
					if (urban_areas[j].TYPE == 'urban' && urban_areas[j].AREA_ID == document.forms[1].cd_area[i].value) {
						document.forms[1].cd_area[i].checked = false;
					}
				}
			}
	}
	function checkRural (s) {
		<?php 
			foreach ($service_areas as $sa) { 
				if ($sa->TYPE == 'rural') {
					$urban[] = $sa;
				}
			} ?>
		var rural_areas = <?php echo json_encode($urban); ?>;
		if (s == true)
			for (var i = 0; i < document.forms[1].cd_area.length; ++i) {
				for (var j = 0; j < rural_areas.length; j++) {
					if (rural_areas[j].TYPE == 'rural' && rural_areas[j].AREA_ID == document.forms[1].cd_area[i].value) {
						document.forms[1].cd_area[i].checked = true;
					}
				}
			}
		if (s == false)
			for (var i = 0; i < document.forms[1].cd_area.length; ++i) {
				for (var j = 0; j < rural_areas.length; j++) {
					if (rural_areas[j].TYPE == 'rural' && rural_areas[j].AREA_ID == document.forms[1].cd_area[i].value) {
						document.forms[1].cd_area[i].checked = false;
					}
				}
			}
	}

	function checkAll (s) {

		if (s == true)
			for (var i = 0; i < document.forms[1].cd_area.length; ++i)
				document.forms[1].cd_area[i].checked = true;

		if (s == false)
			for (var i = 0; i < document.forms[1].cd_area.length; ++i)
				document.forms[1].cd_area[i].checked = false;

	}
</script>
<form name="compare_customize_form" id="compare_customize_form">
	<div class="col_left" style="width: 420px;">
		<div style="width: 220px; float: left; margin-right: 10px;">
			<div class="instructions">Select a way to analyze the data:</div>
			<div id="DataOptionDiv">
				<div class="imageToggle" style="margin:4px;text-align:right;">
					<input style="margin:0;padding;0;border:0;" name="all_data_number_type" type="image" value="number" class="selected" src="graphics/number_button.png"><input style="margin:0;padding;0;border:0;" name="all_data_number_type" type="image" value="percent" src="graphics/percent_button.png">
				</div>
				<ul class="DataOptionCollection">
					<li onclick="toggleDisplay('CustomizeData_1','0');" class="DataOptionSection"><input type="radio" name="CustomizeData[]" id="CustomizeData" value="summary_profile"> <span>Summary Profile</span> <div class="tip" title=""></div></li>
					<li>
						<ul id="CustomizeData_1" style="padding-left:4px;">
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_median_population"> <span>Median Population</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_median_patrons"> <span>Median Patrons</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_population"> <span>Population</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_patrons"> <span>Patrons</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_median_patron_potential"> <span>Median Patron Potential</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_patron_potential"> <span>Patron Potential</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_median_checkout_potential"> <span>Median Checkout Potential</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_checkout_potential"> <span>Checkout Potential</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_median_use_rate"> <span>Median Use Rate</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_use_rate"> <span>Use Rate</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_median_checkouts"> <span>Median Checkouts</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_checkouts"> <span>Checkouts</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_average_patron_checkouts"> <span>Average Patron Checkouts</span></li>
							<li><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_median_market_share_rate"> <span>Median Market Share Rate</span></li>
							<li class="LastOptionItem"><input type="checkbox" name="DataItem[]" id="DataItem" value="summary_market_share_rate"> <span>Market Share Rate</span></li>
						</ul>
					</li>
					<li onclick="toggleDisplay('CustomizeData_2','1');" class="DataOptionSection" style="margin-top: 8px;"><input type="radio" name="CustomizeData[]" id="CustomizeData" value="segment_profile"> <span>Segment Profile</span> <div class="tip" title=""></div></li>
					<li>
						<ul id="CustomizeData_2" style="padding-left:4px;">
							<li><input type="radio" name="DataItem[]" id="DataItem" value="segment_highest_name"> <span>Highest Segment (by name)</span></li>
							<li><input type="radio" name="DataItem[]" id="DataItem" value="segment_population"> <span>Population</span></li>
							<li><input type="radio" name="DataItem[]" id="DataItem" value="segment_patrons"> <span>Patrons</span></li>
							<li><input type="radio" name="DataItem[]" id="DataItem" value="segment_median_market_share_rate"> <span>Median Market Share Rate</span></li>
							<li><input type="radio" name="DataItem[]" id="DataItem" value="segment_median_patron_potential"> <span>Median Patron Potential</span></li>
							<li><input type="radio" name="DataItem[]" id="DataItem" value="segment_average_patron_checkouts"> <span>Average Patron Checkouts</span></li>
							<li class="LastOptionItem"><input type="radio" name="DataItem[]" id="DataItem" value="segment_use_rate"> <span>Use Rate</span></li>
						</ul>
					</li>
					<!--
					<li onclick="toggleDisplay('CustomizeData_3','2');" class="DataOptionSection"><input type="radio" name="CustomizeData[]" id="CustomizeData" value="literacy_profile"> <span>Literacy Profile</span></li>
					<li><ul id="CustomizeData_3" style="display:none;padding-left:4px;padding-top:5px;">
        	       	</ul>
					</li>
					-->
				</ul>
			</div>
		</div>
		<div style="float: left;">
			<div class="instructions">Select services areas:</div>
			<div id="ServiceAreaDiv">
				<ul id="service-area-list">
					<?php echo $this->service_area_checkboxes; ?>
				</ul>
			</div>
		</div>
		<div class="col_left datecolumn" style="text-align: right;">
			<div id="chart_sort" style="display:none; float:left;margin:5px 0 0 10px;">
		Sort by:
				<select name="chart_sort">
					<option value="">Choose sort method</option>
					<!--
		<option value="high_to_low">High to low</option>
		<option value="low_to_high">Low to high</option>
		-->
					<option value="a_to_z">A to Z</option>
					<option value="z_to_a">Z to A</option>
				</select>
			</div>
			<?php //$this->load->view('includes/checkouts.php', $subtab);?>   
			<div style="padding-left:225px">
			<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" id="report_button" onclick="SaveCustomizeReport();">
			<input type="image" src="/graphics/show_data_button.png" name="generic_refresh" id="refresh_button" value="compare_customize_form" style="cursor:pointer">
			</div>
		</div>
	</div>

	<div class="col_right" style="overflow: hidden; width: 200px;">
		<div class="controls" style="display:none;">
			<div style="float:left;width:130px">
				<span class="biggify">[ + ]</span>
				<div class="displaytype normal toggleSelect selected">Table</div>
				<div class="displaytype inverted toggleSelect">Chart</div>
			</div>
			<div style="float:right;width:230px">
				<span class="pivottype">Toggle View:</span>
				<div id="toggle_analysis_way" class="toggle_analysis_way pivottype inverted toggleSelect">By Statistic</div>
				<div id="toggle_analysis_area" class="toggle_analysis_area pivottype normal toggleSelect selected">By Area</div>
			</div>
		</div>
		<br style="clear:both;" />
		<div id="customize_chartcolumn" style="margin-top:6px;overflow:auto;">
			<div class="table" id="table" style="width:100%;"></div>
			<div id="the_chart" class="chart offscreen" align="center" style="height:100%;">The chart will appear within this DIV. This text will be replaced by the chart.</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	function SaveCustomizeReport() {
        var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");

		ReportInfo.Init(ReportType.CompareServiceAreas, "Customize", $('#serviceArea :selected').text(), '');
		ReportInfo.AddReportItem(ReportItemType.Html, $(current_subtab + " .table").html(), '');

		ExportChart("ccf_chart");
	}
</script>
