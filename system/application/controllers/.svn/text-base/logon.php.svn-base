<?php

class Logon extends CV_Controller {

	var $data = array();

	function __construct () 
	{
		parent::CV_Controller();
		$this->load->model('users_model');
	}

	function index (){
		$data = $this->data;
		$data['extraJS'] = 'logon';
		$data['pageClass'] = "logon";
        $data['pageTitle'] = "Logon";
		$data['logon_fail'] = false;

		// validate login status
		if(isset($_REQUEST['registeredEmail'])) {
			$pass = sha1($_REQUEST['registeredPassword']);
			$email = $_REQUEST['registeredEmail'];
			$user = $this->users_model->get_user_by_email_password($email, $pass);
			if ($user) {
			        if (is_array($user)) {
					$user = $user[0];
				}
				$session_data = array(
					'auth' => date('d'),
					'email' => $email,
					'uid' => $user->USER_ID,
                    'role' => $user->ROLE_ID,
					'STUDYAREA' => $user->STUDYAREA
				);
				$this->session->set_userdata($session_data);
				$redirect = ($this->session->userdata('redirect'))?$this->session->userdata('redirect'):'/home';
				$this->session->unset_userdata('redirect');
				redirect($redirect);
			} else {
				$data['logon_fail'] = true;
			}
		}


		if(isset($_REQUEST['expressLogin'])) {
			$session_data = array('auth' => date('d'));
			$this->session->set_userdata($session_data);
			$redirect = ($this->session->userdata('redirect'))?$this->session->userdata('redirect'):'/home';
			$this->session->unset_userdata('redirect');
			redirect($redirect);
			/*
			$_SESSION['auth'] = date('d');
			header("location:index.php");
			*/
		}
		if (isset($_REQUEST['email_address'])) {
            $email = mysqli_real_escape_string($this->db->conn_id, $_REQUEST['email']);
            $password = sha1($_REQUEST['password']);
            $user_data = array("PASSWORD" => $password);
            $this->users_model->update_user_by_email($email, $user_data);
            $user = $this->users_model->get_user_by_email_password($email, $password);
            if (is_array($user)) {
                $session_data = array(
                    'auth' => date('d'),
                    'email' => $email,
                    'uid' => $user[0]->USER_ID
                );
                $this->session->set_userdata($session_data);
                
                $subject = "Confirming New Password for CommunityConnect with LiteracyDecision";
                $email_content = "<p>Thanks for visiting CommunityConnect with LiteracyDecision.</p><p>Per your request, you have successfully changed your password.</p><p>Should you need to contact us for any reason, please know that we can give out information only to the e-mail address associated with your account.</p><p>Thank you!</p><p>If you need further assistance, please contact Marc Futterman at <a href='mailto:maf@civictechnologies.com'>maf@civicechnologies.com</a> or call toll free (888) 606-7600.</p>";
                
                $this->sendmail('support@civictechnologies.com', 'support@civictechnologies.com',$email, $subject, $email_content);
				redirect('/home');
			}
		}

        $data["pwd_msg"] = "";
        if (isset($_REQUEST['pr'])) {
            if (!isset($_REQUEST['email'])) {
                $message = "There is a problem with the URL. Please try to recover your password again.";
            } else {
                $sql = "select * from users where email = '".mysqli_real_escape_string($this->db->conn_id, $_REQUEST['email'])."' and temppass = '".mysqli_real_escape_string($this->db->conn_id, $_REQUEST['pr'])."'";
                $r = mysql_query($sql);
                if (mysql_num_rows($r)==0) {
                    $message = "There is a problem with the URL. Please try to recover your password again.";
                } else {
                    $message = "<h3>Step 3: Create your new password</h3><br><br>";
                    $message .= '<form name="change_password" action="/logon?email='.$_REQUEST['email'].'&pr='.$_REQUEST['pr'].'" method="POST">';
                    $message .= "New Password:<br><input type='password' name='password' id=\"password\"><br><br>";
                    $message .= "Confirm Password:<br><input type='password' name='confirm_password' id='confirm_password'><br><br>";
                    $message .= "<a href='#' onclick='changePassword()'><img src='graphics/save_changes_button.png'></a><br><br>";
                    $message .= '<input type="hidden" name="email_address" id="email_address" value="'.$_REQUEST['email'].'">';
                    $message .= '</form>';
                    $message .= '<p>For assistance please email: <a href="mailto:support@civictechnologies.com" style="color:#036;" >support@civictechnologies.com</a></p>';
                }
            }
            $data["pwd_msg"] = $message;
        }

		//echo 'we need to go to log on screen';
		$this->load->view('logon/logon_form', $data);
	}

