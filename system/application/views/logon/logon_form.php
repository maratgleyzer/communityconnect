<?php $this->load->view('includes/header'); ?>
<?php
$validated = $this->session->userdata('validated');
$msgstr = '';
if (isset($validated)) {
	if ($validated == 1)
		$msgstr = 'Your account has been created and confirmed, please login to the right.';
	if ($validated == -1)
		$msgstr = 'Your account cannot be activated.';
	$session_data = array('validated' => '');
	$this->session->set_userdata($session_data);
}
?>

<div id="profiletitle" class="ptitle">Log On</div>
<div id="createResponse" class="message"><?php echo $msgstr; ?></div>
<div class="box" style="margin-left: 0;">
	<div id="createAccount">
		<form id="frmCreateAccount" name="frmCreateAccount">
			<h3><?php echo $this->common->tool_tip('Create your own account by entering information below and validating your new account by e-mail', 'Create New Account'); ?></h3>
			<p>To get the most out of Community Connect, create your own account.</p>
			<div>
				<strong>Email</strong><br />
				<input type="text" name="createEmail" id="createEmail" size="30" value="" /><br />
				<br />
				<strong>Password</strong><br />
				<input type="password" name="createPassword" id="createPassword" size="30" value="" /><br />
				<br />
				<strong>Confirm Password</strong><br />
				<input type="password" name="password_confirm" id="password_confirm" size="30" value="" />
				<br />
				<br />
		 <!--<img id="" src="graphics/create_account_button_gray.png" onclick="createAccount(); this.src='graphics/create_account_button.png';" onMouseOut="this.src='graphics/create_account_button_gray.png'">-->
				<a href="#" onclick="createAccount();"><img id="" src="/graphics/create_account_button.png"></a>
			</div>
		</form>
	</div>
</div>

<div class="box">
	<div id="expressLogon">
		<h3><?php echo $this->common->tool_tip('Immediately access CommunityConnect. Any reports you create in Express Login can be viewed, changed, or deleted by others. You can manually delete reports at the end of your session.', 'Express Login'); ?></h3>
		<div>
			<form action="/logon" method="POST">
				<p>Login using the Library's shared account.<br />
					<br />
					<input type="hidden" value="expressLogin" name="expressLogin" />
					<input type="image" src="/graphics/express_login_button.png" value="Express Login" name="expressLogin" />
				</p>
			</form>
		</div>
	</div>
</div>

<div class="box" >
	<div id="existingLogon" class="logonBox">
		<?php
		if ($pwd_msg) {
			echo $pwd_msg;
		} else {
		?>
			<h3><?php echo $this->common->tool_tip('Enter your e-mail address (your username) and password', 'Returning User Login'); ?></h3>
			<p>Login to your own personal account.</p>
			<div>
			<?php
			if ($logon_fail) {
				echo "<p>Email or Password Incorrect. Forgot your Password? <a href=\"#\" onclick=\"recoverPassword();\">Click here.</a></p>";
			}
			?>
			<form name="login" action="/logon" method="POST">
				<strong>Email</strong><br />
				<input type="text" name="registeredEmail" size="30" /><br />
				<br />
				<strong>Password</strong><br />
				<input type="password" name="registeredPassword" size="30" />
				<br /><br />
				<input name="registeredSubmit" size="30" type="image" src="/graphics/user_login_button.png" value="User Login" /><br>
			</form>
			<p><a href="javascript:;" onclick="recoverPassword()">Forgot Password?</a></p>
			<?php } ?>
		</div>
	</div>
</div>

</div><!--End DIV main-->

<div style="text-align: center;font-size: 12px;color: #555;margin-top: 40px;">If you need assistance, please contact support@civictechnologies.com or (888) 606-7600.</div>

<?php $this->load->view('includes/footer'); ?>