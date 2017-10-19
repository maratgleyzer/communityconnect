function createAccount() {

	$("#createResponse").css('display','none');
	
	var email = $("#createEmail").val();
	var password = $("#createPassword").val();
	var password_confirm = $('#password_confirm').val();

	if(email.indexOf("@") == -1) {
		alert("Please enter a valid email address");
		return;
	}

	if(email.indexOf(".") == -1) {
		alert("Please enter a valid email address");
		return;
	}

	if (jQuery.trim('password') == '') {
		alert('Please enter a password');
		return;
	}

	if (password != password_confirm) {
		alert('Passwords do not match. Please try again.');
		return;
	}

	$.get(
		//"users_functions.php",
		"/logon/users_functions",
		"f=create&email="+email+"&password="+password,
		function(data) {
			console.log(data.Status);
			if (data.Status == 'EmailInUse' || data.Status == 'AccountAdded' || data.Status == 'DomainNotMatch') {
				$("#createResponse").html(data.Message);
				$("#createResponse").css('display','block');
			}
			if (data.Status == 'ERROR') {
				$("#createResponse").html(data.Message);
				$("#createResponse").css('display','block');
			}
		},
		"json"
		);
}

function changePassword() {
	var password = $("#password").val();
	var password_confirm = $('#confirm_password').val();
	var email = $("#email_address").val();
	if (jQuery.trim('password') == '') {
		alert('Please enter a password');
		return;
	}
	if (password != password_confirm) {
		alert('Passwords do not match. Please try again.');
		return;
	}
	document.change_password.submit();
}

function recoverPassword() {
	var recoverString = '<h3>Step 1: Enter the email address associated with your account.</h3>';
	recoverString += "<p>We'll email you a link to a page where you can easily create a new password.</p>";
	recoverString += '<div><strong>Email Address</strong><br /><input type="text" id="recoverAddy" size="30"><br /><br />';
	recoverString += '<strong>Please reconfirm your email address</strong><br /><input type="text" size="30" id="recoverAddy2"></div>';
	recoverString += '<p id="recoverEmailError" style="color:red; display: none; padding: 10px 0 0;"></p>';
	recoverString += '<br /><a href="#" onclick="recoverPassword2();"><img src="/graphics/continue_button.png"></a>';
	recoverString += '<p>For assistance please email: <a href="mailto:support@civictechnologies.com" style="color:#036;font-size:12px;" >support@civictechnologies.com</a></p>';
	$('#existingLogon').parent('div.box').css('height','auto');
	$('#existingLogon').html(
		recoverString
	);
}

function recoverPassword2() {
	var email = $('#recoverAddy').val();
	var email2 = $('#recoverAddy2').val();
	console.log(email + " " + email2);
	if (email == "" && email2 == "") {
		$('#recoverEmailError').html('Please enter Email Addresses');
		$('#recoverEmailError').show();
	}
	else if(email.indexOf("@") == -1) {
		$('#recoverEmailError').html('Please enter a valid email address');
		$('#recoverEmailError').show();
	}
	else if(email.indexOf(".") == -1) {
		$('#recoverEmailError').html('Please enter a valid email address');
		$('#recoverEmailError').show();
	}
	else if (email != email2) {
		$('#recoverEmailError').html('Email Addresses do not match. Please try again');
		$('#recoverEmailError').show();
	} else {
		$('#recoverEmailError').hide();
		$.get(
			"/logon/users_functions",
			"f=recover&email="+email,
			function(data) {
				console.log(data.Status);
				$('#existingLogon').html(data.message);
			},
			"json"
			);

	}
}
