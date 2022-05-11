<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Activities_model extends CI_Model 
{
	function reportquery($where, $limit = null)
    {
        return  $this->db->query('SELECT DATE_FORMAT(waktu, "%d-%m-%Y") as tanggal, DATE_FORMAT(waktu, "%H:%i") as waktu, alamat, pengguna, keterangan '.
        'FROM aktifitas '.$where.' '.$limit);
    }
    
    function reportlist($page, $data)
	{
		/*pagination*/
        $filterdata = array();
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'waktu >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND waktu <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        if ($this->session->userdata('SES_REP_USER') != '')
            $filterdata[] = 'pengguna = "'.$this->session->userdata('SESS_REP_USER').'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata).' ' : null);
        $limit = 'ORDER BY tanggal ASC LIMIT '.$page.','.$data;
        $query = $this->reportquery($where, $limit);
        
        if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
	
    function reportcount()
	{
		/*pagination*/
        $filterdata = array();
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'waktu >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND waktu <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        if ($this->session->userdata('SES_REP_USER') != '')
            $filterdata[] = 'pengguna = "'.$this->session->userdata('SESS_REP_USER').'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata).' ' : null);
        $query = $this->reportquery($where);
        
        return $query->num_rows();
	}
    
	function reportprint()
	{
		/*pagination*/
        $filterdata = array();
        echo 'txtdate1: '.$this->session->userdata('SESS_REP_DATE1');
        if ($this->session->userdata('SESS_REP_DATE1') != '' && $this->session->userdata('SESS_REP_DATE2') != '')
            $filterdata[] = 'waktu >= "'.date('Y-m-d 00:00:00', strtotime($this->session->userdata('SESS_REP_DATE1'))).'" AND waktu <= "'.date('Y-m-d 23:59:59', strtotime($this->session->userdata('SESS_REP_DATE2'))).'"';
        if ($this->session->userdata('SES_REP_USER') != '')
            $filterdata[] = 'pengguna = "'.$this->session->userdata('SESS_REP_USER').'"';
        $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata).' ' : null);
        $limit = 'ORDER BY tanggal ASC';
		$query = $this->reportquery($where, $limit);
        
        if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
    
    function create_report_session()
    {
        $this->session->set_userdata('SESS_REP_DATE1', $this->input->post('txtdate1'));
        $this->session->set_userdata('SESS_REP_DATE2', $this->input->post('txtdate2'));
        $this->session->set_userdata('SESS_REP_USER', $this->input->post('txtuserid'));
    }
    
    function remove_report_session()
    {
        $this->session->unset_userdata('SESS_REP_DATE1');
        $this->session->unset_userdata('SESS_REP_DATE2');
        $this->session->unset_userdata('SESS_REP_USER');
    }
}
/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
