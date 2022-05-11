<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Company_model extends CI_Model 
{
	function dataquery($where, $limit = null)
    {
        return $this->db->query('SELECT id, nama, moto, alamat, kota, kodepos, telepon, fax, email, logo FROM perusahaan '.$where.' '.$limit);
    }
    
    function dataid()
	{
		$query = $this->dataquery('WHERE id = "1"');
        
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	
    function dataid_array()
	{
		$query = $this->dataquery('WHERE id = "1"');
        
		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return false;
	}
    
	function validation()
	{
		$this->form_validation->set_rules('txtname', '`Nama`', 'trim|xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtmoto', '`Slogan`', 'trim|xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtaddress', '`Alamat`', 'xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtcity', '`Kota`', 'xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtposcode', '`KodePos`', 'xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtphone', '`Telepon`', 'xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtfax', '`Fax`', 'xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtemail', '`Email`', 'xss_clean|prep_for_form');
		return $this->form_validation->run();
	}
	
	function update()
	{
		if ($this->config->item('program_version') == 'demo' && $this->session->userdata('SESS_USER_LEVEL') != 'Admin')
        {
           return array(
                'logo' => '',
                'filename' => '',
                'title' => 'Gagal', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!', 
                'elfocus' => ''
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S1', 'edit') == 'Y') 
            {
                /*setting file*/
                $this->db->select_max('logo');
                $query = $this->db->get('perusahaan');
                $row = $query->row();
                $logo = ($query->num_rows() > 0 ? $row->logo : '-');
                
                if ($this->input->post('txtmp') != '') 
                {
                    $src_path = './tmp/'.$this->input->post('txtmp');
                    $ext = pathinfo($src_path, PATHINFO_EXTENSION);
                    $newname = 'logo-perusahaan.'.$ext;
                    $dst_path = './images/'.$newname;
                    
                    if ( file_exists($src_path) )
                    {
                        copy($src_path, $dst_path);
                        unlink( $src_path );
                        $logo = $newname;
                    }
                }
                
                if ($this->input->post('txtname') == '') 
                {
                    if (file_exists('./images/'.$logo))
                        unlink('images/'.$logo);
                    
                    $update = array(
                        'nama' => '-',
                        'moto' => '-',
                        'alamat' => '-',
                        'kota' => '-',
                        'kodepos' => '-',
                        'telepon' => '-',
                        'fax' => '-',
                        'email' => '-',
                        'logo' => '-'
                    );
                }
                else
                {
                    $update = array(
                        'nama' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : '-'), 
                        'moto' => ($this->input->post('txtmoto') != '' ? $this->input->post('txtmoto') : '-'), 
                        'alamat' => ($this->input->post('txtaddress') ? $this->input->post('txtaddress') : '-'), 
                        'kota' => ($this->input->post('txtcity') ? $this->input->post('txtcity') : '-'), 
                        'kodepos' => ($this->input->post('txtposcode') ? $this->input->post('txtposcode') : '-'), 
                        'telepon' => ($this->input->post('txtphone') ? $this->input->post('txtphone') : '-'), 
                        'fax' => ($this->input->post('txtfax') ? $this->input->post('txtfax') : '-'), 
                        'email' => ($this->input->post('txtemail') ? $this->input->post('txtemail') : '-'), 
                        'logo' => $logo
                    );
                }
                $this->db->where('id', '1');
                $this->db->update('perusahaan', $update);
                        
                return array(
                    'logo' => $logo,
                    'filename' => $this->input->post('txtname'),
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!', 
                    'elfocus' => '#txtname'
                );
            }
            else
            {
                return array(
                    'logo' => '',
                    'filename' => '',
                    'title' => 'Gagal', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!', 
                    'elfocus' => ''
                );
            }
        }
	}
}
/* End of file company_model.php */
/* Location: ./application/models/company_model.php */
