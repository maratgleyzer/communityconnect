<?php
    $check_uid = $this->session->userdata('uid');
    if (!$check_uid)
        header("Location:logon");
?>