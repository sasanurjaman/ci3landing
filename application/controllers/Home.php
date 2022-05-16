<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller 
{
	var $data;
    
    public function __construct()
    {
        parent::__construct();
			
		$models = array(
            'video_model',
            'news_model',
            'agenda_model',
            'absensi_model'
		);
        $this->load->model($models);
    }
        
    function index()
	{
		$data = $this->data;
        $data['caption'] = 'Beranda';
        $data['content'] = 'home/main';
        $data['runvideo'] = $this->video_model->datarun();        
        
        $this->load->view('home', $data);
	}
    
    function runtext()
    {
        $data = array();
        $data = $this->news_model->datarun();
        
        echo json_encode($data);
    }
    
    function runagenda()
    {
        $data = array();
        $data = $this->agenda_model->datarun();
        
        echo json_encode($data);
    }
    
    function runabsent()
    {
        $data = array();
        $data = $this->absensi_model->datarun();
        
        echo json_encode($data);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */