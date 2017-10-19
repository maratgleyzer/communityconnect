<?php 
class Users_model extends Model {
	function Users_model ()
	{
		parent::Model();
	}

	function get_user_by_email($email) 
	{
		$this->db->select('*')->from("users");
		$this->db->where("EMAIL", $email);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get_all_users() {
		$this->db->select('*')->from("users");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get_user_by_email_password($email, $password) 
	{
        $sql = "select u.*, ur.ROLE_ID from users u left join users_roles ur on u.USER_ID=ur.USER_ID where u.EMAIL='".$email."' and u.PASSWORD='".$password."'";
        $query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

    function get_user_by_email_validate($email, $validate) 
	{
		$this->db->select('*')->from("users");
		$this->db->where("EMAIL", $email);
		$this->db->where("VALIDATION", $validate);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function add_user($data) 
	{
		$this->db->set($data);
		$this->db->insert("users");
		return $this->db->insert_id();
	}

    function add_log($data) 
	{
		$this->db->set($data);
		$this->db->insert("error");
		return $this->db->insert_id();
	}


	function update_user($user_id, $data) 
	{
		$this->db->where('USER_ID', $user_id);
		$this->db->update('users', $data);
	}

	function update_user_by_email($email, $data) 
	{
        $this->db->where('EMAIL', $email);
        $this->db->update('users', $data);
	}

    function get_study_areas() 
    {
        $this->db->select('*')->from("area");
        $this->db->where_not_in('AREA', "zzz-unknown");
        $this->db->order_by("AREA_ID", 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function get_user_by_ID($user_id) 
    {
        $this->db->select('*')->from("users");
        $this->db->where("USER_ID", $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function validate_password($user_id, $password) 
    {
        $this->db->select('*')->from("users");
        $this->db->where("USER_ID", $user_id);
        $this->db->where("PASSWORD", $password);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_user_roles($data) 
    {
        $this->db->set($data);
        $this->db->insert("users_roles");
    }

    function get_user_domain($domain){
        $this->db->select('*')->from("domain");
        $this->db->where("DOMAIN", $domain);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
