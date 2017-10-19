<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include "../dbconnection.php";

if ($_GET['f'] == 'create') {
    $email = mysql_real_escape_string($_GET['email']);
    $password = sha1($_GET['password']);

    $sql = "select * from users where email = '".$email."'";
    $r = mysql_query($sql);
    if (mysql_num_rows($r) > 0) {
        echo json_encode(array("Status"=>"EmailInUse","Message"=>"Email Address is already in use. Please login or use a different address."));
    } else {
        $randomCharacters = createRandomWord(9);
        $sql = "insert into users (email,password,validation) values ('".$email."','".$password."','".$randomCharacters."')";
        $r = mysql_query($sql);
        $linkURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?email=".htmlentities($email)."&validate=".$randomCharacters;

        if (mysql_affected_rows($link) == 1) {

            echo json_encode(array("Status"=>"AccountAdded","Message"=>"Success! You will receive an email with login instructions."));
            
            $subject = "Your new account to CommunityConnect with LiteracyDecision.";
            $message = "Thank you for creating an account for CommunityConnect with LiteracyDecision.

To complete your registration, click on the link below or enter the following activation code on the account verification page to confirm your account and begin using CommunityConnect with LiteracyDecision.

            $link

If clicking doesn't seem to work, you can copy and paste the link into your browser's address window, or retype it there. Once you have returned to CommunityConnect with LiteracyDecision, we will give instructions for resetting your password.

If you have any problems please contact Marc Futterman at [maf@civictechnologies.com] or if you need immediate assistance call toll free to (888) 606-7600.

Best,

CIVICTechnologies";
            $headers .= 'From: Community Connect <maf@civictechnologies.com>' . "\r\n";
            $headers .= 'Bcc: wooleys@gmail.com' . "\r\n";
            if (@mail($email, $subject, $message) === false ) {
                echo "FALSE!!!!!";
            }

        }
        
    }
}

if ($_GET['f'] == 'recover') {
    $email = mysql_real_escape_string($_GET['email']);

    $sql = "select * from users where email = '".$email."'";
    $r = mysql_query($sql);

    if (mysql_num_rows($r) > 0) {
        $randomCharacters = createRandomWord(9);
        $sql = "update users set temppass = '".$randomCharacters."' where email = '".$email."'";
        $r = mysql_query($sql);
        $linkURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?email=".htmlentities($email)."&pr=".$randomCharacters;
        $subject = "Community Connect Password Recovery";
        $recoverMessage = "Greetings from CommunityConnect with LiteracyDecision.

We received a request to reset the password associated with this e-mail address. If you made this request, please follow the instructions below.

If you did not request to have your password reset you can safely ignore this email. Rest assured your customer account is safe.

Click the link below to go to Step 3 to reset your password using our secure server:

$linkURL

If clicking doesn't seem to work, you can copy and paste the link into your browser's address window, or retype it there. Once you have returned to CommunityConnect with LiteracyDecision, we will give instructions for resetting your password.

Thank you!";
       @mail('wooleys@gmail.com',$subject,$recoverMessage);
        $userMessage = "<h4>Step 2: Check your Email</h4>An email has been sent to the account supplied with instructions for resetting your password.
                    <br><BR>If you don't receive this e-mail, please check your junk mail folder or contact Marc Futterman at [maf@civictechnologies.com] or if you need immediate assistance call toll free to (888) 606-7600.";
        echo json_encode(array("status"=>"RecoverySent","message"=>$userMessage));
    } else {
        echo json_encode(array("status"=>"RecoveryNotSent","message"=>"That email address is not in our system. Please register for an account."));
    }
}

if (isset($_GET['pr'])) {
    if (isset($_GET['email'])) {
        $message = "There is a problem with the URL. Please try to recover your password again.";
    } else {
        $sql = "select * from users where email = '".mysql_real_escape_string($_GET['email'])."' and temppass = '".mysql_real_escape_string($_GET['pr'])."'";
        $r = mysql_query($sql);
        if (mysql_num_rows($r)==0) {
            $message = "There is a problem with the URL. Please try to recover your password again.";
        } else {
            $message = "New Password:<br><input type=\"password\" name=\"password\" id=\"password\"><br><br>";
            $message .= "Confirm Password:<br><input type=\"password\" name=\"password_confirm\" id=\"password_confirm\"><br><br>";
            $message .= "<input type=\"button\" name=\"password_confirm\" id=\"password_confirm\"><br><br>";
        }
    }
}

function login() {

}

function newPassword() {
    /* This function sends the user an email with their forgotten password
     *
     */

}

function addUser() {
    /*
     *
     * Add a new user with a verification email
     *
     */

}

/**
 * The letter l (lowercase L) and the number 1
 * have been removed, as they can be mistaken
 * for each other.
    FROM http://www.totallyphp.co.uk/code/create_a_random_password.htm
 */

function createRandomWord($len=7) {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $word = '' ;
    while ($i <= $len) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $word = $word . $tmp;
        $i++;
    }

    return $word;
}

?>
