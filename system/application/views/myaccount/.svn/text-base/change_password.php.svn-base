<div class="col_left" id="my_account_preferences_right">
	<form name="change_password_form" id="change_password_form">
		<h3>Change Password</h3>
		<br />
		<div>
			<strong>Current Password:</strong><br />
			<input type="password" name="current_pass" id="current_pass"><br />
			<br />
			<br />
			<strong>New Password:</strong><br />
			<input type="password" name="new_pass" id="new_pass"><br />
			<br />
			<strong>New Password Confirm:</strong><br />
			<input type="password" name="anew_pass2" id="new_pass2">

			<!--INPUT TYPE="image" SRC="graphics/save_changes_button.png" BORDER="0"-->
			<p id="passmsg"></p>
			<a href="javascript:changePassword();"><img src="graphics/save_changes_button.png" border="0"></a>
		</div>
	</form>
</div>
<script language="javascript" type="text/javascript">
    function changePassword(){
        var current_pass = $('#current_pass').val();
        var new_pass = $('#new_pass').val();
        var new_pass2 = $('#new_pass2').val();
        if (jQuery.trim('current_pass') == '') {
            alert('Please enter current password');
            return;
        }
        if (jQuery.trim('new_pass') == '') {
            alert('Please enter new password');
            return;
        }
        if (new_pass != new_pass2) {
            alert('Passwords do not match. Please try again.');
            return;
        }
        $.get(
		"/myaccount/change_password",
		"current_pass="+current_pass+"&new_pass="+new_pass,
		function(data) {
			$('#passmsg').html(data.Message);
		},
		"json"
	);
    }
</script>
<br class="clear" />