<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportsPDF extends CI_Controller
{
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
	
    function printrnews()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'L1', 'print') == 'Y')
        {
            $filename = $this->session->userdata('SESS_USER_ID').'-'.date('ymdhis').'.pdf';
            
            /*-- cek existing file --*/
            if (file_exists('./tmp/'.$filename))
                unlink('tmp/'.$filename);
		
            $data = $this->data;
            $data['caption'] = 'BERITA';
            $data['datas'] = $this->news_model->reportprint();
            $data['content'] = 'reportspdf/printrnews';
            
            $html = $this->load->view('invoice', $data, true);
            $output = $this->pdfgenerator->generate($html, $filename, false, getCompany()->kertas, getCompany()->orentasi);
            file_put_contents('./tmp/'.$filename, $output);
            
            $result = array(
                'filename' => $filename,
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => ''
            );
            user_log('cetak data laporan surat masuk', 'fa-print');
        }
        else
        {
            $result = array(
                'filename' => '',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, Menu tidak dapat diakses!'
            );                                                          
        }
        
        echo json_encode($result);
	}
	
    function printrvideo()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'L2', 'print') == 'Y')
        {
            $filename = $this->session->userdata('SESS_USER_ID').'-'.date('ymdhis').'.pdf';
            
            /*-- cek existing file --*/
            if (file_exists('./tmp/'.$filename))
                unlink('tmp/'.$filename);
		
            $data = $this->data;
            $data['caption'] = 'VIDEO';
            $data['datas'] = $this->video_model->reportprint();
            $data['content'] = 'reportspdf/printrvideo';
            
            $html = $this->load->view('invoice', $data, true);
            $output = $this->pdfgenerator->generate($html, $filename, false, getCompany()->kertas, getCompany()->orentasi);
            file_put_contents('./tmp/'.$filename, $output);
            
            $result = array(
                'filename' => $filename,
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => ''
            );
            user_log('cetak data laporan surat masuk', 'fa-print');
        }
        else
        {
            $result = array(
                'filename' => '',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, Menu tidak dapat diakses!'
            );                                                          
        }
        
        echo json_encode($result);
    }
    
    function printragenda()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'L3', 'print') == 'Y')
        {
            $filename = $this->session->userdata('SESS_USER_ID').'-'.date('ymdhis').'.pdf';
            
            /*-- cek existing file --*/
            if (file_exists('./tmp/'.$filename))
                unlink('tmp/'.$filename);
		
            $data = $this->data;
            $data['caption'] = 'AGENDA';
            $data['datas'] = $this->agenda_model->reportprint();
            $data['content'] = 'reportspdf/printragenda';
            
            $html = $this->load->view('invoice', $data, true);
            $output = $this->pdfgenerator->generate($html, $filename, false, getCompany()->kertas, getCompany()->orentasi);
            file_put_contents('./tmp/'.$filename, $output);
            
            $result = array(
                'filename' => $filename,
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => ''
            );
            user_log('cetak data laporan surat masuk', 'fa-print');
        }
        else
        {
            $result = array(
                'filename' => '',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, Menu tidak dapat diakses!'
            );                                                          
        }
        
        echo json_encode($result);
    }
    
    function printractivities()
	{
		if (getAccess($this->session->userdata('SESS_USER_ID'), 'L4', 'print') == 'Y')
        {
            $filename = $this->session->userdata('SESS_USER_ID').'-'.date('ymdhis').'.pdf';
            
            /*-- cek existing file --*/
            if (file_exists('./tmp/'.$filename))
                unlink('tmp/'.$filename);
		
            $data = $this->data;
            $data['caption'] = 'BERITA';
            $data['datas'] = $this->activities_model->reportprint();
            $data['content'] = 'reportspdf/printrnews';
            
            $html = $this->load->view('invoice', $data, true);
            $output = $this->pdfgenerator->generate($html, $filename, false, getCompany()->kertas, getCompany()->orentasi);
            file_put_contents('./tmp/'.$filename, $output);
            
            $result = array(
                'filename' => $filename,
                'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => ''
            );
            user_log('cetak data laporan surat masuk', 'fa-print');
        }
        else
        {
            $result = array(
                'filename' => '',
                'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Mohon maaf, Menu tidak dapat diakses!'
            );                                                          
        }
        
        echo json_encode($result);
	}
}
?>