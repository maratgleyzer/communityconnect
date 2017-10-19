<form name="literacy" id="literacy_summary_form">
	<div class="col_left" id="service_area_select">
		<div class="instructions">
		Select Service Areas
			<a href="/support" style="float: right;" target="_blank">Learn More</a>
		</div>

		<div id="selectList" style="height:245px;">
			<ul id="service-area-list">
				<?php
				if ($service_areas) {
					$excludes = $this->config->item('excluded_service_areas');
					$i = 0;
					foreach ($service_areas as $sa) {
						if (in_array($sa->AREA_ID, $excludes))
							continue;
						echo '<li><label for="input_' . $sa->AREA_ID . '"><input type="radio" id="input_' . $sa->AREA_ID . '" name="areas" value="' . $sa->AREA_ID . '" > <strong>' . $sa->AREA . '</strong></label></li>';
					}
				}
				?>
			</ul>
		</div>
	</div>
	<div class="col_left" id="literacy_level_select">
		<div class="instructions">Select Literacy Level</div>
		<div class="checkToggle">
			<a href="javascript:checkAll('levels');" style="padding:4px;">check all</a> <a href="javascript:uncheckAll('levels');" style="padding:4px;">uncheck all</a>
		</div>
		<div id="literacyList" style="height:85px;">
			<ul id="literacy-level-list">
<?php foreach ($literacy_levels as $i => $array) { ?>
					<li id="listItem_<?php echo $i ?>"><label for="levels_<?php echo $i ?>"><input type="checkbox" name="levels" value="<?php echo $i ?>" id="levels_<?php echo $i ?>"><strong><?php echo $this->common->tool_tip($array['tooltip'],$array['label']); ?></strong></label></li>
<?php } ?>
			</ul>
		</div>
		<div style="text-align:left;">
			<input class="refreshButton" type="image" src="graphics/show_data_button.png" value="Show Data">
			<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" onclick="SaveLiteracyReport()">
		</div>
	</div>
</form>

<div class="col_right" id="customers_summary_chartcolumn">
	<div class="controls" style="display:none; padding:8px;">
		<div style="float:left;width:130px">
			<span class="biggify"> [ + ] &nbsp;&nbsp;&nbsp;&nbsp;</span>
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
	<div id="customers_chartcolumn" style="margin-top:6px;overflow:auto;">
		<div class="table" id="table" style="width:100%;"></div>
		<div id="ldsummary_chart" class="chart offscreen" align="center" style="height:100%;">The chart will appear within this DIV. This text will be replaced by the chart.</div>
	</div>
</div>

<script language="javascript" type="text/javascript">
    function checkAll(obj_name){
        var count = document.literacy[obj_name].length;
		for (i=0; i<count; i++){
            document.literacy[obj_name][i].checked = true;
        }
    }

    function uncheckAll(obj_name){
        var count = document.literacy[obj_name].length;
		for (i=0; i<count; i++){
            document.literacy[obj_name][i].checked = false;
        }
    }
	function SaveLiteracyReport() {
        var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");

		ReportInfo.Init(ReportType.LiteracyDecision, "Literacy", $('#serviceArea :selected').text(), '');
		ReportInfo.AddReportItem(ReportItemType.Html, $(current_subtab + " .table").html(), '');

		ExportChart("summary_chart");
	}
</script>
