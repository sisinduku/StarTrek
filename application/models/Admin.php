<?php

class Admin extends CI_Model{
	private $idAdmin, $username, $password, $privilege;
	
	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function getAdminbyUsername($username) {
	
		$result = $this->db->get_where('tbl_admin', array('username'=>$username), 1);
	
		$row = $result->row_array();
		return $row;
	}
	
	public function adminLogin() {
	
		$this->username = $this->input->post('username');
		$this->password = $this->input->post('password');
	
		if ($this->loginDB() == ""){
			return null;
		}else{
			$status = $this->loginLDAP();
			if ($status == ""){
				return null;
			}else{
				return $status;
			}
		} 
	}
	
	public function loginLDAP(){
		$ip_ldap="10.64.1.156";
		$lc = ldap_connect($ip_ldap);
			
		if(ldap_set_option($lc, LDAP_OPT_NETWORK_TIMEOUT, 2)){
			$r = @ldap_bind($lc,"$this->username","$this->password");
			if ($r)
			{
				$data = array('sessionType'=>1, 'id'=>$this->session->session_id, 'username'=>$this->username);
		
				$this->session->set_userdata($data);
		
				return null;
			}else{
				return "Username atau password salah. Pastikan ditulis dengan benar.";
			}
		}
		else{
			return "Tidak dapat terhubung dengan LDAP ip:".$ip_ldap." :(";
		}
	}
	
	public function loginDB(){
		$adminData = $this->getAdminbyUsername($this->username);
		if ($adminData != null) {
			// if password OK
			if ((crypt($this->password, $adminData['password'])) === $adminData['password']) {
				$data = array('sessionType'=>$adminData['privilege'], 'id'=>$adminData['idAdmin'], 'username'=>$adminData['username']);
		
				$this->session->set_userdata($data);
					
				return null;
			}
		}
		return "Username atau password salah. Pastikan ditulis dengan benar.";
	}
	
	public function adminLogout(){
		unset($_SESSION['id']);
		unset($_SESSION['sessionType']);
		unset($_SESSION['username']);
	}
}