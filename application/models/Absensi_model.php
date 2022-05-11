<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Absensi_model extends CI_Model 
{
	function datarun()
    {
        $query = $this->db->query('SELECT id, nama, jabatan, foto, status FROM absensi');
        
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
    }
    
    function dataquery($where, $limit = null)
    {
        return $this->db->query('SELECT id, nama, jabatan, foto, status FROM absensi '.$where.' '.$limit);
    }
    
    function datalist($key, $pg, $dt)
	{
		$filterdata = array();
        if ($key != 'null')
            $filterdata[] = '(nama LIKE "%'.$key.'%" OR jabatan LIKE "%'.$key.'%" OR status LIKE "%'.$key.'%")';            
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY id DESC LIMIT '.$pg.','.$dt;
		$query = $this->dataquery($where, $limit);
        
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
	
    function datacount($key)
	{
		$filterdata = array();
        if ($key != 'null')
            $filterdata[] = '(nama LIKE "%'.$key.'%" OR jabatan LIKE "%'.$key.'%" OR status LIKE "%'.$key.'%")';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
		$query = $this->dataquery($where);
        
		return $query->num_rows();
	}
    
	function dataid($id)
	{
		$query = $this->dataquery('WHERE id = "'.$id.'"');
        
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	
    function validation()
	{
		$this->form_validation->set_rules('txtname', 'Nama', 'trim|required|xss_clean|prep_for_form');
		$this->form_validation->set_rules('txtposition', 'Jabatan', 'trim|required|xss_clean|prep_for_form');
		return $this->form_validation->run();
	}
	
    function active($key)
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T4', 'edit') == 'Y') 
        {
            $this->db->select('status');
            $this->db->where('id', $key);
            $query = $this->db->get('absensi');
            $row = $query->row();
            $status = ($row->status == 'Y' ? 'N' : 'Y');
            
            $data = array(
                'status' => $status
            );
            $this->db->where('id', $key);
			$this->db->update('absensi', $data);
            
            return array('status' => $status);
        }
        else
        {
            return array('status' => 'N');
        }
	}	
	
	function insert()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T4', 'new') == 'Y')
        {
            $this->db->where('id', $this->input->post('txtid'));
            if ($this->db->count_all_results('absensi') == 0)
            {
                /*setting file*/
                if ($this->input->post("txtmp") != "") 
                {
                    $files = explode(".", $this->input->post("txtmp"));
                    $filename = str_replace( $this->session->userdata('SESS_USER_ID')."-", "", $this->input->post("txtmp"));
                    $src_path = "tmp/".$this->input->post("txtmp");
                    $dst_path = "arsip/photo/".$filename;
                    
                    if ( file_exists($src_path) )
                    {
                        copy($src_path, $dst_path);
                        unlink( $src_path );
                        $foto = $filename;
                    }
                    else
                    {
                        $this->db->select("foto");
                        $this->db->where("id", $this->input->post("txtid"));
                        $query = $this->db->get("absensi");
                        $row = $query->row();
                        $foto = ($query->num_rows() > 0 ? ($row->foto != "nopicture.png" ? $row->foto : "nopicture.png") : "nopicture.png");
                    }
                }
                else
                {
                    $this->db->select("foto");
                    $this->db->where("id", $this->input->post("txtid"));
                    $query = $this->db->get("absensi");
                    $row = $query->row();
                    $foto = ($query->num_rows() > 0 ? ($row->foto != "nopicture.png" ? $row->foto : "nopicture.png") : "nopicture.png");
                }
                
                /*set id*/
                $this->db->select_max('id');
                $query = $this->db->get('absensi');
                $max = $query->row();
                $id = ($query->num_rows() > 0 ? $max->id+1 : 1);
                    
                $insert = array(
                    'id' => $id,
                    'nama' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : null),
                    'jabatan' => ($this->input->post('txtposition') != '' ? $this->input->post('txtposition') : null),
                    'foto' => $foto,
                    'status' => 'Y'
                );
                $this->db->insert('absensi', $insert);
                
                return array(
                    'caption' => $this->input->post('caption'),
                    'search' => $this->input->post('search'),
                    'page' => $this->input->post('page'),
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil ditambahkan!', 
                    'elfocus' => '#txtname'
                );
            }
            else
            {
                return array(
                    'caption' => $this->input->post('caption'),
                    'search' => $this->input->post('search'),
                    'page' => $this->input->post('page'),
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, data sudah ada!', 
                    'elfocus' => '#txtname'
                );
            }
        }
        else
        {
            return array(
                'caption' => $this->input->post('caption'),
                'search' => $this->input->post('search'),
                'page' => $this->input->post('page'),
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa di akses!', 
                'elfocus' => ''
            );
        }
	}

	function update()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T4', 'edit') == 'Y')
        {
            /*setting file*/
            if ($this->input->post("txtmp") != "") 
            {
                $files = explode(".", $this->input->post("txtmp"));
                $filename = str_replace( $this->session->userdata('SESS_USER_ID')."-", "", $this->input->post("txtmp"));
                $src_path = "tmp/".$this->input->post("txtmp");
                $dst_path = "arsip/photo/".$filename;
                    
                if ( file_exists($src_path) )
                {
                    copy($src_path, $dst_path);
                    unlink( $src_path );
                    $foto = $filename;
                }
                else
                {
                    $this->db->select("foto");
                    $this->db->where("id", $this->input->post("txtid"));
                    $query = $this->db->get("absensi");
                    $row = $query->row();
                    $foto = ($query->num_rows() > 0 ? ($row->foto != "nopicture.png" ? $row->foto : "nopicture.png") : "nopicture.png");
                }
            }
            else
            {
                $this->db->select("foto");
                $this->db->where("id", $this->input->post("txtid"));
                $query = $this->db->get("absensi");
                $row = $query->row();
                $foto = ($query->num_rows() > 0 ? ($row->foto != "nopicture.png" ? $row->foto : "nopicture.png") : "nopicture.png");
            }
                
            $update = array(
                'nama' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : null),
                'jabatan' => ($this->input->post('txtposition') != '' ? $this->input->post('txtposition') : null),
                'foto' => $foto
            );
            $this->db->where('id', $this->input->post('txtid'));
            $this->db->update('absensi', $update);
            
            return array(
                'caption' => $this->input->post('caption'),
                'search' => $this->input->post('search'),
                'page' => $this->input->post('page'),
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!', 
                'elfocus' => ''
            );
        }
        else
        {
            return array(
                'caption' => $this->input->post('caption'),
                'search' => $this->input->post('search'),
                'page' => $this->input->post('page'),
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa di akses!', 
                'elfocus' => ''
            );
        }
	}
	
	function delete($search, $page, $id)
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T4', 'delete') == 'Y')
        {
            /*delete kirim*/
            $this->db->where('id', $id);
            $this->db->delete('absensi');
                
            $n = $this->datacount($search);
            $page = ($page > 0 ? (ceil($n/$this->config->item('show_data'))-1)*$this->config->item('show_data') : $page);
                
            return array(
                'path' => base_url().'index.php/transactions/databsensi/'.$search.'/'.$page,
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil dihapus!', 
                'elfocus' => ''
            );
        }
        else
        {
            return array(
                'path' => '',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!', 
                'elfocus' => ''
            );
        }
	}
}
/* End of file absensi_model.php */
/* Location: ./application/models/absensi_model.php */
