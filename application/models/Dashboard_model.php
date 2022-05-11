<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model 
{
	function datauser()
	{
		$query = $this->db->query('SELECT u.userid as userid, u.nama as nama, p.alias AS alias, DATE_FORMAT(u.daftar, "%d-%m-%Y %H:%i") AS daftar, '.
        'DATE_FORMAT(u.lastlogin, "%d-%m-%Y %H:%i") AS login, p.tmplahir AS tmplahir, DATE_FORMAT(p.tglahir, "%d-%m-%Y") AS tglahir, '.
        'p.kelamin AS kelamin, p.status AS status, p.tmptinggal AS tmptinggal, p.selular AS selular, p.email AS email, p.website AS website, '.
        'p.facebook AS facebook, p.twitter AS twitter, p.foto AS foto, p.keterangan AS keterangan '.
        'FROM user u, profile p WHERE u.userid = p.userid AND u.userid = "'.$this->session->userdata('SESS_USER_ID').'"');
		
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return false;
	}
    
    function dataction() 
    {
        $filterdata = array();
        if ($this->session->userdata('SESS_USER_ID') != 'admin')
            $filterdata[] = 'pengguna = "'.$this->session->userdata('SESS_USER_ID').'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
        $limit = 'ORDER BY waktu DESC LIMIT 0,10';
        
        $query = $this->db->query('SELECT pengguna, DATE_FORMAT(waktu, "%d-%m-%Y") AS tanggal, DATE_FORMAT(waktu, "%H:%i") AS jam, simbol, keterangan, alamat '.
        'FROM aktifitas '.$where.' '.$limit);
        
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }
    
    function datacount1()
    {
        return $this->db->count_all_results('berita');
    }
    
    function datacount2()
    {
        return $this->db->count_all_results('video');
    }
    
    function datacount3()
    {
        return $this->db->count_all_results('agenda');
    }
    
    function datacount4()
    {
        return $this->db->count_all_results('absensi');
    }
    
    function datalog()
    {
        $this->db->select('DATE_FORMAT(waktu, "%d %b %Y %H:%m") AS tanggal, keterangan');
        $this->db->where('pengguna', $this->session->userdata('SESS_USER_ID'));
        $this->db->where('year(waktu)', date('Y'));
        $this->db->where('month(waktu)', date('m'));
        $this->db->where('day(waktu)', date('d'));
        $this->db->order_by('waktu', 'desc'); 
        $this->db->limit('7');
        $query = $this->db->get('aktifitas');
        
        if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
    }
    
    function datachart()
    {
        $datachart = array();
        
        $query1 = $this->db->query('SELECT DATE_FORMAT(tanggal, "%Y-%m") AS bulan, count(*) AS jumlah FROM berita GROUP BY DATE_FORMAT(tanggal, "%Y-%m") ORDER BY tanggal ASC');
        if ($query1->num_rows() > 0)
        {
            foreach($query1->result() AS $row)
            {
                $datachart[] = array('y' => $row->bulan, 'item1' => $row->jumlah, 'item2' => '0', 'item3' => '0');
            }
        }
        
        $query2 = $this->db->query('SELECT DATE_FORMAT(tanggal, "%Y-%m") AS bulan, count(*) AS jumlah FROM video GROUP BY DATE_FORMAT(tanggal, "%Y-%m") ORDER BY tanggal ASC');
        if ($query2->num_rows() > 0)
        {
            foreach($query2->result() AS $row)
            {
                $key = array_search($row->bulan, $datachart);
                if ($key > -1)
                    $datachart[$key]['item2'] = $row->jumlah;
                else
                    $datachart[] = array('y' => $row->bulan, 'item1' => '0', 'item2' => $row->jumlah, 'item3' => '0');
            }
        }
        
        $query3 = $this->db->query('SELECT DATE_FORMAT(tanggal, "%Y-%m") AS bulan, count(*) AS jumlah FROM agenda GROUP BY DATE_FORMAT(tanggal, "%Y-%m") ORDER BY tanggal ASC');
        if ($query3->num_rows() > 0)
        {
            foreach($query3->result() AS $row)
            {
                $key = array_search($row->bulan, $datachart);
                if ($key > -1)
                    $datachart[$key]['item3'] = $row->jumlah;
                else
                    $datachart[] = array('y' => $row->bulan, 'item1' => '0', 'item2' => '0', 'item3' => $row->jumlah);
            }
        }
        
        return json_encode($datachart);
    }
    
    function validation()
	{
		$this->form_validation->set_rules('txtusername', 'Username', 'trim|required');
		return $this->form_validation->run();
	}
	
    function validation_import()
	{
		$this->form_validation->set_rules('txtdate', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('txtnumber', 'No. Penerbangan', 'trim|required');
        $this->form_validation->set_rules('txtairline', 'Maskapai', 'trim|required');
		return $this->form_validation->run();
	}
    
	function updateuser()
	{
		$data = array(
			'nama' => ($this->input->post('txtusername') ? $this->input->post('txtusername') : '-'),			
			'jabatan' => ($this->input->post('txtjabatan') ? $this->input->post('txtjabatan') : 0),
			'satker' => ($this->input->post('txtsatker') ? $this->input->post('txtsatker') : 0),
            'unit' => ($this->input->post('txtkodeunit') ? $this->input->post('txtkodeunit') : null),
            'subunit' => ($this->input->post('txtkodebagian') ? $this->input->post('txtkodebagian') : null),
            'subsubunit' => ($this->input->post('txtkodesubagian') ? $this->input->post('txtkodesubagian') : null),
			'lokasi' => ($this->input->post('txtlocation') ? $this->input->post('txtlocation') : 'pusat')
		);
		
		$this->db->where('userid', $this->input->post('txtuserid'));
		$this->db->update('user', $data);
		return true;		
	}
    
    function datatensi($pg, $dt)
	{
		$filterdata = array();
        $filterdata[] = 'p.warganegara = n.kode2';
        $filterdata[] = 'p.status = "Y"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata).' ' : null);
        
		$query = $this->db->query('SELECT p.id AS id, p.nama AS nama, DATE_FORMAT(p.tglahir, "%d %M %Y") AS tglahir, kelamin, '.
        'p.nopaspor AS nopaspor, DATE_FORMAT(p.tglkadaluarsa, "%d %M %Y") AS tglkadaluarsa, n.nama AS warganegara '.
        'FROM penumpang p, negara n '.$where.' LIMIT '.$pg.','.$dt);
        
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
    
    function checkatensi($id)
	{
		$query = $this->db->query('UPDATE penumpang SET status = "N" WHERE id = "'.$id.'"');
        
		return true;		
	}
    
    function datatensid($id = null)
	{
		$query = $this->db->query('SELECT id, kode, nama, kelamin, DATE_FORMAT(tglahir, "%m/%d/%Y") AS tglahir, warganegara, tinggal, '.
        'wl, cek, sb, jenisberkas, nopaspor, DATE_FORMAT(tglkadaluarsa, "%m/%d/%Y") AS tglkadaluarsa, negara, maskapai, noterbang, '.
        'DATE_FORMAT(tglterbang, "%m/%d/%Y") AS tglterbang, asal, tujuan, nobagasi, petugas, berat, kelastarif, noantri, '.
        'DATE_FORMAT(tglpesan, "%m/%d/%Y") AS tglpesan, nokursi, cdst, DATE_FORMAT(tglperiksa, "%m/%d/%Y") AS tglperiksa, foto '.
        'FROM penumpang WHERE id = "'.$id.'"');
        
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}
    
    function datatmp($pg, $dt)
	{
		$filterdata = array();
        $filterdata[] = 'p.warganegara = n.kode2';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata).' ' : null);
        
		$query = $this->db->query('SELECT p.id AS id, p.nama AS nama, DATE_FORMAT(p.tglahir, "%d %M %Y") AS tglahir, kelamin, '.
        'p.nopaspor AS nopaspor, DATE_FORMAT(p.tglkadaluarsa, "%d %M %Y") AS tglkadaluarsa, n.nama AS warganegara '.
        'FROM tmp_penumpang p, negara n '.$where.' LIMIT '.$pg.','.$dt);
        
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
}

/* End of file dashboard_model.php */
/* Location: ./application/models/dashboard_model.php */