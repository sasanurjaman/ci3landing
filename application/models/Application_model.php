<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Application_model extends CI_Model 
{
	function dataid()
	{
		$query = $this->db->query('SELECT id, `format`, ukuran, autorefresh, bataswaktu, kertas, orentasi, margin FROM perusahaan WHERE id = "1"');
        
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	
    function validation()
	{
		$this->form_validation->set_rules('txtformat', '`Format`', 'xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtsize', '`Ukuran`', 'xss_clean|prep_for_form');
		return $this->form_validation->run();
	}
    
	function update()
	{
		if ($this->config->item('program_version') == 'demo' && $this->session->userdata('SESS_USER_LEVEL') != 'Admin')
        {
            return array(
                'caption' => $this->input->post('caption'),
                'page' => $this->input->post('page'),
                'search' => $this->input->post('search'),
                'title' => 'Kesalahan', 'notif' => 'error', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!'
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S5', 'edit') == 'Y') 
            {
                $top = ($this->input->post('txtop') != '' ? $this->input->post('txtop') : 0);
                $bottom = ($this->input->post('txtbottom') != '' ? $this->input->post('txtbottom') : 0);
                $left = ($this->input->post('txtleft') != '' ? $this->input->post('txtleft') : 0);
                $right = ($this->input->post('txtright') != '' ? $this->input->post('txtright') : 0);
                $margins = $top.'|'.$bottom.'|'.$left.'|'.$right;

                $update = array(
                    'format' => ($this->input->post('txtformat') != '' ? $this->input->post('txtformat') : 'bmp|jpg|png|gif'),
                    'ukuran' => ($this->input->post('txtsize') != '' ? $this->input->post('txtsize') : '2048'),
                    'kertas' => ($this->input->post('txtpaper') != '' ? $this->input->post('txtpaper') : 'letter'),
                    'orentasi' => ($this->input->post('txtorient') != '' ? $this->input->post('txtorient') : 'landscape'),
                    'margin' => $margins
                );
                $this->db->where('id', 1);
                $this->db->update('perusahaan', $update);
                
                return array(
                    'caption' => $this->input->post('caption'),
                    'page' => $this->input->post('page'),
                    'search' => $this->input->post('search'),
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!', 
                    'elfocus' => ''
                );
            }
            else
            {
                return array(
                    'caption' => $this->input->post('caption'),
                    'page' => $this->input->post('page'),
                    'search' => $this->input->post('search'),
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!', 
                    'elfocus' => ''
                );
            }
        }	
	}
}

/* End of file application_model.php */
/* Location: ./application/models/application_model.php */