<?php
$this->load->view('includes/header');
$this->load->view('includes/check_login');
?>
<div id="profiletitle" class="ptitle">My Account</div>
	<div class="content">
        <ul class="ultabs">
            <li><a href="#preferencestab"><span>Preferences</span></a></li>
            <li><a href="#changepasswordtab"><span>Change Password</span></a></li>
        </ul>
		<div id="preferencestab" class="tab"  style="height: auto;"><?php $this->load->view('myaccount/preferences'); ?></div>
		<div id="changepasswordtab" class="tab"  style="height:auto;"><?php $this->load->view('myaccount/change_password'); ?></div>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>