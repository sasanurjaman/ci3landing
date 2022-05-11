<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Video_model extends CI_Model 
{
	function dataquery($where, $limit = null)
    {
        return $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d-%m-%Y") AS tanggal, judul, video, status FROM video '.$where.' '.$limit);
    }
    
    function datalist($key, $pg, $dt)
	{
		$filterdata = array();
        if ($key != 'null')
            $filterdata[] = 'name LIKE "%'.$key.'%"';
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
            $filterdata[] = 'name LIKE "%'.$key.'%"';
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
        {
			foreach($query->result() AS $row)
            {
                $videolist[] = array(
                    'mediaid' => $row->id,
                    'title' => $row->judul,
                    'file' => base_url().'arsip/video/'.$row->video,
                    'image' => base_url().'images/smpte-color.jpg'
                );
            }
            return json_encode($videolist);
        }
		else
        {
			return json_encode(array());
        }
    }
    
	function validation()
	{
		$this->form_validation->set_rules('txtname', 'Nama', 'trim|required|xss_clean|prep_for_form');
        return $this->form_validation->run();
	}
    
    function active($key)
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T2', 'edit') == 'Y') 
        {
            $this->db->update('video', array('status' => 'N'));
            
            $this->db->select('status');
            $this->db->where('id', $key);
            $query = $this->db->get('video');
            $status = ($query->row()->status == 'Y' ? 'N' : 'Y');
            $this->db->where('id', $key);
			$this->db->update('video', array('status' => $status));
            
            return array('status' => $status);
        }
        else
        {
            return array('status' => 'N');
        }
	}
    
	function insert()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T2', 'new') == 'Y')
        {
            $this->db->where('id', $this->input->post('txtid'));
            if ($this->db->count_all_results('video') == 0)
            {
                /*setting video*/
                if ($_FILES['txtfile']['name'] != '') 
                {
                    $base_path = './arsip/video/';
                    $filename = $_FILES['txtfile']['name'];
                    $ext = pathinfo($base_path.$filename, PATHINFO_EXTENSION);
                    $newname = date('YmdHis').'.'.$ext;
                    $config['upload_path'] = $base_path;
                    $config['file_name'] = $newname;
                    $config['upload_path'] = $base_path;
                    $config['allowed_types'] = (getCompany()->format != '-' ? getCompany()->format : 'bmp|gif|jpg|png');
                    $config['max_size'] = (getCompany()->ukuran > 0 ? getCompany()->ukuran : 0);
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('txtfile'))
                    {
                        $video = $newname;
                    }
                    else
                    {
                        return array(
                            'filename' => $_FILES['txtfile']['name'],
                            'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => $this->upload->display_errors(), 'elfocus' => ''
                        );
                        exit;
                    }
                }
                else
                {
                    $this->db->select('video');
                    $this->db->where('id', $this->input->post('txtid'));
                    $query = $this->db->get('video');
                    $row = $query->row();
                    $video = ($query->num_rows() > 0 ? ($row->video != '' ? $row->video : '') : '');
                }
                
                /*set id*/
                $this->db->select_max('id');
                $query = $this->db->get('video');
                $id = ($query->num_rows() > 0 ? $query->row()->id+1 : 1);
                    
                $insert = array(
                    'id' => $id,
                    'tanggal' => date('Y-m-d'),
                    'judul' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : '-'),
                    'video' => $video,
                    'status' => 'Y'
                );
                $this->db->insert('video', $insert);
                
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
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T2', 'edit') == 'Y')
        {
            /*setting video*/
            if ($_FILES['txtfile']['name'] != '') 
            {
                $base_path = './arsip/video/';
                $filename = $_FILES['txtfile']['name'];
                $ext = pathinfo($base_path.$filename, PATHINFO_EXTENSION);
                $newname = date('YmdHis').'.'.$ext;
                $config['upload_path'] = $base_path;
                $config['file_name'] = $newname;
                $config['allowed_types'] = (getCompany()->format != '-' ? getCompany()->format : 'bmp|gif|jpg|png');
                $config['max_size'] = (getCompany()->ukuran > 0 ? getCompany()->ukuran : 0);
                $this->upload->initialize($config);
                    
                if ($this->upload->do_upload('txtfile'))
                {
                    $video = $newname;
                }
                else
                {
                    return array(
                        'filename' => $_FILES['txtfile']['name'],
                        'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => $this->upload->display_errors(), 'elfocus' => ''
                    );
                    exit;
                }
            }
            else
            {
                $this->db->select('video');
                $this->db->where('id', $this->input->post('txtid'));
                $query = $this->db->get('video');
                $row = $query->row();
                $video = ($query->num_rows() > 0 ? ($row->video != '' ? $row->video : '') : '');
            }
            
            $update = array(
                'judul' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : '-'),
                'video' => $video
            );
            $this->db->where('id', $this->input->post('txtid'));
            $this->db->update('video', $update);
            
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
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'T2', 'delete') == 'Y')
        {
            $this->db->where('id', $id);
            $this->db->delete('video');
                
            $n = $this->datacount($search);
            $page = ($page > 0 ? (ceil($n/$this->config->item('show_data'))-1)*$this->config->item('show_data') : $page);
                
            return array(
                'path' => base_url().'transactions/datavideo/'.$search.'/'.$page,
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
        return $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d-%m-%Y") AS tanggal, judul, video, status FROM video '.$where.' '.$limit);
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
/* End of file video_model.php */
/* Location: ./application/models/video_model.php */