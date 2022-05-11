<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model 
{
	function dataquery($where, $limit = null)
    {
        return $this->db->query('SELECT p.id AS id, p.nomor AS nomor, DATE_FORMAT(p.tanggal, "%d %b %Y") AS tanggal, p.nominal AS nominal, '.
        'p.keterangan AS keterangan, p.setuju AS status, a.kode AS kode, a.nama AS nama, a.foto AS foto FROM pinjaman p, anggota a '.$where.' '.$limit);
    }
    
    function datacount($key)
    {
        $filterdata = array();
        $filterdata[] = "p.idanggota = a.id";
        if ($key != "null")
            $filterdata[] = "(p.nomor LIKE '%".$key."%' OR a.kode LIKE '%".$key."%' OR a.nama LIKE '%".$key."%')";
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $query = $this->dataquery($where);
        
        return $query->num_rows();
    }
    
    function datalist($key, $page, $data)
    {
        $filterdata = array();
        $filterdata[] = "p.idanggota = a.id";
        if ($key != "null")
            $filterdata[] = "(p.nomor LIKE '%".$key."%' OR a.kode LIKE '%".$key."%' OR a.nama LIKE '%".$key."%')";
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = "ORDER BY p.tanggal ASC LIMIT ".$page.",".$data;
        $query = $this->dataquery($where, $limit);
        
        if ($query->num_rows() > 0)
			return $query->result();
        else
            return array();
    }
    
    function dataid($id)
    {
        $filterdata = array();
        $filterdata[] = "p.idanggota = a.id";
        $filterdata[] = "a.id = '".$id."'";
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $query = $this->dataquery($where);
        
        if ($query->num_rows() > 0)
			return $query->row();
        else
            return false;
    }
    
    function dataprogress($id, $no)
    {
        $searchresult = array();
        
        /*search pengajuan*/
        $query = $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d %b %Y") as tanggal, keterangan, setuju AS status '.
        'FROM pinjaman WHERE idanggota = "'.$id.'" AND nomor = '.$no);
        
        if ($query->num_rows() > 0)
        {
			foreach($query->result() AS $row)
            {
                $searchresult[] = array(
                    'id' => $row->id,
                    'tanggal' => $row->tanggal,
                    'nomor' => $no,
                    'keterangan' => '[Pengajuan] '.$row->keterangan,
                    'status' => $row->status
                );
            }
        }   
        
        /*search pinjaman*/
        $query = $this->db->query('SELECT id, DATE_FORMAT(tanggal1, "%d %b %Y") as tanggal, keterangan1 AS keterangan, setuju AS status '.
        'FROM pinjaman WHERE idanggota = "'.$id.'" AND nomor = '.$no);
        
        if ($query->num_rows() > 0)
        {
			foreach($query->result() AS $row)
            {
                $searchresult[] = array(
                    'id' => $row->id,
                    'tanggal' => $row->tanggal,
                    'nomor' => $no,
                    'keterangan' => '[Persetujuan] '.$row->keterangan,
                    'status' => $row->status
                );
            }
        }
        
        /*search kirim*/
        $query = $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d %b %Y") as tanggal, keterangan, status '.
        'FROM kirim WHERE idanggota = "'.$id.'" AND nomor = '.$no);
        
        if ($query->num_rows() > 0)
        {
			foreach($query->result() AS $row)
            {
                $searchresult[] = array(
                    'id' => $row->id,
                    'tanggal' => $row->tanggal,
                    'nomor' => $no,
                    'keterangan' => '[Kirim Berkas] '.$row->keterangan,
                    'status' => $row->status
                );
            }
        }
        
        /*search terima*/
        $query = $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d %b %Y") as tanggal, keterangan, status '.
        'FROM terima WHERE idanggota = "'.$id.'" AND nomor = '.$no);
        
        if ($query->num_rows() > 0)
        {
			foreach($query->result() AS $row)
            {
                $searchresult[] = array(
                    'id' => $row->id,
                    'tanggal' => $row->tanggal,
                    'nomor' => $no,
                    'keterangan' => '[Terima Berkas] '.$row->keterangan,
                    'status' => $row->status
                );
            }
        }
        
        /*search transfer*/
        $query = $this->db->query('SELECT id, DATE_FORMAT(tanggal, "%d %b %Y") as tanggal, keterangan, status '.
        'FROM transfer WHERE idanggota = "'.$id.'" AND nomor = '.$no);
        
        if ($query->num_rows() > 0)
        {
			foreach($query->result() AS $row)
            {
                $searchresult[] = array(
                    'id' => $row->id,
                    'tanggal' => $row->tanggal,
                    'nomor' => $no,
                    'keterangan' => '[Transfer] '.$row->keterangan,
                    'status' => $row->status
                );
            }
        }
        
        return $searchresult;
    }
    
    function dataprofile()
	{
		$query = $this->db->query('SELECT u.userid as userid, u.nama as nama, u.level as level, u.foto as foto, '.
        'DATE_FORMAT(u.daftar, "%m/%d/%Y %H:%m:%s") as daftar, DATE_FORMAT(u.lastlogin, "%m/%d/%Y %H:%m:%s") as login FROM user u '.
        'WHERE u.userid = "'.$this->session->userdata('SESS_USER_ID').'"');
        
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
	
	function validation()
	{
		$this->form_validation->set_rules('txtusername', 'Username', 'trim|required');
		$this->form_validation->set_message('required', 'This field is required.');
		return $this->form_validation->run();
	}
	
	function updates()
	{
		//fill array data
		$data = array(
			'nama' => $this->input->post('txtusername'),			
			'jabatan' => $this->input->post('txtposition'),
			'divisi' => $this->input->post('txtdivision'),
			'lokasi' => $this->input->post('txtlocation')
		);
		
		$this->db->where('userid', $this->input->post('txtuserid'));
		$update = $this->db->update('user', $data);
		return $update;		
	}
	
}
/* End of file dashboard_model.php */
/* Location: ./application/models/dashboard_model.php */
