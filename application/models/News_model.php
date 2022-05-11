<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends CI_Model 
{
	function dataquery($where, $limit = null)
    {
        return $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d-%m-%Y") AS tanggal, judul, isi, DATE_FORMAT(berakhir, "%d-%m-%Y") AS akhir, status '.
        'FROM berita '.$where.' '.$limit);
    }
    
    function datalist($key, $pg, $dt)
	{
		$filterdata = array();
        if ($key != 'null')
            $filterdata[] = '(judul LIKE "%'.$key.'%" OR isi LIKE "%'.$key.'%")';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY tanggal LIMIT '.$pg.','.$dt;
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
            $filterdata[] = '(judul LIKE "%'.$key.'%" OR isi LIKE "%'.$key.'%")';
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
	
    function datarun()
    {
        $filterdata = array();
        $filterdata[] = 'status = "Y"'; 
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY tanggal DESC LIMIT 0,10';
        $query = $this->dataquery($where, $limit);
        
        if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return false;
    }
    
	function validation()
	{
		$this->form_validation->set_rules('txtitle', 'Judul', 'trim|required|xss_clean|prep_for_form');
        return $this->form_validation->run();
	}
    
    function active($key)
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T1', 'edit') == 'Y') 
        {
            $this->db->select('status');
            $this->db->where('id', $key);
            $query = $this->db->get('berita');
            $row = $query->row();
            $status = ($row->setuju == 'Y' ? 'N' : 'Y');
            
            $data = array(
                'status' => $status
            );
            $this->db->where('id', $key);
			$this->db->update('berita', $data);
            
            return array('status' => $status);
        }
        else
        {
            return array('status' => 'N');
        }
	}
    
	function insert()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T1', 'new') == 'Y')
        {
            $this->db->where('id', $this->input->post('txtid'));
            if ($this->db->count_all_results('berita') == 0)
            {
                /*set id*/
                $this->db->select_max('id');
                $query = $this->db->get('berita');
                $max = $query->row();
                $id = ($query->num_rows() > 0 ? $max->id+1 : 1);
                    
                $insert = array(
                    'id' => $id,
                    'tanggal' => date('Y-m-d'),
                    'judul' => ($this->input->post('txtitle') != '' ? $this->input->post('txtitle') : '-'),
                    'isi' => ($this->input->post('txtcontent') != '' ? $this->input->post('txtcontent') : '-'),
                    'berakhir' => ($this->input->post('txteod') != '' ? $this->input->post('txteod') : '0000-00-00'),
                    'status' => 'Y'
                );
                $this->db->insert('berita', $insert);
                
                return array(
                    'caption' => $this->input->post('caption'),
                    'search' => $this->input->post('search'),
                    'page' => $this->input->post('page'),
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil ditambahkan!', 
                    'elfocus' => '#txtitle'
                );
            }
            else
            {
                return array(
                    'caption' => $this->input->post('caption'),
                    'search' => $this->input->post('search'),
                    'page' => $this->input->post('page'),
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, data sudah ada!', 
                    'elfocus' => '#txtitle'
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
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T1', 'edit') == 'Y')
        {
            $update = array(
                'judul' => ($this->input->post('txtitle') != '' ? $this->input->post('txtitle') : '-'),
                'isi' => ($this->input->post('txtcontent') != '' ? $this->input->post('txtcontent') : '-'),
                'berakhir' => ($this->input->post('txteod') != '' ? $this->input->post('txteod') : null)
            );
            $this->db->where('id', $this->input->post('txtid'));
            $this->db->update('berita', $update);
            
            return array(
                'caption' => $this->input->post('caption'),
                'search' => $this->input->post('search'),
                'page' => $this->input->post('page'),
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data was berhasil diperbaharui!', 
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
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T1', 'delete') == 'Y')
        {
            $this->db->where('id', $id);
            $this->db->delete('berita');
                
            $n = $this->datacount($search);
            $page = ($page > 0 ? (ceil($n/$this->config->item('show_data'))-1)*$this->config->item('show_data') : $page);
                
            return array(
                'path' => base_url().'index.php/transactions/datanews/'.$search.'/'.$page,
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil dihapus!', 
                'elfocus' => ''
            );
        }
        else
        {
            return array(
                'path' => '',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa di akses!', 
                'elfocus' => ''
            );
        }
	}
    
    function reportquery($where, $limit = null)
    {
        return $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d-%m-%Y") AS tanggal, judul, DATE_FORMAT(berakhir, "%d-%m-%Y") AS akhir, status '.
        'FROM berita '.$where.' '.$limit);
    }
    
    function reportlist($page, $data)
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'tanggal >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND tanggal <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY tanggal ASC LIMIT '.$page.','.$data;
		$query = $this->reportquery($where, $limit);
        
        if ($query->num_rows() > 0)        
			return $query->result();
		else
			return false;
	}
	
    function reportcount()
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'tanggal >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND tanggal <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $query = $this->reportquery($where);
        
		return $query->num_rows();
	}
    
    function reportprint()
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'tanggal >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND tanggal <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY tanggal ASC';
		$query = $this->reportquery($where, $limit);
        
        if ($query->num_rows() > 0)        
			return $query->result();
		else
			return false;
	}
    
    function create_session_report()
    {
        $this->session->set_userdata('SESS_REP_DATE1', $this->input->post('txtdate1'));
        $this->session->set_userdata('SESS_REP_DATE2', $this->input->post('txtdate2'));
    }
    
    function remove_session_report()
    {
        $this->session->unset_userdata('SESS_REP_DATE1');
        $this->session->unset_userdata('SESS_REP_DATE2');
    }
}
/* End of file news_model.php */
/* Location: ./application/models/news_model.php */