<script type="text/javascript">
$(document).ready(function() {

	$('img.handle').attr('title','Drag to set the field order');
	$('#field-list').sortable({
		helper: 'clone',
		handle: 'img.handle',
		axis: 'y'
	});
});
</script>
<?php $subtab = array("subtab" => "summary"); ?>
<form name="ms_summary_form" id="ms_summary_form">
	<div class="col_left field_order" id="customers_summary_field_order">
		<div class="instructions">View and organize segments:</div>
		<div class="sortlist" id="fc_summary_sortlist">
			<?php /*
			<div class="imageToggle" style="float: right;">
				<input name="format" type="image" value="number" class="selected" src="/graphics/number_button.png">
				<input name="format" type="image" value="percent" src="/graphics/percent_button.png">
			</div>
			*/ ?>
			<div class="instructions">Select which fields to display.  Then drag and rop each field into the display order you want:</div>
    		<ul id="field-list">
				<?php foreach ($fields as $key => $arr) {
					$text = $this->common->tool_tip($arr['title'], $arr['label']);
				?>
       			<li id="<?php echo $key?>"><img align="middle" class="handle" src="/css/images/dragger.png"><label for="fc_opportunities_<?php echo $key; ?>"><input type="checkbox" name="fields[]" value="<?php echo $key?>" id="fc_opportunities_<?php echo $key?>"> <strong><?php echo $text; ?></strong></label></li>
				<?php } ?>
     		</ul>

			</div>
<br style="clear:both;">
		<div class="buttonCont"><input class="refreshButton" type="image" src="/graphics/show_data_button.png" value="Show Data" id="summary_show_data" />
			<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" onclick="SaveSummaryReport()">
		</div>
		<div id="data_variable"></div>
			<div class="chart_sort" style="display:none">
				<p>Sort by:</p> 
				<select name="chart_sort">
				<option value="">Choose sort method</option>
				<option value="high_to_low">High to low</option>
				<option value="low_to_high">Low to high</option>
				</select>
			</div>
	</div>

	<div class="col_right">
		<div class="controls" style="display:none;padding:8px;">
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
		<div id="ms_chartcolumn" style="margin-top:6px;overflow:auto;">
			<div class="table" id="table" style="width:100%;"></div>
		    <div id="summary_chart" class="chart offscreen" align="center" style="height:100%;">The chart will appear within this DIV. This text will be replaced by the chart.</div>
		</div>
	</div>
</form>
	
<script type="text/javascript">
	function SaveSummaryReport() {
        var current_subtab = $(".full .ultabs .ui-tabs-selected a").attr("href");

		ReportInfo.Init(ReportType.ModelSegments, "Summary", $('#serviceArea :selected').text(), '');
		ReportInfo.AddReportItem(ReportItemType.Html, $(current_subtab + " .table").html(), '');

		ExportChart("ms_summary_chart");	
	}
</script>
