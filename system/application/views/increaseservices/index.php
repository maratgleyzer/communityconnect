<?php $this->load->view('includes/header'); ?>
<script type="text/javascript">

	$(document).ready(function() {
		$("#serviceArea").setAreas(<?php echo $areas_json ?>);
		$(".analysis_level").setSegments(<?php echo $segments_json ?>);
		$("#serviceArea").refreshMethods();
		$('.services_choice').setItems(<?php echo $items_json ?>);
		$('.services_choice').setMaterials(<?php echo $materials_json ?>);

	});
</script>

<form id="reports_form">
	<input type="hidden" name="table_data" value="" />
	<input type="hidden" name="image_filenames" value="" />
	<input type="hidden" name="report_type" value="" />
	<input type="hidden" name="report_name" value="" />
	<input type="hidden" name="geographic_area" value="" />
</form>
<?php
$tab_summary['page_name'] = 'Increase Services';
$this->load->view('includes/tab_summary_area', $tab_summary);
?>

<div id="services" class="box full" style="height: auto;">
	<div id="servicestitle" class="stitle">Services</div>
	<div class="content">
		<ul class="ultabs">
			<li><a href="#summarytab"><?php echo $this->common->tool_tip('This enables you to understand the number and types of materials and items that were borrowed by each segment.', 'Performance'); ?></a></li>
			<li><a href="#opportunitiestab"><?php echo $this->common->tool_tip('This identifies specific locations to increase checkouts by segment and material and item type.', 'Opportunities'); ?></a></li>
			<?php /* 
			<li><a href="#marketingtab"><?php echo $this->common->tool_tip('This enables you to market materials and items by identifying other segments that use similar services', 'Marketing'); ?></a></li> */ ?>
		</ul>
		<div id="summarytab" class="tab"><?php $this->load->view('increaseservices/performance.php', array('reportName' => 'PerformanceReport')); ?></div>
		<div id="opportunitiestab" class="tab"><?php $this->load->view('increaseservices/opportunities.php', array('reportName' => 'OpportunitiesReport')); ?></div>
		<?php /* <div id="marketingtab" class="tab"><?php $this->load->view('increaseservices/marketing.php', array('reportName' => 'MarketingReport')); ?></div> */ ?>
	</div>
</div><!-- End DIV segments-->

<?php $this->load->view('includes/map'); ?>
</div><!-- End DIV geography-->
</div><!--End DIV main-->
<?php $this->load->view('includes/footer'); ?>
