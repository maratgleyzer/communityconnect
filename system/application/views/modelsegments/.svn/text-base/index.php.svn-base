<?php $this->load->view('includes/header'); ?>
<script type="text/javascript">

$(document).ready(function() {
	$("#selectArea").setAreas(<?php echo $areas_json?>);
	$("#selectSegment").setSegments(<?php echo $segments_json?>);
	$("#selectSegment").setAllSegments(<?php echo $distinct_segments_json?>);
	$("#selectSegment").setSegmentData(<?php echo $segment_info_json?>);

<?php
	if (isset($sa_selected)) {
?>
	$("#selectArea").val('<?php echo $sa_selected?>');
	$("#selectArea").refreshMethods(false);
<?php
	}
	if (isset($sg_selected)) {
?>
	$("#selectSegment").val('<?php echo $sg_selected?>');
	$("#selectSegment").refreshInfo('<?php echo $sg_selected?>');
<?php
	}
?>

});
</script>

<div id="studySelect">
	<p>Select a Study Area:
	<select id="selectArea" class="styled" name="selectArea">
		<option value="Whole_District">Whole District</option>
		<?php
		$user_sa = $this->session->userdata('STUDYAREA');
		$excluded= $this->config->item('excluded_service_areas'); // these have 'no data' per daag
		foreach ($service_areas as $sa) {
			if (in_array($sa->AREA_ID, $excluded)) continue;
			$selected = ($user_sa != '' && $user_sa == $sa->AREA_ID)?'selected="selected"':'';
		?>
		<option value="<?php echo $sa->AREA_ID;?>" <?php echo $selected; ?>><?php echo $sa->AREA; ?></option>
	<?php } ?>
	</select>
	 <select name="segment" id="selectSegment"></select>
	</p>
</div>

<div id="profiletitle" class="ptitle"></div>
<div id="profile" class="box wide">
	<div class="content">
		<ul class="ultabs">
			<li><a href="#aboutmetab"><?php echo $this->common->tool_tip('General information about my segment', 'About Me'); ?></a></li>
			<li><a href="#myprefstab"><?php echo $this->common->tool_tip('Information about my interests and consumer preferences...financial, recreational, entertainment, shopping, eating, and so forth', 'My Preferences'); ?></a></li>
			<li><a href="#connecttab"><?php echo $this->common->tool_tip('Media that the library can use to connect with me', 'Connect With Me'); ?></a></li>
		</ul>
		<div id="aboutmetab" class="profiletab"><p class="sumText"><span style="padding-left:5px"></span></p></div>
		<div id="myprefstab" class="profiletab"><p class="sumText"><span style="padding-left:5px"></span></p></div>
		<div id="connecttab" class="profiletab"><p class="sumText"><span style="padding-left:5px"></span></p></div>
	</div>
</div>

<div id="dataglance" class="box narrow">
	<div id="dataglancetitle" class="stitle"><?php echo $this->common->tool_tip('This presents key data about the geography you selected above', 'Data at a Glance'); ?></div>
	<div id="dataglanceContent"> <?php echo $data_at_a_glance['table']; ?> </div>
</div>

<div id="services" class="box full" style="height: 380px;">
	<div id="servicestitle" class="stitle">Services</div>
	<div class="content">
		<ul class="ultabs">
			<li><a href="#summarytab"><?php echo $this->common->tool_tip('This enables you to understand the number and types of materials and items that were borrowed by each segment.', 'Summary'); ?></a></li>
			<?php
			/* removing until further notice
			<li><a href="#checkoutstab"><?php echo $this->common->tool_tip('This identifies specific locations to increase checkouts by segment and material and item type.', 'Checkouts'); ?></a></li>
			<li><a href="#comparetab"><?php echo $this->common->tool_tip('This enables you to market materials and items by identifying other segments that use similar services', 'Compare'); ?></a></li>
			<li><a href="#literacyscorecardtab"><?php echo $this->common->tool_tip('This enables you to market materials and items by identifying other segments that use similar services', 'Literacy Scorecard'); ?></a></li>
			 *
			 */
			?>
		</ul>
		<div id="summarytab" class="tab"><?php $this->load->view('modelsegments/summary.php', array('reportName' => 'SummaryReport'));?></div>
		<?php
		/* removing until further notice
		<div id="checkoutstab" class="tab"><?php $this->load->view('modelsegments/checkouts.php', array('reportName' => 'CheckoutsReport'));?></div>
		<div id="comparetab" class="tab"><?php $this->load->view('modelsegments/compare.php', array('reportName' => 'CompareReport'));?></div>
		<div id="literacyscorecardtab" class="tab"><?php $this->load->view('modelsegments/literacy.php', array('reportName' => 'LiteracyReport'));?></div>
		 *
		 */
		?>
	</div>
	</div><!-- End DIV segments-->

	<?php $this->load->view('includes/map'); ?>
	</div><!-- End DIV geography-->
</div><!--End DIV main-->
<?php $this->load->view('includes/footer'); ?>
