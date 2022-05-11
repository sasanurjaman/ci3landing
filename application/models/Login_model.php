<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model 
{
	function data($u = null, $p = null)
	{
		$query = $this->db->query('SELECT userid, password, nama, level, aktif, foto, DATE_FORMAT(daftar, "%b %Y") AS daftar, DATE_FORMAT(lastlogin, "%d %b %Y %H:%i") AS login '.
        'FROM user WHERE userid = "'.$u.'" and password = "'.$p.'"');
		
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	
	function validation()
	{
		$this->form_validation->set_rules('txtusername', 'Nama', 'trim|required|xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtpassword', 'KataSandi', 'trim|required|xss_clean|prep_for_form');
		return $this->form_validation->run();
	}
}
/* End of file login_model.php */
/* Location: ./application/models/login_model.php */
