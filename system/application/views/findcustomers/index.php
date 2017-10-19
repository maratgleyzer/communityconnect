<?php $this->load->view('includes/header'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.sortable').sortable({
			helper: 'clone',
			handle: 'img.handle',
			axis: 'y',
			update: function() {
				var order = $('#field-list').sortable('toArray');
			}
		});
	});
</script>
<?php 
$tab_summary['page_name'] = 'Find Customers';
$this->load->view('includes/tab_summary_area', $tab_summary);
?>

<div id="segments" class="box full" style="height: auto;">
	<div id="segmentstitle" class="stitle">Segments</div>
	<div class="content">
		<ul class="ultabs">
			<li><a href="#summarytab"><?php echo $this->common->tool_tip('This enables you to customize segment data by category and date', 'Summary'); ?></a></li>
			<?php /*<li><a href="#underperformingtab"><?php echo $this->common->tool_tip('Coming soon', 'Underperforming Segments'); ?></a></li> */ ?>
			<li><a href="#opportunitiestab"><?php echo $this->common->tool_tip('This identifies specific locations to find new customers', 'Opportunities'); ?></a></li>
		</ul>
		<div id="summarytab" class="tab"><?php $this->load->view("findcustomers/summary.php"); ?></div>
		<?php /*<div id="underperformingtab" class="tab"><div class="col_left">This functionality will be available in the next product release.</div></div> */ ?>
		<div id="opportunitiestab" class="tab"><?php $this->load->view("findcustomers/opportunities.php"); ?></div>
	</div>
	<div class="clear"></div>
</div><!-- End DIV segments-->

<?php $this->load->view('includes/map'); ?>
<!-- End DIV geography-->


</div><!--End DIV main-->

<?php $this->load->view('includes/footer'); ?>
