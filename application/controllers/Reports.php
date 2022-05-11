<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends CI_Controller 
{
	var $data;
    
    function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('SESS_USER_ID'))
			redirect( base_url() );
			
		$models = array(
			'news_model', 
			'video_model', 
			'agenda_model', 
			'absensi_model',
			'activities_model'
		);
		$this->load->model($models);
		
        $this->data = array(
			'iconpage' => 'fa fa-files-o',
			'mainpage' => 'LAPORAN'
        );
	}
	
    function rnews()
	{
		$data = $this->data;
        $data['caption'] = 'BERITA';
        
        $this->load->view('reports/rnews', $data);
        user_log('buka form filter laporan berita', 'fa-folder-open-o');
	}
    
    function reportrnews()
	{
		/*pagination*/
		$n = $this->news_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportrnews';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'BERITA';
		$data['datas'] = $this->news_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/reportrnews', $data);
        user_log('buka data laporan berita', 'fa-folder-open-o');
	}
    
    function datareportrnews()
	{
		/*pagination*/
		$n = $this->news_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportrnews';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'BERITA';
		$data['datas'] = $this->news_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/datareportrnews', $data);
	}
	
	function rvideo()
	{
		$data = $this->data;
        $data['caption'] = 'VIDEO';
        
        $this->load->view('reports/rvideo', $data);
        user_log('buka form filter laporan video', 'fa-folder-open-o');
	}
    
    function reportrvideo()
	{
		/*pagination*/
		$n = $this->video_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportrvideo';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'VIDEO';
		$data['datas'] = $this->video_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/reportrvideo', $data);
        user_log('buka data laporan video', 'fa-folder-open-o');
	}
    
    function datareportrvideo()
	{
		/*pagination*/
		$n = $this->video_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportrvideo';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'VIDEO';
		$data['datas'] = $this->video_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/datareportrvideo', $data);
	}

	function ragenda()
	{
		$data = $this->data;
        $data['caption'] = 'AGENDA';
        
        $this->load->view('reports/ragenda', $data);
        user_log('buka form filter laporan agenda', 'fa-folder-open-o');
	}
    
    function reportragenda()
	{
		/*pagination*/
		$n = $this->agenda_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportragenda';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'AGENDA';
		$data['datas'] = $this->agenda_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/reportragenda', $data);
        user_log('buka data laporan agenda', 'fa-folder-open-o');
	}
    
    function datareportragenda()
	{
		/*pagination*/
		$n = $this->agenda_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportragenda';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'AGENDA';
		$data['datas'] = $this->agenda_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/datareportragenda', $data);
	}

    function ractivities()
	{
		$this->activities_model->remove_report_session();
        
        $data = $this->data;
        $data['caption'] = 'AKTIFITAS';
        
        $this->load->view('reports/ractivities', $data);
        user_log('buka form filter laporan aktifitas', 'fa-folder-open-o');
	}
    
    function reportractivities()
	{
		$this->activities_model->create_report_session();
        
		/*pagination*/
		$n = $this->activities_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportractivities';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'AKTIFITAS';
		$data['datas'] = $this->activities_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/reportractivities', $data);
        user_log('buka data laporan aktifitas', 'fa-sticky-note-o');
	}
    
    function datareportractivities()
	{
		/*pagination*/
		$n = $this->activities_model->reportcount();
		$config['base_url'] = base_url().'reports/datareportractivities';
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3) != '' ? $this->uri->segment(3) : 0);
		
		$data = $this->data;
        $data['caption'] = 'AKTIFITAS';
		$data['datas'] = $this->activities_model->reportlist($page, $this->config->item('show_data'));
		$data['page'] = $page;
        $data['paging'] = $this->pagination->create_links();		
        
        $this->load->view('reports/datareportractivities', $data);
	}
}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */