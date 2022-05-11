<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller 
{
	var $data;
    
    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('SESS_USER_ID'))
			redirect( base_url() );
		
        $this->data = array(
			'logo' => 'fa fa-dashboard',
			'mainpage' => 'BERANDA'
        );
	}
	
	function index()
	{
		$data = $this->data;
        $data['caption'] = 'Dashboard';
        $data['datacount1'] = $this->dashboard_model->datacount1();
		$data['datacount2'] = $this->dashboard_model->datacount2();
		$data['datacount3'] = $this->dashboard_model->datacount3();
		$data['datacount4'] = $this->dashboard_model->datacount4();
		$data['datalog'] = $this->dashboard_model->datalog();
		$data['datachart'] = $this->dashboard_model->datachart();
		$data['content'] = 'dashboard/main';
        
        $this->load->view('dashboard', $data);		
	}
	
    function beranda()
	{
		$data = $this->data;
        $data['caption'] = '';
		$data['search'] = '';		
        
        $this->load->view('dashboard/main', $data);		
	}
    
	function profile()
	{
		$data = $this->data;
        $data['caption'] = 'PROFIL PENGGUNA';
		$data['datas'] = $this->dashboard_model->datauser();
		$data['dataction'] = $this->dashboard_model->dataction();
        
		$this->load->view('dashboard/profile', $data);
	}
	
	function updateuser()
	{
		if ($this->dashboard_model->validation())
        {
			$this->dashboard_model->updates();
			$this->session->set_userdata('SUCCESS','Data successfully updated');
			redirect('/dashboard/profile');
		}
        else
        {
			$this->session->set_userdata('ERRNAME', "Kolom Nama kosong!");
			redirect('/dashboard/profile');
		}
	}
	    
    function signout()
	{
		$this->session->unset_userdata('SESS_USER_ID');
		$this->session->unset_userdata('SESS_USER_NAME');
		$this->session->unset_userdata('SESS_USER_PHOTO');
		$this->session->unset_userdata('SESS_USER_LEVEL');
		$this->session->sess_destroy();
		
		redirect('/');
	}
}

/* End of file login.php */
/* Location: ./application/controllers/dashboard.php */