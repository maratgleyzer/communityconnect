<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 $subtab = array("subtab" => "performance");
 ?>
  
<form name="performance_form" id="performance_form">
	<div class="col_left subtab_choices" id="materialscolumn">
	    <div>
			<div class="instructions">Select to analyze the data:</div>
		    <select name="analysis_level[]" class="analysis_level" multiple="multiple" size="5">		        
		    </select>
	   	 </div>
	   	 <div style="margin-top:8px">
		    <div class="instructions">Select services:</div>
		    <select name="services_choice" class="services_choice">
		        <option value="__default"> Choose Data Variable </option>
		        <option value="materials"> Material Types </option>
		        <option value="items_category"> Item Types -- By Category</option>
		        <option value="items_specific"> Item Types -- By Specific Type</option>
		    </select>    
	   	</div>
	   	<div class="data_variable" style="margin-top:8px; display: none;">   		
			<div class="instructions">Select a data variable:</div>
			<select class="material_type" name="data_variable[]" multiple="multiple" size="5"></select>
		</div>

		<?php $this->load->view('increaseservices/item_categories.php');?>
		<div class="col_left datecolumn">
			<?php $this->load->view('includes/checkouts.php', $subtab);?>
		</div>
	
		<div class="col_left datacolumn">
			<?php $this->load->view('increaseservices/datarange.php', $subtab);?>

	    	<div style="text-align: left;">
	    		<input class="refreshButton" type="image" src="/graphics/show_data_button.png" value="Show Data" style="cursor:pointer">
				<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" onclick="SavePerformanceReport()">
	    	</div>

			<div id="chart_sort" style="display:none">
				<p>Sort by:</p> 
				<select name="chart_sort">
				<option value="">Choose sort method</option>
				<option value="high_to_low">High to low</option>
				<option value="low_to_high">Low to high</option>
				<option value="a_to_z">A to Z</option>
				<option value="z_to_a">Z to A</option>
				</select>
			</div>
		</div>

	<div class="col_right" style="overflow:hidden;">
		<div class="controls" style="display:none;padding:8px;width:430px">
			<div style="float:left;width:130px">
			<span class="biggify"> [ + ] &nbsp;&nbsp;&nbsp;&nbsp;</span>
			<div class="displaytype normal toggleSelect selected">Table</div>
			<div class="displaytype inverted toggleSelect">Chart</div>	
			</div>
			<div style="float:right;width:265px">
			<span class="pivottype">Toggle View:</span>
			<div id="toggle_analysis_way" class="toggle_analysis_way pivottype inverted toggleSelect">By Type</div>
			<div id="toggle_analysis_area" class="toggle_analysis_area pivottype normal toggleSelect selected">By Area</div>			
			</div>
		</div>
		<br style="clear:both;" />
		<div id="performance_chartcolumn" style="margin-top:6px;overflow:auto;">
			<div class="table" id="table" style="width:100%;"></div>
		    <div id="performance_chart" class="chart offscreen" align="center" style="height:100%;">The chart will appear within this DIV. This text will be replaced by the chart.</div>
		</div>
	</div>

</form>
<script type="text/javascript">
	function SavePerformanceReport() {
        var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");

		ReportInfo.Init(ReportType.IncreaseServices, "Performance", $('#serviceArea :selected').text(), '');
		ReportInfo.AddReportItem(ReportItemType.Html, $(current_subtab + " .table").html(), '');

		ExportChart("is_performance_chart");	
	}
</script>
