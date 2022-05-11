<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transactions extends CI_Controller 
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
			'absensi_model'
		);
		$this->load->model($models);

        $this->data = array(
			"iconpage" => "fa fa-th",
			"mainpage" => "PEMROSESAN"
        );
	}
	
    function uploadtmp()
    {
        /*setting file*/
        if (!empty($_FILES["txtfile"]["name"])) 
        {
            $base_path = "./tmp/";
            $config["upload_path"] = $base_path;
            $config["allowed_types"] = 'mp4|3gp|flv';
            $config["max_size"] = '102400';
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('txtfile'))
            {
                $dataupload = $this->upload->data();
                $newname = $this->session->userdata("SESS_USER_ID")."-".date("YmdHis").$dataupload["file_ext"];
                if ( file_exists( $base_path.$dataupload["file_name"] ) )
                {
                    rename( $base_path.$dataupload["file_name"], $base_path.$newname );
                }
                
                $result = array(
                    "filename" => $newname,
                    "title" => "Berhasil", "notif" => "modal-success", "messg" => "Data Berhasil Diunggah!", "elfocus" => ""
                );
            }
            else
            {
                $result = array(
                    "filename" => "",
                    "title" => "Kesalahan", "notif" => "modal-danger", "messg" => $this->upload->display_errors(), "elfocus" => ""
                );
            }
        }
        else
        {
            $result = array(
                "filename" => "",
                "title" => "Kesalahan", "notif" => "modal-danger", "messg" => "Kolom Berkas Kosong!"
            );
        }
        
        echo json_encode($result);
    }
    
    function news()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->news_model->datacount($search);
        $config['base_url'] = base_url().'transactions/datanews/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'BERITA';
        $data['datas'] = $this->news_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/news', $data);
        user_log('buka data berita', 'fa-folder-open-o');
	}
    
    function datanews()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->news_model->datacount($search);
        $config['base_url'] = base_url().'transactions/datanews/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'BERITA';
        $data['datas'] = $this->news_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/datanews', $data);
	}
    
    function addnews()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		
		$data = $this->data;
		$data['caption'] = 'BERITA BARU';
		$data['page'] = $page;
		$data['search'] = $search;
		
        $this->load->view('transactions/addnews', $data);
        user_log('buka form news baru', 'fa-plus');
	}
		
	function editnews()
	{
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		
		$data = $this->data;
		$data['caption'] = 'UBAH BERITA';
		$data['datas'] = $this->news_model->dataid($id);
		$data['page'] = $page;
		$data['search'] = $search;
        
		$this->load->view('transactions/addnews', $data);
        user_log('buka form ubah news', 'fa-edit');
	}
	
    function activenews()
	{
		$id = $this->uri->segment(5);
        
        $data = $this->news_model->active($id);
        user_log('enable/disable data berita', 'fa-check-square-o');

        echo json_encode($data);
	}
    
    function delnews()
	{
		$data = array();
        $search = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $data = $this->news_model->delete($search, $page, $id);
        user_log('hapus data berita `'.$id.'`: '.$data['title'], 'fa-trash-o');
        
		echo json_encode($data);
	}
	
	function updatenews()
	{
		$data = array();
		$caption = $this->input->post('caption');
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		
		if ($this->news_model->validation())
		{
			if ($caption == 'UBAH BERITA')
			{
				$data = $this->news_model->update();
                user_log('simpan perubahan data berita', 'fa-save');
			}
			else
			{
				$data = $this->news_model->insert();
                user_log('simpan data berita baru', 'fa-save');
			}
		}
		else
		{
			if (form_error('txtitle'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => form_error('txtitle'), 'elfocus' => '#txtitle');
		}
        
        echo json_encode($data);
	}
    
    function video()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->video_model->datacount($search);
        $config['base_url'] = base_url().'transactions/datavideo/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'VIDEO';
        $data['datas'] = $this->video_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/video', $data);
        user_log('buka data video', 'fa-folder-open-o');
	}
    
    function datavideo()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->video_model->datacount($search);
        $config['base_url'] = base_url().'transactions/datavideo/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'VIDEO';
        $data['datas'] = $this->video_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/datavideo', $data);
	}
    
    function addvideo()
	{
		$this->load->model('video_model');
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		
		$data = $this->data;
		$data['caption'] = 'VIDEO BARU';
		$data['page'] = $page;
		$data['search'] = $search;
		
        $this->load->view('transactions/addvideo', $data);
        user_log('buka form video baru', 'fa-plus');
	}
		
	function editvideo()
	{
		$this->load->model('video_model');
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		
		$data = $this->data;
		$data['caption'] = 'UBAH VIDEO';
		$data['datas'] = $this->video_model->dataid($id);
		$data['page'] = $page;
		$data['search'] = $search;
        
		$this->load->view('transactions/addvideo', $data);
        user_log('buka form ubah video', 'fa-edit');
	}
	
    function activevideo()
	{
		$this->load->model('video_model');
		$id = $this->uri->segment(5);
        
        $data = $this->video_model->active($id);
        user_log('enable/disable data video', 'fa-check-square-o');

        echo json_encode($data);
	}
    
    function delvideo()
	{
		$this->load->model('video_model');
		$data = array();
        $search = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $data = $this->video_model->delete($search, $page, $id);
        user_log('hapus data video `'.$id.'`: '.$data['title'], 'fa-trash-o');
        
		echo json_encode($data);
	}
	
	function updatevideo()
	{
		$this->load->model('video_model');
        $data = array();
		$caption = $this->input->post('caption');
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		
        if ($this->video_model->validation())
		{
			if ($caption == 'UBAH VIDEO')
			{
				$data = $this->video_model->update();
                user_log('simpan perubahan data video', 'fa-save');
			}
			else
			{
				$data = $this->video_model->insert();
                user_log('simpan data video baru', 'fa-save');
			}
		}
		else
		{
			if (form_error('txtname'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Kolom Nama Kosong!', 'elfocus' => '#txtname');
		}
        
        echo json_encode($data);
	}
    
    function agenda()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->agenda_model->datacount($search);
        $config['base_url'] = base_url().'transactions/datagenda/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'AGENDA';
        $data['datas'] = $this->agenda_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/agenda', $data);
        user_log('buka data agenda', 'fa-folder-open-o');
	}
    
    function datagenda()
	{
		$this->load->model('agenda_model');
		
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->agenda_model->datacount($search);
        $config['base_url'] = base_url().'transactions/datagenda/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'AGENDA';
        $data['datas'] = $this->agenda_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/datagenda', $data);
	}
    
    function addagenda()
	{
		$this->load->model('agenda_model');
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		
		$data = $this->data;
		$data['caption'] = 'AGENDA BARU';
		$data['page'] = $page;
		$data['search'] = $search;
		
        $this->load->view('transactions/addagenda', $data);
        user_log('buka form agenda baru', 'fa-plus');
	}
		
	function editagenda()
	{
		$this->load->model('agenda_model');
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		
		$data = $this->data;
		$data['caption'] = 'UBAH AGENDA';
		$data['datas'] = $this->agenda_model->dataid($id);
		$data['page'] = $page;
		$data['search'] = $search;
        
		$this->load->view('transactions/addagenda', $data);
        user_log('buka form ubah agenda', 'fa-edit');
	}
	
    function combovideo()
    {
        $this->load->model('video_model');
        $data = array();
        $key = ($this->input->post('txtkey') != '' ? $this->input->post('txtkey') : null);
        $data = $this->video_model->datacombo($key);
        
        echo json_encode($data);
    }
    
    function activeagenda()
	{
		$this->load->model('agenda_model');
		$id = $this->uri->segment(5);
        
        $data = $this->agenda_model->active($id);
        user_log('enable/disable data agenda', 'fa-check-square-o');

        echo json_encode($data);
	}
    
    function delagenda()
	{
		$this->load->model('agenda_model');
		$data = array();
        $search = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $data = $this->agenda_model->delete($search, $page, $id);
        user_log('hapus data agenda `'.$id.'`: '.$data['title'], 'fa-trash-o');
        
		echo json_encode($data);
	}
	
    function deldetagenda()
	{
		$this->load->model('agenda_model');
		$data = array();
        $name = ($this->uri->segment(3) != "" ? $this->uri->segment(3) : null);
        $id = ($this->uri->segment(4) != "" ? $this->uri->segment(4) : null);
        $data = $this->agenda_model->deletedetail($name, $id);
        user_log('hapus data berkas `'.$name.'`: '.$data['title'], 'fa-trash-o');
        
		echo json_encode($data);
	}
    
	function updateagenda()
	{
		$this->load->model('agenda_model');
        $data = array();
		$caption = $this->input->post('caption');
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		
		if ($this->agenda_model->validation())
		{
			if ($caption == 'UBAH AGENDA')
			{
				$data = $this->agenda_model->update();
                user_log('simpan perubahan data agenda', 'fa-save');
			}
			else
			{
				$data = $this->agenda_model->insert();
                user_log('simpan data agenda baru', 'fa-save');
			}
		}
		else
		{
			if (form_error('txtcode'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Kolom Kode Kosong!', 'elfocus' => '#txtcode');
            elseif (form_error('txtname'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Kolom Nama Kosong!', 'elfocus' => '#txtname');
		}
        
        echo json_encode($data);
	}
    
    function absensi()
	{
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->absensi_model->datacount($search);
        $config['base_url'] = base_url().'transactions/databsensi/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'ABSENSI';
        $data['datas'] = $this->absensi_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/absensi', $data);
        user_log('buka data terima berkas', 'fa-folder-open-o');
	}
    
    function databsensi()
	{
		$this->load->model('absensi_model');
		
		if ($this->uri->segment(3) != '')
			$search = $this->uri->segment(3);
		elseif ($this->input->post('txtsearch') != null)
			$search = $this->input->post('txtsearch');
		else
			$search = 'null';
			
		/*pagination*/
		$n = $this->absensi_model->datacount($search);
        $config['base_url'] = base_url().'transactions/databsensi/'.$search;
		$config['total_rows'] = $n;
		$config['per_page'] = $this->config->item('show_data');
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		
		$data = $this->data;
        $data['caption'] = 'ABSENSI';
        $data['datas'] = $this->absensi_model->datalist($search, $page, $this->config->item('show_data'));
        $data['page'] = $page;
        $data['search'] = $search;
        $data['paging'] = $this->pagination->create_links();
        
		$this->load->view('transactions/databsensi', $data);
	}
    
    function addabsensi()
	{
		$this->load->model('absensi_model');
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		
		$data = $this->data;
		$data['caption'] = 'ABSENSI BARU';
		$data['page'] = $page;
		$data['search'] = $search;
		
        $this->load->view('transactions/addabsensi', $data);
        user_log('buka form terima berkas baru', 'fa-plus');
	}
		
	function editabsensi()
	{
		$this->load->model('absensi_model');
		$search = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		
		$data = $this->data;
		$data['caption'] = 'UBAH ABSENSI';
		$data['datas'] = $this->absensi_model->dataid($id);
		$data['page'] = $page;
		$data['search'] = $search;
        
		$this->load->view('transactions/addabsensi', $data);
        user_log('buka form ubah terima berkas', 'fa-edit');
	}
	
    function activeabsensi()
	{
		$this->load->model('absensi_model');
		$id = $this->uri->segment(5);
        
        $data = $this->absensi_model->active($id);
        user_log('enable/disable data terima berkas', 'fa-square-check-o');

        echo json_encode($data);
	}
    
    function delabsensi()
	{
		$this->load->model('absensi_model');
		$data = array();
        $search = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $data = $this->absensi_model->delete($search, $page, $id);
        user_log('hapus data terima berkas `'.$id.'`: '.$data['title'], 'fa-trash-o');
        
		echo json_encode($data);
	}
	
    function deldetabsensi()
	{
		$this->load->model('absensi_model');
		$data = array();
        $name = ($this->uri->segment(3) != "" ? $this->uri->segment(3) : null);
        $id = ($this->uri->segment(4) != "" ? $this->uri->segment(4) : null);
        $data = $this->absensi_model->deletedetail($name, $id);
        user_log('hapus data terima berkas `'.$name.'`: '.$data['title'], 'fa-trash-o');
        
		echo json_encode($data);
	}
    
	function updateabsensi()
	{
		$this->load->model('absensi_model');
        $data = array();
		$caption = $this->input->post('caption');
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		
		if ($this->absensi_model->validation())
		{
			if ($caption == 'UBAH ABSENSI')
			{
				$data = $this->absensi_model->update();
                user_log('simpan perubahan data absensi', 'fa-save');
			}
			else
			{
				$data = $this->absensi_model->insert();
                user_log('simpan data absensi baru', 'fa-save');
			}
		}
		else
		{
			if (form_error('txtcode'))
				$data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Kolom Kode Kosong!', 'elfocus' => '#txtcode');
            elseif (form_error('txtname'))
                $data = array('title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Kolom Nama Kosong!', 'elfocus' => '#txtname');
		}
        
        echo json_encode($data);
	}
}

/* End of file transactions.php */
/* Lotypesion: ./applitypesion/controllers/transactions.php */