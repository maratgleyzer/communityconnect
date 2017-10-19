<?php
@session_start();
include "../dbconnection.php";

$fail = false;
print_r($_POST);
if(isset($_POST['registeredSubmit'])) {
        $pass = sha1(mysql_real_escape_string($_POST['registeredPassword']));
        $email = mysql_real_escape_string($_POST['registeredEmail']);

    $sql = "select * from users where email = '".$email."' and password = '".$pass."'";
    $r = mysql_query($sql);
    if (mysql_num_rows($r) == 1) {
        $_SESSION['auth'] = date('d');
        $_SESSION['email'] = $email;
        header("location:index.php");
    } else {
        $fail = true;
    }
}

if(isset($_POST['expressLogin'])) {
        $_SESSION['auth'] = date('d');
        header("location:index.php");
}

?>
<html>
    <head>
        <title>Community Connect: Log On</title>
        <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>

        <script type="text/javascript" src="js/jquery-ui-1.8.5.js"></script>
        <script>
            function createAccount() {
                    
                    var email = $('#createEmail').val();
                    var password = $('#createPassword').val();
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
                            "users_functions.php",
                            "f=create&email="+email+"&password="+password,
                            function(data) {
                                console.log(data.Status);
                                if (data.Status == 'EmailInUse') {
                                    $("#createResponse").html(data.Message);
                                }
                                if (data.Status == 'AccountAdded') {
                                    $("#createResponse").html(data.Message);
                                }
                            },
                            "json"
                    );
            }

            function recoverPassword() {
                var recoverString = '<h3>Step 1: Enter the email address asociated with your account, then click Continue.</h3>';
                 recoverString += "We'll email you a link to a page where you can easily create a new password.";
                 recoverString += "<BR><BR>";
                 recoverString += 'Email Address:<input type="text" id="recoverAddy"><BR><BR>';
                 recoverString += 'Confirm Email Address:<input type="text" id="recoverAddy2"><BR>';
                 recoverString += '<div id="recoverEmailError"></div>';
                 recoverString += '<input type="button" value="Continue" onclick="recoverPassword2();>';

                $('#existingLogon').html(
                    recoverString
                );
            }

            function recoverPassword2() {
                var email = $('#recoverAddy').val();
                var email2 = $('#recoverAddy2').val();
                console.log(email + " " + email2);
                if (email != email2) {
                    $('#recoverEmailError').html('Email Addresses do not match. Please try again');
                } else {
                    $.get(
                            "users_functions.php",
                            "f=recover&email="+email,
                            function(data) {
                                console.log(data.Status);
                                //$("#createAccount").html(data);
                                $('#existingLogon').html(data.message);
                            },
                            "json"
                    );

                }
            }
        </script>
        <style>
            .message {
                color:#C91418;
}
            .logonBox {
                float:left;
                width:300px;
                height:350px;
                margin:10px;
                padding:10px;
                border: 2px solid #efefef;
                font-family: 'calibri';
            }
            #createAccount.logonBox {
                background-color: #dfdfdf;
        }
        </style>
    </head>
    <body>
        <!-- this is where the login boxes go. The top stuff should go in the header, if that is how it is done. -->
        <div id="createAccount" class="logonBox">
            <form id="frmCreateAccount" name="frmCreateAccount">
                <h3>Create New Account</h3>
                <p>To get the most out of Community Connect, create your own account.</p>
                Email<br>
                <input type="text" name="createEmail" id="createEmail" size="25" value=""><br>
                <div id="createResponse" class="message"></div>
                Password<br>
                <input type="password" name="createPassword" id="createPassword" size="25" value=""><br><br>
                Confirm Password<br>
                <input type="password" name="password_confirm" id="password_confirm" size="25" value=""><br><br>
                <input type="button" name="createSubmit" value="Create Account" onclick="createAccount();">
            </form>
        </div>

        <div id="expressLogon" class="logonBox">
           <h3>Express Login</h3>
                <p>Login using the Library's shared account.</p><br>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="image" src="graphics/express_login_button.png" value="Express Login" name="expressLogin">
                </form>
        </div>

        <div id="existingLogon" class="logonBox">
           <h3>Returning User Login</h3>
           <p>Login to your own personal account.</p><br>
           <?php
            if ($fail) {
                echo "Email or Password Incorrect. Fogot your Password? <a href=\"#\" onclick=\"recoverPassword();\">Click here.</a><br><br>";
            }
            ?>
            <form name="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                Email: <br>
                <input type="text" name="registeredEmail">
                <br><br>
                Password: <br>
                <input type="password" name="registeredPassword">
                <br><br>
                <input name="registeredSubmit" type="image" src="graphics/user_login_button.png" value="User Login">
            </form>
        </div>

    </body>
</html>
