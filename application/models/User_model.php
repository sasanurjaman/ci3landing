<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class User_model extends CI_Model 
{
	function dataquery($where, $limit = null)
    {
        return $this->db->query('SELECT u.id as id, u.userid as userid, DATE_FORMAT(daftar, "%d %b %Y") AS tanggal, u.nama as nama, u.foto as foto, '.
        'u.level as level, u.aktif as aktif FROM user u '.$where.' '.$limit);
    }
    
    function datacount($key)
	{
		$filterdata = array();
        if ($key != 'null')
            $filterdata[] = 'u.userid like "%'.$key.'%" OR u.nama like "%'.$key.'%" OR u.level like "%'.$key.'%"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $query = $this->dataquery($where);
        
        return $query->num_rows();
	}
	
	function datalist($key, $pg, $dt)
	{
		$filterdata = array();
        if ($key != 'null')
            $filterdata[] = 'u.userid like "%'.$key.'%" OR u.nama like "%'.$key.'%" OR u.level like "%'.$key.'%"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY u.daftar DESC LIMIT '.$pg.','.$dt;
        $query = $this->dataquery($where, $limit);
        
        if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
	
	function dataid($id)
	{
		$query = $this->dataquery('WHERE u.id = "'.$id.'"');
		
        if ($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	
    function datacombo($key)
	{
		$filterdata = array();
        $itemdata = array();
        if ($key != 'null')
            $filterdata[] = 'u.userid like "%'.$key.'%" OR u.nama like "%'.$key.'%"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $query = $this->dataquery($where);
        
        if ($query->num_rows() > 0)
        {
			foreach($query->result() AS $row)
            {
                $itemdata[] = array('id' => $row->userid, 'text' => $row->nama);
            }
            return array('total_count' => $query->num_rows(), 'items' => $itemdata);
        }
		else
        {
			return false;
        }
	}
    
	function validation()
	{
		/*check max record*/
        if ($this->config->item('program_version') == 'demo' && $this->db->count_all_results('user') >= $this->config->item('show_data'))
        {
            $this->session->set_userdata("ERR_LIMIT", true);
            return false;
        }
        else
        {
            $this->form_validation->set_rules('txtuserid', '`ID Pengguna`', 'trim|required|xss_clean|prep_for_form');
            $this->form_validation->set_rules('txtname', '`Nama`', 'trim|required|xss_clean|prep_for_form');
            return $this->form_validation->run();
        }
	}
	
	function active($id)
	{
		if ($this->config->item('program_version') == 'demo' && $this->session->userdata('SESS_USER_LEVEL') != 'Admin')
        {
            return array(
                'status' => 'N',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!', 'elfocus' => ''
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y') 
            {
                $query = $this->db->query('SELECT aktif FROM user WHERE id = "'.$id.'"');
                $aktif = ($query->row()->aktif == "Y" ? "N" : "Y");
                    
                $update = array('aktif' => $aktif);
                $this->db->where('id', $id);
                $this->db->update('user', $update);
                
                return array(
                    'status' => $aktif,
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!', 'elfocus' => ''
                );
            }
            else
            {
                return array(
                    'status' => 'N',
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!', 'elfocus' => ''
                );
            }
        }
    }
    
    function reset($id)
	{
		if ($this->config->item('program_version') == 'demo' && $this->session->userdata('SESS_USER_LEVEL') != 'Admin')
        {
            return array(
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!', 'elfocus' => ''
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y') 
            {
                $update = array('password' => md5($id));
                $this->db->where('userid', $id);
                $this->db->update('user', $update);
                
                return array(
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!', 'elfocus' => ''
                );
            }
            else
            {
                return array(
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!', 'elfocus' => ''
                );
            }
        }
	}
	
	function insert()
	{
		if ($this->config->item('program_version') == 'demo' && $this->session->userdata('SESS_USER_LEVEL') != 'Admin')
        {
            return array(
                'caption' => $this->input->post('caption'),
                'page' => $this->input->post('page'),
                'search' => $this->input->post('search'),
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!', 'elfocus' => ''
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'new') == 'Y') 
            {
                $this->db->where('userid', $this->input->post('txtuserid'));
                if ($this->db->count_all_results('user') == 0) 
                {
                    /*get code*/
                    $this->db->select_max('id');
                    $query = $this->db->get('user');
                    $id = ($query->num_rows() > 0 ? $query->row()->id + 1 : 1);                    
                    
                    /*setting file*/
                    $this->db->select('foto');
                    $this->db->where('userid', $this->input->post('txtuserid'));
                    $query = $this->db->get('user');
                    $foto = ($query->num_rows() > 0 ? $query->row()->foto : '-');
                    
                    if ($this->input->post('txtmp') != '') 
                    {
                        $src_path = './tmp/'.$this->input->post('txtmp');
                        $ext = pathinfo($src_path, PATHINFO_EXTENSION);
                        $newname = $this->input->post('txtuserid').'.'.$ext;
                        $dst_path = './arsip/photo/'.$newname;
                        
                        if ( file_exists($src_path) )
                        {
                            copy($src_path, $dst_path);
                            unlink( $src_path );
                            $foto = $newname;
                        }
                    }
                    
                    $insert = array (
                        'id' => $id,
                        'userid' => ($this->input->post('txtuserid') != '' ? $this->input->post('txtuserid') : '-'),
                        'nama' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : '-'),
                        'foto' => $foto,
                        'daftar' => date('Y-m-d H:i:s'),
                        'password' => ($this->input->post('txtuserid') != '' ? md5($this->input->post('txtuserid')) : '-'),
                        'level' => ($this->input->post('txtlevel') != '' ? $this->input->post('txtlevel') : 'User'),
                        'aktif' => ($this->input->post('txtactive') == 'Y' ? 'Y' : 'N')
                    );
                    $this->db->insert('user', $insert);
                    
                    /*update data profile*/
                    $datainsert1 = array(
                        'userid' => ($this->input->post('txtuserid') != '' ? $this->input->post('txtuserid') : '-'),
                        'nama' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : '-'),
                        'foto' => $foto
                    );
                    $this->db->insert('profile', $datainsert1);
                    
                    /*Update Hak Akses User*/
                    if ($this->input->post('txtlevel') == 'Admin')
                    {
                        $update = array(
                            'S0' => 'Y|D|D|D|D', 'S1' => 'Y|D|Y|D|D', 'S2' => 'Y|Y|Y|Y|Y', 'S3' => 'Y|D|Y|D|D', 'S4' => 'Y|D|Y|D|D', 'S5' => 'Y|D|Y|D|D',
                            'T0' => 'Y|D|D|D|D', 'T1' => 'Y|Y|Y|Y|Y', 'T2' => 'Y|Y|Y|Y|Y',
                            'L0' => 'Y|D|D|D|D', 'L1' => 'Y|D|D|D|Y', 'L2' => 'Y|D|D|D|Y', 'L3' => 'Y|D|D|D|Y', 'L4' => 'Y|D|D|D|Y',
                            'L5' => 'Y|D|D|D|Y'
                        );
                    }
                    else
                    {
                        $update = array(
                            'S0' => 'Y|D|D|D|D', 'S1' => 'Y|D|N|D|D', 'S2' => 'N|N|N|N|N', 'S3' => 'Y|D|Y|D|D', 'S4' => 'N|D|N|D|D', 'S5' => 'N|D|N|D|D',
                            'T0' => 'Y|D|D|D|D', 'T1' => 'Y|Y|Y|N|Y', 'T2' => 'Y|Y|Y|N|Y',
                            'L0' => 'Y|D|D|D|D', 'L1' => 'Y|D|D|D|N', 'L2' => 'Y|D|D|D|N', 'L3' => 'Y|D|D|D|N', 'L4' => 'Y|D|D|D|N',
                            'L5' => 'Y|D|D|D|N'
                        );
                    }
                    $this->db->where('userid', $this->input->post('txtuserid'));
                    $this->db->update('user', $update);
                        
                    return array(
                        'caption' => $this->input->post('caption'),
                        'page' => $this->input->post('page'),
                        'search' => $this->input->post('search'),
                        'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!',
                        'elfocus' => '#txtuserid'
                    );
                }
                else
                {
                    return array(
                        'caption' => $this->input->post('caption'),
                        'page' => $this->input->post('page'),
                        'search' => $this->input->post('search'),
                        'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, data pengguna sudah ada!',
                        'elfocus' => '#txtuserid'
                    );
                }
            }
            else
            {
                return array(
                    'caption' => $this->input->post('caption'),
                    'page' => $this->input->post('page'),
                    'search' => $this->input->post('search'),
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!',
                    'elfocus' => '#txtuserid'
                );
            }
        }
	}
    
	function update()
	{
		if ($this->config->item('program_version') == 'demo' && $this->session->userdata('SESS_USER_LEVEL') != 'Admin')
        {
            return array(
                'caption' => $this->input->post('caption'),
                'page' => $this->input->post('page'),
                'search' => $this->input->post('search'),
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!', 'elfocus' => ''
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y') 
            {
                /*setting file*/
                $this->db->select('foto');
                $this->db->where('userid', $this->input->post('txtuserid'));
                $query = $this->db->get('user');
                $foto = ($query->num_rows() > 0 ? $query->row()->foto : '-');
                    
                if ($this->input->post('txtmp') != '') 
                {
                    $src_path = './tmp/'.$this->input->post('txtmp');
                    $ext = pathinfo($src_path, PATHINFO_EXTENSION);
                    $newname = $this->input->post('txtuserid').'.'.$ext;
                    $dst_path = './arsip/photo/'.$newname;
                        
                    if ( file_exists($src_path) )
                    {
                        copy($src_path, $dst_path);
                        unlink( $src_path );
                        $foto = $newname;
                    }
                }
                
                $update = array (
                    'nama' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : '-'),
                    'foto' => $foto,
                    'level' => ($this->input->post('txtlevel') != '' ? $this->input->post('txtlevel') : 'User'),
                    'aktif' => ($this->input->post('txtactive') == 'Y' ? 'Y' : 'N')
                );
                $this->db->where('id', $this->input->post('txtid'));
                $this->db->update('user', $update);
                
                /*update data profile*/
                $dataupdate1 = array(
                    'nama' => ($this->input->post('txtname') != '' ? $this->input->post('txtname') : '-'),
                    'foto' => $foto
                );
                $this->db->where('userid', $this->input->post('txtuserid'));
                $this->db->update('profile', $dataupdate1);
                
                /*Update Hak Akses User*/
                if ($this->input->post('txtlevel') == 'Admin')
                {
                    $update = array(
                        'S0' => 'Y|D|D|D|D', 'S1' => 'Y|D|Y|D|D', 'S2' => 'Y|Y|Y|Y|Y', 'S3' => 'Y|D|Y|D|D', 'S4' => 'Y|D|Y|D|D', 'S5' => 'Y|D|Y|D|D',
                        'T0' => 'Y|D|D|D|D', 'T1' => 'Y|Y|Y|Y|Y', 'T2' => 'Y|Y|Y|Y|Y',
                        'L0' => 'Y|D|D|D|D', 'L1' => 'Y|D|D|D|Y', 'L2' => 'Y|D|D|D|Y', 'L3' => 'Y|D|D|D|Y', 'L4' => 'Y|D|D|D|Y',
                        'L5' => 'Y|D|D|D|Y'
                    );
                }
                else
                {
                    $update = array(
                        'S0' => 'Y|D|D|D|D', 'S1' => 'Y|D|N|D|D', 'S2' => 'N|N|N|N|N', 'S3' => 'Y|D|Y|D|D', 'S4' => 'N|D|N|D|D', 'S5' => 'N|D|N|D|D',
                        'T0' => 'Y|D|D|D|D', 'T1' => 'Y|Y|Y|N|Y', 'T2' => 'Y|Y|Y|N|Y',
                        'L0' => 'Y|D|D|D|D', 'L1' => 'Y|D|D|D|N', 'L2' => 'Y|D|D|D|N', 'L3' => 'Y|D|D|D|N', 'L4' => 'Y|D|D|D|N',
                        'L5' => 'Y|D|D|D|N'
                    );
                }
                $this->db->where('userid', $this->input->post('txtuserid'));
                $this->db->update('user', $update);
                
                return array(
                    'caption' => $this->input->post('caption'),
                    'page' => $this->input->post('page'),
                    'search' => $this->input->post('search'),
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!', 'elfocus' => ''
                );
            }
            else
            {
                return array(
                    'caption' => $this->input->post('caption'),
                    'page' => $this->input->post('page'),
                    'search' => $this->input->post('search'),
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa akses!', 'elfocus' => ''
                );
            }
        }
	}

    function delete($search, $page, $id)
    {
		if ($this->config->item('program_version') == 'demo' && $this->session->userdata('SESS_USER_LEVEL') != 'Admin')
        {
            return array(
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, aplikasi ini merupakan versi percobaan!', 'elfocus' => ''
            );
        }
        else
        {
            if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'delete') == 'Y') 
            {
                $query = $this->db->query('SELECT foto FROM user WHERE id = "'.$id.'"');
                if ($query->row()->foto != 'nopicture.png' && file_exists('./arsip/photo/'.$query->row()->foto))
                    unlink('arsip/photo/'.$query->row()->foto);
                
                $this->db->where('id', $id);
                $this->db->delete('user');
                
                $n = $this->datacount($search);
                $page = ($page > 0 ? (ceil($n/$this->config->item('show_data'))-1)*$this->config->item('show_data') : $page);
                
                return array(
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => base_url().'settings/datauser/'.$search.'/'.$page, 'elfocus' => ''
                );
            }
            else
            {
                return array(
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa akses!', 'elfocus' => ''
                );
            }
        }
	}
	
    function reportquery($where, $limit = null)
    {
        return $this->db->query('SELECT userid, nama, level, aktif FROM user '.$where.' '.$limit);
    }
    
	function reportlist($page, $data)
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REPORT_NAME') != '') 
            $filterdata[] = 'username LIKE "%'.$this->session->userdata('SESS_REPORT_NAME').'%"';
        if ($this->session->userdata('SESS_REPORT_LEVEL') != '') 
            $filterdata[] = 'level = "'.$this->session->userdata('SESS_REPORT_LEVEL').'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY daftar ASC LIMIT '.$page.','.$data;
        $query = $this->reportquery($where, $limit);
        
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
	
    function reportcount()
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REPORT_NAME') != '') 
            $filterdata[] = 'username LIKE "%'.$this->session->userdata('SESS_REPORT_NAME').'%"';
        if ($this->session->userdata('SESS_REPORT_LEVEL') != '') 
            $filterdata[] = 'level = "'.$this->session->userdata('SESS_REPORT_LEVEL').'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $query = $this->reportquery($where);
        
		return $query->num_rows();
	}
    
    function reportprint()
	{
		$filterdata = array();
        if ($this->session->userdata('SESS_REPORT_NAME') != '') 
            $filterdata[] = 'username LIKE "%'.$this->session->userdata('SESS_REPORT_NAME').'%"';
        if ($this->session->userdata('SESS_REPORT_LEVEL') != '') 
            $filterdata[] = 'level = "'.$this->session->userdata('SESS_REPORT_LEVEL').'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $query = $this->reportquery($where);
        
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
    
    function remove_report_session()
    {
        $this->session->unset_userdata('SESS_REPORT_NAME');
        $this->session->unset_userdata('SESS_REPORT_LEVEL');
    }
    
    function create_report_session()
    {
        $this->session->set_userdata('SESS_REPORT_NAME', $this->input->post('txtname'));
        $this->session->set_userdata('SESS_REPORT_LEVEL', $this->input->post('txtlevel'));
    }
}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