    function user_validate($email, $validate){
        $user = $this->users_model->get_user_by_email_validate($email, $validate);
        if (!$user)  {
            $session_data = array('validated' => -1);
        }else{
            $user_data = array(
					'VALID' => 1
			);
            foreach ($user as $row)
            {
                $user_id = $row->USER_ID;
            }
		    $user_id = $this->users_model->update_user($user_id, $user_data);
            $session_data = array('validated' => 1);
        }
		$this->session->set_userdata($session_data);
        redirect('/');
    }
	// TODO:  break this out into distinct functions.
	// terrible name, i know.  but i'm porting this over asap into code igniter
	function users_functions() 
	{
		if ($_REQUEST['f'] == 'create') {
    		$email = mysqli_real_escape_string($this->db->conn_id, $_REQUEST['email']);
    		$password = sha1($_REQUEST['password']);
            
			$user_object = $this->users_model->get_user_by_email($email);
    		if (is_array($user_object) && sizeof($user_object)>0) {
        		echo json_encode(array("Status"=>"EmailInUse","Message"=>"Email Address is already in use. Please login or use a different address."));
    		} else {
                $domain_arr = explode("@", $_REQUEST['email']);
                $domain = $domain_arr[1];
                $domain_object = $this->users_model->get_user_domain($domain);
                if (is_array($domain_object) && sizeof($domain_object)>0){
                    $randomCharacters = $this->createRandomWord(9);
                    $user_data = array(
                        'EMAIL' => $email,
                        'PASSWORD' => $password,
                        'VALIDATION' => $randomCharacters,
                        'FNAME' => '',
                        'LNAME' => ''
                    );
                    $user_id = $this->users_model->add_user($user_data);
                    $user_role_data = array(
                        'USER_ID' => $user_id,
                        'ROLE_ID' => 1
                    );
                    $this->users_model->add_user_roles($user_role_data);

                    $log_sql = "insert into users (email,password,validation) values ('".$email."','".$password."','".$randomCharacters."')";
                    $log_data = array(
                        'PAGE' => 'Create Account',
                        'PARAMETER' => $email,
                        'MESSAGE' => addslashes($log_sql)
                    );
                    $log_id = $this->users_model->add_log($log_data);
                    $linkURL = "http://".$_SERVER['HTTP_HOST']."/logon/user_validate/".htmlentities($email)."/".$randomCharacters;
                    if ($user_id && ($user_id > 0 || mysql_affected_rows($link) == 1)) {
                        echo json_encode(array("Status"=>"AccountAdded","Message"=>"Entry confirmed. Please look for an email to complete your account."));
                        $subject = "Your new account to CommunityConnect with LiteracyDecision.";
                        $message = "<p>Thank you for creating an account for CommunityConnect with LiteracyDecision.</p><p>To complete your registration, click on the link below or enter the following activation code on the account verification page to confirm your account and begin using CommunityConnect with LiteracyDecision.</p><p><a href='$linkURL'>$linkURL</a></p><p>If clicking doesn't seem to work, you can copy and paste the link into your browser's address window, or retype it there. Once you have returned to CommunityConnect with LiteracyDecision, we will give instructions for resetting your password.</p><p>If you have any problems please contact Marc Futterman at <a href='mailto:maf@civictechnologies.com'>maf@civictechnologies.com</a> or if you need immediate assistance call toll free to (888) 606-7600.</p><p>Best,</p><p>CIVICTechnologies</p>";

                        /**
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: Community Connect <maf@civictechnologies.com>' . "\r\n";
                        $headers .= 'Bcc: z4ang@comcast.net' . "\r\n";
                        if (@mail($email, $subject, $message) === false ) {
                            echo "FALSE!!!!!";
                        }
                        **/
                        
                        $this->sendmail('support@civictechnologies.com', 'support@civictechnologies.com',$email, $subject, $message);
                    } else {
                        echo json_encode(array("Status"=>"ERROR","Message"=>"There was an error with the account creation process.  A support specialist has been notified.  To follow up with additional information please click <a href='mailto:maf@civictechnologies.com'>here</a>."));
                    }
                }else{
                    echo json_encode(array("Status"=>"DomainNotMatch","Message"=>"We are sorry, but your email does not match any authorized domains in our system. Please email <a href='mailto:maf@civictechnologies.com'>maf@civictechnologies.com</a> or call toll free (888) 606-7600 for assistance."));
                }
    		}
		}
        
		if ($_REQUEST['f'] == 'recover') {
    		$email = mysqli_real_escape_string($this->db->conn_id, $_REQUEST['email']);
			$user_object = $this->users_model->get_user_by_email($email);

    		if (is_array($user_object)) {
        		$randomCharacters = $this->createRandomWord(9);
				$user_data = array("TEMPPASS" => $randomCharacters);
				$this->users_model->update_user($user_object[0]->USER_ID, $user_data);
        		
                $linkURL = "http://".$_SERVER['HTTP_HOST']."/logon?email=".htmlentities($email)."&pr=".$randomCharacters;
        		$subject = "Community Connect Password Recovery";
        		$recoverMessage = "<p>Greetings from CommunityConnect with LiteracyDecision.</p><p>We received a request to reset the password associated with this e-mail address. If you made this request, please follow the instructions below.</p><p>If you did not request to have your password reset you can safely ignore this email. Rest assured your customer account is safe.</p><p>Click the link below to go to Step 3 to reset your password using our secure server:</p><p><a href='".$linkURL."' >".$linkURL."</a></p><p>If clicking doesn't seem to work, you can copy and paste the link into your browser's address window, or retype it there. Once you have returned to CommunityConnect with LiteracyDecision, we will give instructions for resetting your password.</p><p>Thank you!</p>";
       		    //@mail('wooleys@gmail.com',$subject,$recoverMessage);
                $this->sendmail('support@civictechnologies.com', 'support@civictechnologies.com',$email, $subject, $recoverMessage);
        		$userMessage = "<h4>Step 2: Check your Email</h4><br><br><p>If the e-mail address you entered <a href='$email' style='color:#036;'>$email</a> is associated with a customer account in our records, you will receive an e-email from us with instructions for resetting your password.</p><p>If you don't receive this e-mail, please check your junk mail folder or contact Marc Futterman at <a href='mailto:maf@civictechnologies.com' style='color:#036;'>maf@civictechnologies.com</a> or if you need immediate assistance call toll free to (888) 606-7600.</p>";
        		echo json_encode(array("status"=>"RecoverySent","message"=>$userMessage));
    		} else {
        		echo json_encode(array("status"=>"RecoveryNotSent","message"=>"That email address is not in our system. Please register for an account."));
    		}
		}

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

    function sendmail($myemail, $myname, $toemail, $subject, $message) {
        $config = Array(
                      'protocol' => 'smtp',
                      'smtp_host' => 'ssl://smtp.gmail.com',
                      'smtp_port' => 465,
                      'smtp_user' => 'gg.portland88@gmail.com',
                      'smtp_pass' => 'huamei88',
                      'smtp_timeout' => 30);

        $config['mailtype'] = "html";
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->load->library('email',$config);
        $config['mailtype'] = "html";
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        $this->email->from($myemail, $myname);
        $this->email->to($toemail);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

}
?>
