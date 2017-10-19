<?php $this->load->view('includes/header'); ?>
<?php echo $reportgrid_js; ?>
    <div class="ptitle">Reports</div>
    <p>Click on a tab below to obtain your reports.</p>
    
    <div style="height:350px;"> 
        <ul class="ultabs">
            <li><a href="#findcustomers"><span>Find Customers</span></a></li>
            <li><a href="#increaseservices"><span>Increase Services</span></a></li>
            <li><a href="#literacydecision"><span>LiteracyDecision</span></a></li>
            <li><a href="#compareserviceareas"><span>Compare Service Areas</span></a></li>
            <li><a href="#marketresearch"><span>Market Research</span></a></li>
        </ul>
        <div id="findcustomers" class="tab"><?php $this->load->view('reports/reports_list', array('querytype' => '1')); ?></div>
        <div id="increaseservices" class="tab"><?php $this->load->view('reports/reports_list', array('querytype' => '2')); ?></div>
        <div id="literacydecision" class="tab"><?php $this->load->view('reports/reports_list', array('querytype' => '3')); ?></div>
        <div id="compareserviceareas" class="tab"><?php $this->load->view('reports/reports_list', array('querytype' => '4')); ?></div>
        <div id="marketresearch" class="tab"><?php $this->load->view('reports/reports_list', array('querytype' => '5')); ?></div>
    </div>
    <script type="text/javascript">

		$(function() {
			var rtype = getQueryString('rtype');
			if(rtype != '') $(".ultabs").tabs('select', parseInt(rtype) - 1);
		});
		
		function getQueryString(key) {
			key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  			var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
  			var qs = regex.exec(window.location.href);
 			if(qs == null) return '';
			else return qs[1];
		}

		function DoGridCommand(com, grid) {
			if (com == 'Select All') {
				$('.bDiv tbody tr',grid).addClass('trSelected'); 
			} else if (com == 'Deselect All') {
				$('.bDiv tbody tr',grid).removeClass('trSelected');
			} else {
				if($('.trSelected',grid).length>0){
					var items = $('.trSelected',grid);
					var itemlist ='';
					for(i=0;i<items.length;i++){
						itemlist+= (itemlist!=''?',':'') + items[i].id.substr(3);
					}
					if (com=='Delete') {
					   if(confirm('Delete ' + items.length + ' items?')){
							$.ajax({
								type: "POST",
								url: "/reports/delete_reports",
								data: "idlist="+itemlist,
								success: function(data){
									var gridid = grid.children[5].children[0].id;
									$('#' + gridid).flexReload();
								}
							});
					   }
					} else if (com == 'Open' || com == 'Download') {
						var dest = com == 'Open' ? 'I' : 'D';
						var ids = itemlist.split(',');
						for(i = 0; i < ids.length; i++) {
							var url = '/reports/open_report?rid=' + ids[i] + '&d=' + dest;
							window.open(url,'report' + ids[i],'width=850,height=600,toolbars=no,resizable=yes,scrollbars=no,screenX=10,screenY=10,top=10,left=10');
						}
					}
				} else {
					return false;
				} 
			}
		}
	</script>
</div><!--End DIV main-->
<?php $this->load->view('includes/footer'); ?>
