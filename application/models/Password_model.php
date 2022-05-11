<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Password_model extends CI_Model 
{
	function validation()
	{
		$this->form_validation->set_rules('txtpassword', 'Password', 'trim|required|xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtrepassword', 'RePassword', 'trim|required|xss_clean|prep_for_form');
		return $this->form_validation->run();
	}
	
	function update()
	{
		if ($this->config->item("program_version") == "demo" && $this->session->userdata("SESS_USER_LEVEL") != "Admin")
        {
            return array(
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!', 
                'elfocus' => ''
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S3', 'edit') == 'Y') //if:1
            {
                if (md5($this->input->post('txtpassword')) == md5($this->input->post('txtrepassword'))) //if:2
                {
                    $this->db->query('UPDATE user SET password = "'.md5($this->input->post('txtpassword')).'" '.
                    'WHERE userid = "'.$this->session->userdata('SESS_USER_ID').'"');
                    
                    return array(
                        'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!', 
                        'elfocus' => '#txtpassword'
                    );
                } 
                else 
                {
                    return array(
                        'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data katasandi tidak sama!', 
                        'elfocus' => '#txtpassword'
                    );
                } //endif:2
            }
            else
            {
                return array(
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!', 
                    'elfocus' => ''
                );
            }
        }
	}	
}
/* End of file pass_model.php */
/* Location: ./application/models/pass_model.php */
