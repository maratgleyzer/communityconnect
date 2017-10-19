<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
 $subtab = array("subtab" => "opportunities");
?>
<style type="text/css">
/*	BULLET GRAPH */

div.service-tab { cursor:hand; cursor:pointer; border: 4px solid #c3daf9; position: relative; width: 195px; height: 55px; top: 0; left: 0; margin: 0 0 5px 5px; padding: 0px; }

/*	CHANGE THE WIDTH AND BACKGROUND COLORS AS NEEDED */
div.box1 { display:none; position: absolute; height: 30px; width: auto; right: 5px; left: 5px; /*top:28px; */background-color: #fff; z-index: 1; font-size: 0; margin:0px; border: 1px solid #83942E;}

/* ONE SEGMENT ONLY */
div.actual_outline { width: 170px; border: 1px solid #5A554C; position: absolute; height: 15px; left: 11px; top: 25px; background-color: #fff; z-index: 5; }
div.actual { position: absolute; height: 13px; left: 12px; top: 27px; background-color: #c3daf9; z-index: 5; }

div.mylabel 
	{ 
	color: #5A554C; 
	font: 8pt Arial, sans-serif; 
	font-weight:bold;
	height: 13px; 
	left: 37px;
	position: relative; 
	top: 9px;
	width: 105px; 
	z-index: 7; 
	}

div.service 
	{ 
	z-index: 7; 
	font-size: 0;
	color: #5A554C; 
	font: 10pt Arial, sans-serif; 
	text-align: left; 
	position:relative;
	left:3px;
	}
div.service-tab-selected {
	background-color: #c3daf9;
	width:205px	
}

</style>
<script type="text/javascript">
$(document).ready(function() {

	$('img.handle').attr('title','');
	$('#field-list').sortable({
		helper: 'clone',
		handle: 'img.handle',
		axis: 'y',
		update: function(obj) {
			drag_drop_order_list();
		}
	});
	$('#field-list input').change(function() {
		// segments do not appear when we are looking at the entire district
		if ($('#opportunities_form .analysis_level').val() == "__all" && $(this).val() == "opportunities_segment") {
			$(this).removeAttr('checked');
		} else {
			drag_drop_order_list();
		}
	});
	function drag_drop_order_list() {
		var order = $('#field-list').sortable('toArray');
		var tmp = '';
		for (var i=0; i < order.length; ++i) {
			if ($("#" + order[i] + " input").is(":checked")) {
				tmp +=  order[i] + ',';
			}
		}
		$('#opportunities_form input[name="field_list"]').val(tmp);
	}
});
</script>

<form name="opportunities_form" id="opportunities_form">
	<input name="field_list" type="hidden" value="">
	<div class="col_left subtab_choices" id="opportunities_choices">
		<div style="margin-bottom:8px">
			<div class="instructions">Select a way to analyze the data:</div>
			<select name="analysis_level" class="analysis_level">		        
			</select>
		</div>
    	<div style="margin-bottom:8px">
	    	<div class="instructions">Select a way to analyze the data:</div>
    		<select name="services_choice" class="services_choice">
        		<option value="__default"> Choose Data Variable </option>
        		<option value="materials"> Material Types </option>
	        	<option value="items_category"> Item Types -- By Category</option>
    		</select>
		</div style="margin-bottom:8px">
		<?php $this->load->view("increaseservices/datarange.php", $subtab); ?>
		<?php $this->load->view('includes/checkouts.php', $subtab); ?>
	</div>

	<div style="width:180px" class="col_left" id="is_opportunities_field_order">
    	<div class="instructions">Drag and drop to set field order:</div>
    	<div class="sortlist">
    		<ul id="field-list">
				<?php foreach ($fields as $key => $arr) {
					$text = $this->common->tool_tip($arr['title'], $arr['label']);
				?>
       			<li id="<?php echo $key?>"><img align="middle" class="handle" src="/css/images/dragger.png"><label for="fc_opportunities_<?php echo $key; ?>"><input type="checkbox" name="fields[]" value="<?php echo $key?>" id="fc_opportunities_<?php echo $key?>"> <strong><?php echo $text?> </strong></label></li>
				<?php } ?>
     		</ul>
  		</div>
		<br style="clear:both;">
        <div style="text-align:left; margin-top:10px;">
	    	<input class="refreshButton" type="image" src="/graphics/show_data_button.png" value="Show Data" style="cursor:pointer">
			<a id="is_ops_gen_report"><img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none"></a>
        </div>
	</div>
	<div class="col_right" style="overflow:hidden">
		<div class="controls" style="display:none; padding:4px; width:320px;">
			<div style="float:left;width:107px">
			<span class="biggify"> [ + ] &nbsp;&nbsp;&nbsp;&nbsp;</span>
			</div>
		</div>
		<br style="clear:both;">
		<div style="margin-top:6px; overflow:auto; height:250px;" id="opportunities_chartcolumn">
			<div id="services_rank" class="service_rank" style="background-color:#fff;width:215px; float:left;display:none"> 
				<?php for ($i = 0; $i < 25; $i++) { ?>
				<div style="display:none" id="is_op_st_<?php echo $i;?>" class="service-tab">
					<div class="service"></div>
					<div class="box1"></div>
					<div class="actual_outline" ></div>
					<div class="actual" style="width: 0%"></div>
					<div class="mylabel"></div>
				</div>
				<?php } ?>
			</div>
			<div class="ops_data_table"> 
				<p class="table_title" style="font-weight:bold; display:none">Block Group Opportunities</p>
				<div class="table" style="width:245px;"> </div>
			</div>
			<div style="clear:both"></div>
		</div>
	</div>

</form>
