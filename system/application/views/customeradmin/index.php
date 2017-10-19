<?php
$this->load->view('includes/header');
$this->load->view('includes/check_admin');
?>
<div class="ptitle">Customer Administrative Center</div>
<div id="profile"  class="box wide">
	<div id="servicestitle" class="stitle">Summary
		<p class="sumText"><span>The purpose of the CAC is to provide administrative functions for Customer Administration</span></p>
	</div>
</div>


<div id="customeradmin" class="box full" style="height:750px;">
	<div id="admintitle" class="stitle">Segments</div>
	<div id="admincontent" class="content">
		<ul class="ultabs">
			<li><a href="#viewusage"><?php echo $this->common->tool_tip('View Usage Stats', 'View Usage Stats'); ?></a></li>
			<li><a href="#manageusage"><?php echo $this->common->tool_tip('Manage Usage Stats Viewer', 'Manage Usage Stats Viewer'); ?></a></li>
			<li><a href="#manageexpress"><?php echo $this->common->tool_tip('Manage Express Logon Preferences', 'Manage Express Logon Preferences'); ?></a></li>
			<?php /*<li><a href="#roicalc"><?php echo $this->common->tool_tip('ROI Calculator', 'ROI Calculator'); ?></a></li> */ ?>
		</ul>
		<div id="viewusage" class="tab"><?php $this->load->view('customeradmin/usage_stats.php'); ?></div>
		<div id="manageusage" class="tab"><?php $this->load->view('customeradmin/manage_stat_viewers.php'); ?></div>
		<div id="manageexpress" class="tab"><?php $this->load->view('customeradmin/express_logon.php'); ?></div>
		<?php /*<div id="roicalc" class="tab"><?php $this->load->view('customeradmin/roi_calc.php'); ?></div> */ ?>
	</div>
</div>

</div><!--End DIV main-->
<?php $this->load->view('includes/footer'); ?>
