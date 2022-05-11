<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission_model extends CI_Model 
{
	function datauser()
	{
		$query = $this->db->query('SELECT userid, nama, aktif FROM user');
        
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}
	
	function dataid($id = 'null')
	{
		$query = $this->db->query('SELECT S0, S1, S2, S3, S4, S5, T0, T1, T2, T3, T4, L0, L1, L2, L3, L4, L5 FROM user '.
		'WHERE userid = "'.$id.'"');
        
		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return false;
	}
	
	function validation()
	{
		$this->form_validation->set_rules('txtuserid', 'UserID', 'trim|xss_clean|prep_for_form');
		return $this->form_validation->run();
	}
	
	function update()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'S4', 'edit') == 'Y')
		{
			$this->db->where('userid', $this->input->post('txtuserid'));
			if ($this->db->count_all_results('user') == 1)
			{
				for ($c=0; $c<5; $c++) 
                {
                    $set1[$c] = ($this->input->post('txtcompany'.$c)=="Y") ? "Y" : "N";
                    $set2[$c] = ($this->input->post('txtuser'.$c)=="Y") ? "Y" : "N";
                    $set3[$c] = ($this->input->post('txtpassword'.$c)=="Y") ? "Y" : "N";
                    $set4[$c] = ($this->input->post('txtpermissions'.$c)=="Y") ? "Y" : "N";
                    $set5[$c] = ($this->input->post('txtapplication'.$c)=="Y") ? "Y" : "N";
                    $set6[$c] = ($this->input->post('txtnumber'.$c)=="Y") ? "Y" : "N";
                    $set7[$c] = ($this->input->post('txtcustomer'.$c)=="Y") ? "Y" : "N";
                     
                    $tra1[$c] = ($this->input->post('txtinvoice'.$c)=="Y") ? "Y" : "N";
                    $tra2[$c] = ($this->input->post('txtreceipt'.$c)=="Y") ? "Y" : "N";
                    $tra3[$c] = ($this->input->post('txtsale'.$c)=="Y") ? "Y" : "N";
                    $tra4[$c] = ($this->input->post('txtdelivery'.$c)=="Y") ? "Y" : "N";
                        
                    $rep1[$c] = ($this->input->post('txtrinvoice'.$c)=="Y") ? "Y" : "N";
                    $rep2[$c] = ($this->input->post('txtrreceipt'.$c)=="Y") ? "Y" : "N";
                    $rep3[$c] = ($this->input->post('txtrsale'.$c)=="Y") ? "Y" : "N";
                    $rep4[$c] = ($this->input->post('txtrdelivery'.$c)=="Y") ? "Y" : "N";
                    $rep5[$c] = ($this->input->post('txtractivities'.$c)=="Y") ? "Y" : "N";
                }
                $S0 = ($set1[0] == "N" && $set2[0] == "N" && $set3[0] == "N" && $set4[0] == "N") ? "N|D|D|D|D" : "Y|D|D|D|D";
                $T0 = ($tra1[0] == "N" && $tra2[0] == "N" && $tra3[0] == "N" && $tra4[0] == "N") ? "N|D|D|D|D" : "Y|D|D|D|D";
                $L0 = ($rep1[0] == "N" && $rep2[0] == "N" && $rep4[0] == "N" && $rep4[0] == "N") ? "N|D|D|D|D" : "Y|D|D|D|D";
				
				/*fill array data*/
                $data = array(
                    'S0' => $S0,
                    'S1' => $set1[0]."|D|".$set1[2]."|D|D",
                    'S2' => $set2[0]."|".$set2[1]."|".$set2[2]."|".$set2[3]."|D",
                    'S3' => $set3[0]."|D|".$set3[2]."|D|D",
                    'S4' => $set4[0]."|D|".$set4[2]."|D|D",
                    'S5' => $set5[0]."|D|".$set5[2]."|D|D",
                    'S6' => $set6[0]."|".$set6[1]."|".$set6[2]."|".$set6[3]."|D",
                    'S7' => $set7[0]."|".$set7[1]."|".$set7[2]."|".$set7[3]."|D",
                    'T0' => $T0,
                    'T1' => $tra1[0]."|".$tra1[1]."|".$tra1[2]."|".$tra1[3]."|".$tra1[4],
                    'T2' => $tra2[0]."|".$tra2[1]."|".$tra2[2]."|".$tra2[3]."|".$tra2[4],
                    'T3' => $tra3[0]."|".$tra3[1]."|".$tra3[2]."|".$tra3[3]."|".$tra3[4],
                    'T4' => $tra4[0]."|".$tra4[1]."|".$tra4[2]."|".$tra4[3]."|".$tra4[4],
                    'L0' => $L0,
                    'L1' => $rep1[0]."|D|D|D|".$rep1[4],
                    'L2' => $rep2[0]."|D|D|D|".$rep2[4],
                    'L3' => $rep3[0]."|D|D|D|".$rep3[4],
                    'L4' => $rep4[0]."|D|D|D|".$rep4[4],
                    'L5' => $rep5[0]."|D|D|D|".$rep5[4]
                );	
                $this->db->where('userid', $this->input->post('txtuserid'));
                $this->db->update('user', $data);
                
                return array(
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data berhasil diperbaharui!',
                    'elfocus' => '#txtuserid'
                );
            }
            else
            {
                return array(
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, data tidak ada!',
                    'elfocus' => '#txtuserid'
                );
			}
		}
		else
		{
			return array(
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, menu tidak bisa diakses!',
                'elfocus' => '#txtuserid'
            );
		} //endif:1
	}
	
}
/* End of file permissions_model.php */
/* Location: ./application/models/permissions_model.php */
