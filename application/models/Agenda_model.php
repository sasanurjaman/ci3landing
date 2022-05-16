<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agenda_model extends CI_Model 
{
	function datarun()
    {
        $query = $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d %b %Y") AS tanggal, waktu, kegiatan, keterangan '.
        'FROM agenda WHERE status = "Y"');
        
		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return false;
    }
    
    function dataquery($where, $limit = null)
    {
        return $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d-%m-%Y") AS tanggal, DATE_FORMAT(waktu, "%H:%m") AS waktu, '.
        'kegiatan, keterangan, status FROM agenda '.$where.' '.$limit);
    }
    
    function datalist($key, $pg, $dt)
	{
		$filterdata = array();
        if ($key != 'null')
            $filterdata[] = '(tanggal LIKE "%'.$key.'%" OR kegiatan LIKE "%'.$key.'%" OR keterangan LIKE "%'.$key.'%")';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY tanggal DESC LIMIT '.$pg.','.$dt;
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
            $filterdata[] = '(tanggal LIKE "%'.$key.'%" OR kegiatan LIKE "%'.$key.'%" OR keterangan LIKE "%'.$key.'%")';
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
		$this->form_validation->set_rules('txtevent', 'Kegiatan', 'trim|required|xss_clean|prep_for_form');
		return $this->form_validation->run();
	}
	
    function active($key)
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'edit') == 'Y') 
        {
            $this->db->select('status');
            $this->db->where('id', $key);
            $query = $this->db->get('agenda');
            $row = $query->row();
            $status = ($row->status == 'Y' ? 'N' : 'Y');
            
            $data = array(
                'status' => $status
            );
            $this->db->where('id', $key);
			$this->db->update('agenda', $data);
            
            return array('status' => $status);
        }
        else
        {
            return array('status' => 'N');
        }
	}	
	
	function insert()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'new') == 'Y')
        {
            $this->db->where('id', $this->input->post('txtid'));
            if ($this->db->count_all_results('agenda') == 0)
            {
                /*set id*/
                $this->db->select_max('id');
                $query = $this->db->get('agenda');
                $max = $query->row();
                $id = ($query->num_rows() > 0 ? $max->id+1 : 1);
                    
                $insert = array(
                    'id' => $id,
                    'tanggal' => ($this->input->post('txtdate') != '' ? date('Y-m-d', strtotime($this->input->post('txtdate'))) : null),
                    'waktu' => ($this->input->post('txtime') != '' ? date('H:m', strtotime($this->input->post('txtime'))) : null),
                    'kegiatan' => ($this->input->post('txtevent') != '' ? $this->input->post('txtevent') : null),
                    'keterangan' => ($this->input->post('txtnote') != '' ? $this->input->post('txtnote') : null),
                    'status' => 'Y'                    
                );
                $this->db->insert('agenda', $insert);
                
                return array(
                    'caption' => $this->input->post('caption'),
                    'search' => $this->input->post('search'),
                    'page' => $this->input->post('page'),
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil ditambahkan!', 
                    'elfocus' => '#txtdate'
                );
            }
            else
            {
                return array(
                    'caption' => $this->input->post('caption'),
                    'search' => $this->input->post('search'),
                    'page' => $this->input->post('page'),
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, data sudah ada!', 
                    'elfocus' => '#txtdate'
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
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'edit') == 'Y')
        {
            $update = array(
                'tanggal' => ($this->input->post('txtdate') != '' ? date('Y-m-d', strtotime($this->input->post('txtdate'))) : null),
                'waktu' => ($this->input->post('txtime') != '' ? date('H:m', strtotime($this->input->post('txtime'))) : null),
                'kegiatan' => ($this->input->post('txtevent') != '' ? $this->input->post('txtevent') : null),
                'keterangan' => ($this->input->post('txtnote') != '' ? $this->input->post('txtnote') : null)
            );
            $this->db->where('id', $this->input->post('txtid'));
            $this->db->update('agenda', $update);
            
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
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'delete') == 'Y')
        {
            /*delete kirim*/
            $this->db->where('id', $id);
            $this->db->delete('agenda');
                
            $n = $this->datacount($search);
            $page = ($page > 0 ? (ceil($n/$this->config->item('show_data'))-1)*$this->config->item('show_data') : $page);
                
            return array(
                'path' => base_url().'transactions/datagenda/'.$search.'/'.$page,
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
    
    function reportquery($where, $limit = null)
    {
        return $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d-%m-%Y") AS tanggal, DATE_FORMAT(waktu, "%H:%m") AS waktu, '.
        'kegiatan, keterangan, status FROM agenda '.$where.' '.$limit);
    }
    
    function reportlist($page, $data)
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'tanggal >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND tanggal <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY tanggal ASC LIMIT '.$page.','.$data;
		$query = $this->dataquery($where, $limit);
        
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
		$query = $this->dataquery($where);
        
		return $query->num_rows();
	}
    
    function reportprint()
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'tanggal >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND tanggal <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY tanggal ASC';
		$query = $this->dataquery($where, $limit);
        
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
/* End of file agenda_model.php */
/* Location: ./application/models/agenda_model.php */
