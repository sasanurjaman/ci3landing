<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Controller 
{
	var $data;
    
    function __construct()
    {
		parent::__construct();
		if(!$this->session->userdata('SESS_USER_ID'))
			redirect(base_url());
			
		$models = array(
			'company_model', 
			'user_model', 
			'password_model', 
			'permission_model', 
			'application_model'
		);
        $this->load->model($models);
        
        $this->data = array(
			'iconpage' => 'fa fa-gears',
			'mainpage' => 'PENGATURAN'
        );
	}
	
    function uploadtmp()
    {
        /*setting file*/
        if (!empty($_FILES['txtfile']['name'])) 
        {
            $base_path = './tmp/';
            $filename = $_FILES['txtfile']['name'];
            $ext = pathinfo($base_path.$filename, PATHINFO_EXTENSION);
            $newname = $this->session->userdata('SESS_USER_ID').'-'.date('YmdHis').'.'.$ext;
            $config['upload_path'] = $base_path;
            $config['file_name'] = $newname;
            $config['allowed_types'] = (getCompany()->format != '-' ? getCompany()->format : 'bmp|gif|jpg|png');
            $config['max_size'] = (getCompany()->ukuran > 0 ? getCompany()->ukuran : 0);
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('txtfile'))
            {
                $result = array(
                    'filename' => $newname,
                    'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'Data Berhasil Diunggah!'
                );
            }
            else
            {
                $result = array(
                    'filename' => $_FILES['txtfile']['name'],
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => $this->upload->display_errors()
                );
            }
        }
        else
        {
            $result = array(
                'filename' => '',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Berkas Kosong!'
            );
        }
        
        echo json_encode($result);
    }
    
	function company()
	{
		$data = $this->data;
        $data['caption'] = 'PERUSAHAAN';
		$data['datas'] = $this->company_model->dataid();
        
        $this->load->view('settings/company', $data);
        user_log('buka data perusahaan', 'fa-folder-open-o');
	}
	
	function updatecompany()
	{
		$data = array();
        
        if ($this->company_model->validation())
		{
			$data = $this->company_model->update();
            user_log('simpan perubahan data perusahaan', 'fa-save');
        }
        else
        {
            if (form_error('txtname'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Nama tidak valid!', 'elfocus' => '#txtname');
            elseif (form_error('txtmoto'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Moto tidak valid!', 'elfocus' => '#txtmoto');
            elseif (form_error('txtaddress'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Alamat tidak valid!', 'elfocus' => '#txtaddress');
            elseif (form_error('txtcity'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Kota tidak valid!', 'elfocus' => '#txtcity');
            elseif (form_error('txtposcode'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data KodePos tidak valid!', 'elfocus' => '#txtposcode');
            elseif (form_error('txtphone'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Telepon tidak valid!', 'elfocus' => '#txtphone');
            elseif (form_error('txtfax'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Fax tidak valid!', 'elfocus' => '#txtfax');
            elseif (form_error('txtemail'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Email tidak valid!', 'elfocus' => '#txtemail');
        }
        
        echo json_encode($data);
	}
	
	function user()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->user_model->datacount($search);
		$config['base_url'] = base_url().'settings/datauser/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'PENGGUNA';
		$data['datas'] = $this->user_model->datalist($search, $page, $this->config->item('show_data'));
        $data['search'] = $search;
        $data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('settings/user', $data);
        user_log('buka data pengguna', 'fa-folder-open-o');
	}
	
    function datauser()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
		
        /*pagination*/
		$n = $this->user_model->datacount($search);
		$config['base_url'] = base_url().'settings/datauser/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
        $data = $this->data;
        $data['caption'] = 'PENGGUNA';
		$data['datas'] = $this->user_model->datalist($search, $page, $this->config->item('show_data'));
        $data['search'] = $search;
        $data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('settings/datauser', $data);
	}
    
	function adduser()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
        
		$data = $this->data;
        $data['caption'] = 'PENGGUNA BARU';
        $data['search'] = $search;
        $data['page'] = $page;
        
		$this->load->view('settings/adduser', $data);
        user_log('buka form tambah pengguna baru', 'fa-plus');
	}

	function edituser()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		
        $data = $this->data;
        $data['caption'] = 'UBAH PENGGUNA';
        $data['datas'] = $this->user_model->dataid($id);
        $data['search'] = $search;
        $data['page'] = $page;
        
		$this->load->view('settings/adduser', $data);
        user_log('buka form ubah pengguna', 'fa-edit');
	}
	
	function activeuser()
	{
		$id = $this->uri->segment(5);
        
        $data = $this->user_model->active($id);
        user_log('enable/disable data user', 'fa-check-square-o');

        echo json_encode($data);
	}
	
	function resetuser()
	{
		$data = array();
        $id = $this->uri->segment(5);
        
        $data = $this->user_model->reset($id);
        user_log('reset password data perusahaan', 'fa-undo');
        
        echo json_encode($data);
	}
	
	function deluser()
	{
		$data = array();
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
                
        $data = $this->user_model->delete($search, $page, $id);
        user_log('hapus data user: `'.$id.'` berhasil', 'fa-trash-o');
        
        echo json_encode($data);
	}
	
	function updateuser()
	{
		$data = array();
        $caption = $this->input->post('caption');
		$search = $this->input->post('search');
        $page = $this->input->post('page');		
		
		if ($this->user_model->validation())
		{
			if ($caption == 'UBAH PENGGUNA')
			{
				$data = $this->user_model->update();
                user_log('ubah data pengguna', 'fa-save');
			}
			else
			{
				$data = $this->user_model->insert();
                user_log('simpan data pengguna', 'fa-save');
			}
		}
		else
		{
			if (form_error('txtuserid'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data IDPengguna kosong!', 'elfocus' => '#txtuserid');
            elseif (form_error('txtname'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Nama kosong!', 'elfocus' => '#txtname');
		}
        
        echo json_encode($data);
	}
	
	function password()
	{
		$data = $this->data;
        $data['caption'] = 'KATASANDI';
		$data['datas'] = $this->company_model->dataid();
        
        $this->load->view('settings/password', $data);
        user_log('buka form ubah kata sandi', 'fa-folder-open-o');
	}
	
	function updatepassword()
	{
        $data = array();
        if ($this->password_model->validation())
		{
			$data = $this->password_model->update();
            user_log('simpan perubahan katasandi', 'fa-save');
        }
		else
		{
			if (form_error('txtpassword'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Katasandi kosong!', 'elfocus' => '#txtpassword');
            elseif (form_error('txtrepassword'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Ulang Katasandi kosong!', 'elfocus' => '#txtrepassword');
		}
        
        echo json_encode($data);
	}
	
	function permission()
	{
		$data = $this->data;
        $data['caption'] = 'HAK AKSES';
		$data['userids'] = $this->permission_model->datauser();
        
        $this->load->view('settings/permission', $data);
        user_log('buka form ubah hak akses', 'fa-folder-open-o');
	}
	
    function combouser()
    {
        $data = array();
        $key = ($this->input->post('txtkey') != '' ? $this->input->post('txtkey') : 'null');
        $data = $this->user_model->datacombo($key);
        
        echo json_encode($data);
    }
    
	function getpermission()
	{
		$data = array();
        $id = ($this->input->post('txtuserid') != '' ? $this->input->post('txtuserid') : null);		
		$data = $this->permission_model->dataid($id);
        
		echo json_encode($data);
	}
	
	function updatepermission()
	{
		$data = array();
        if ($this->permission_model->validation())
		{
			$data = $this->permission_model->update();
            user_log('simpan perubahan data hak akses', 'fa-save');
		}
		else
		{
			$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data IDPengguna kosong!', 'elfocus' => '#txtuserid');
		}
        
        echo json_encode($data);
	}
    
    function application()
	{
		$data = $this->data;
        $data['caption'] = 'APLIKASI';
		$data['datas'] = $this->application_model->dataid();
        
		$this->load->view('settings/application', $data);
        user_log('buka form setting aplikasi', 'fa-folder-open-o');
	}
	
	function updateapplication()
	{
		$data = array();
        if ($this->application_model->validation())
		{
			$data = $this->application_model->update();
            user_log('simpan perubahan data aplikasi', 'fa-save');
		}
		else
		{
			if (form_error('txtformat'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Format tidak valid!', 'elfocus' => '#txtformat');
            elseif (form_error('txtsize'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Ukuran tidak valid!', 'elfocus' => '#txtsize');
		}
        
        echo json_encode($data);
	}
    
    function number()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->number_model->datacount($search);
		$config['base_url'] = base_url().'settings/datanumber/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'NOMOR SURAT';
		$data['datas'] = $this->number_model->datalist($search, $page, $this->config->item('show_data'));
        $data['search'] = $search;
        $data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('settings/number', $data);
        user_log('buka data nomor surat', 'fa-folder-open-o');
	}
	
    function datanumber()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
		
        /*pagination*/
		$n = $this->number_model->datacount($search);
		$config['base_url'] = base_url().'settings/datanumber/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'NOMOR SURAT';
		$data['datas'] = $this->number_model->datalist($search, $page, $this->config->item('show_data'));
        $data['search'] = $search;
        $data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('settings/datanumber', $data);
	}
    
	function addnumber()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
        
		$data = $this->data;
        $data['caption'] = 'NOMOR SURAT BARU';
        $data['search'] = $search;
        $data['page'] = $page;
        
		$this->load->view('settings/addnumber', $data);
        user_log('buka form tambah nomor surat baru', 'fa-plus');
	}

	function editnumber()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		
        $data = $this->data;
        $data['caption'] = 'UBAH NOMOR SURAT';
        $data['datas'] = $this->number_model->dataid($id);
        $data['search'] = $search;
        $data['page'] = $page;
        
		$this->load->view('settings/addnumber', $data);
        user_log('buka form ubah nomor surat baru', 'fa-edit');
	}
    
    function delnumber()
	{
		$data = array();
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
                
        $data = $this->number_model->delete($search, $page, $id);
        user_log('hapus data user: `'.$id.'` berhasil', 'fa-trash-o');
        
        echo json_encode($data);
	}
	
	function updatenumber()
	{
		$data = array();
        $caption = $this->input->post('caption');
		$search = $this->input->post('search');
        $page = $this->input->post('page');		
		
		if ($this->number_model->validation())
		{
			if ($caption == 'UBAH NOMOR SURAT')
			{
				$data = $this->number_model->update();
                user_log('ubah data nomor surat', 'fa-save');
			}
			else
			{
				$data = $this->number_model->insert();
                user_log('simpan data nomor surat', 'fa-save');
			}
		}
		else
		{
			if (form_error('txtseparator'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data IDPengguna tidak valid!', 'elfocus' => '#txtseparator');
            elseif (form_error('txtnumber1'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Nomor kosong!', 'elfocus' => '#txtnumber1');
            elseif (form_error('txtnumber2'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Nomor kosong!', 'elfocus' => '#txtnumber2');
            elseif (form_error('txtorganisation1'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Organisasi kosong!', 'elfocus' => '#txtorganisation1');
            elseif (form_error('txtorganisation2'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Organisasi kosong!', 'elfocus' => '#txtorganisation2');
            elseif (form_error('txtdivision1'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Bagian tidak valid!', 'elfocus' => '#txtdivision1');
            elseif (form_error('txtdivision2'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Bagian tidak valid!', 'elfocus' => '#txtdivision2');
            elseif (form_error('txtsubdivision1'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data SubBagian tidak valid!', 'elfocus' => '#txtsubdivision1');
            elseif (form_error('txtsubdivision2'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data SubBagian tidak valid!', 'elfocus' => '#txtsubdivision2');
            elseif (form_error('txtmonth1'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Bulan tidak valid!', 'elfocus' => '#txtmonth1');
            elseif (form_error('txtmonth2'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Bulan tidak valid!', 'elfocus' => '#txtmonth2');
            elseif (form_error('txtyear1'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Bulan tidak valid!', 'elfocus' => '#txtyear1');
            elseif (form_error('txtyear2'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data Bulan tidak valid!', 'elfocus' => '#txtyear2');
		}
        
        echo json_encode($data);
	}
    
    function customer()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		else if ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';

		/*pagination*/
		$n = $this->customer_model->datacount($search);
		$config['base_url'] = base_url().'settings/datacustomer/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);

		$data = $this->data;
        $data['caption'] = 'PELANGGAN';
		$data['datas'] = $this->customer_model->datalist($search, $page, $this->config->item('show_data'));
        $data['search'] = $search;
        $data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('settings/customer', $data);
        user_log('buka data pelanggan', 'fa-folder-open-o');
	}
    
    function datacustomer()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		else if ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';

		/*pagination*/
        $n = $this->customer_model->datacount($search);
		$config['base_url'] = base_url().'settings/datacustomer/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);

		$data = $this->data;
        $data['caption'] = 'PELANGGAN';
		$data['datas'] = $this->customer_model->datalist($search, $page, $this->config->item('show_data'));
        $data['search'] = $search;
        $data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('settings/datacustomer', $data);
	}
    
	function addcustomer()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		
        $data = $this->data;
        $data['caption'] = 'PELANGGAN BARU';
        $data['datacode'] = $this->customer_model->datacode();
        $data['search'] = $search;
        $data['page'] = $page;
        
		$this->load->view('settings/addcustomer', $data);
        user_log('buka form tambah pelanggan baru', 'fa-plus');
	}

	function editcustomer()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);

		$data = $this->data;
        $data['caption'] = 'UBAH PELANGGAN';
        $data['datacode'] = $this->customer_model->datacode();
		$data['datas'] = $this->customer_model->dataid($id);
		$data['search'] = $search;
        $data['page'] = $page;
		
        $this->load->view('settings/addcustomer', $data);
        user_log('buka form ubah pelanggan', 'fa-edit');
	}
    
    function updatecustomer()
	{
		$data = array();
        $caption = $this->input->post('caption');
        
		if ($this->customer_model->validation())
		{
			if ($caption == 'UBAH PELANGGAN') 
            {
                $data = $this->customer_model->update();
                user_log('ubah pelanggan: '.$data['notif'], 'fa-save');
            } 
            else 
            {
                $data = $this->customer_model->insert();
                user_log('input pelanggan: '.$data['notif'], 'fa-save');
			}
		}
		else
		{
			if ($this->session->userdata('ERR_LIMIT'))
            {
                $this->session->unset_userdata('ERR_LIMIT');
                $data = array('title' => 'Informasi', 'notif' => 'modal-info', 'messg' => $this->config->item('site_blok'), 'elfocus' => '');
            }
            elseif (form_error('txtcode'))
            {
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => form_error('txtcode'), 'elfocus' => '#txtcode');
            }
            elseif (form_error('txtname'))
            {
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => form_error('txtname'), 'elfocus' => '#txtname');
            }
            elseif (form_error('txtaddress'))
            {
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => form_error('txtaddress'), 'elfocus' => '#txtaddress');
            }
            elseif (form_error('txtphone'))
            {
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => form_error('txtphone'), 'elfocus' => '#txtphone');
            }
		}
        
        echo json_encode($data);
	}

	function delcustomer()
	{
		$data = array();
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
                
        $data = $this->customer_model->delete($search, $page, $id);
        user_log('hapus data pelanggan: `'.$id.'` berhasil', 'fa-trash-o');
        
        echo json_encode($data);
	}
}

/* End of file settings.php */
/* Lotypesion: ./applitypesion/controllers/settings.php */