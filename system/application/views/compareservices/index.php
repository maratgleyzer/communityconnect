<?php $this->load->view('includes/header'); ?>
<form id="reports_form">
	<input type="hidden" name="table_data" value="" />
	<input type="hidden" name="image_filenames" value="" />
	<input type="hidden" name="report_type" value="" />
	<input type="hidden" name="report_name" value="" />
	<input type="hidden" name="geographic_area" value="" />
</form>
<?php
$tab_summary['page_name'] = 'Compare Service Areas';
$this->load->view('includes/tab_summary_area', $tab_summary);
?>
<div id="compareservices">
	<div id="services" class="box full" style="height:auto;">
		<div id="profiletitle" class="stitle">List Service Areas to Compare</div>
		<div class="content">
			<ul class="ultabs">
				<li><a href="#performancetab"><?php echo $this->common->tool_tip('Select a service area and compare it to others using predetermined data classifications', 'Performance'); ?></a></li>
				<li><a href="#customizetab"><?php echo $this->common->tool_tip('Select the specific data sets and service areas you’d like to compare', 'Customize Data'); ?></a></li>
			</ul>
			<div id="performancetab" class="tab"><?php $this->load->view("compareservices/compare_performance"); ?></div>
			<div id="customizetab" class="tab"><?php $this->load->view("compareservices/compare_customize"); ?></div>
		</div>
	</div><!-- End DIV service areas-->
</div>

<?php $this->load->view('includes/map'); ?>
<!-- End DIV geography-->
</div>

</div><!--End DIV main-->
<?php $this->load->view('includes/footer'); ?>
