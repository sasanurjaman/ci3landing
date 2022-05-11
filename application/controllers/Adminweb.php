<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adminweb extends CI_Controller 
{
	public function __construct()
    {
		parent::__construct();		
    }
        
    function index()
	{
		if (get_cookie('rememberme_token') == true) 
		{
			$users = explode('|', get_cookie('rememberme_token'));
			$data = array(
				'username' => $users[0],
                'activation' => 'N',
				'remember' => 'checked'
			);
			$this->load->view('login', $data);
		}
		else 
		{
			$data = array(
				'username' => '',
                'activation' => 'N',
				'remember' => ''
			);
			$this->load->view('login', $data);
		}
	}

	function do_login()
	{
		$data = array();
		$username = $this->input->post('txtusername');
		$password = md5($this->input->post('txtpassword'));
		$remember = $this->input->post('txtremember');
		
		if ($remember == 1) 
		{
			$cookie = array(
				'name' => 'rememberme_token',
				'value' => $username.'|'.session_id(),
				'expire' => 86500,
				'domain' => '.' . $_SERVER['SERVER_NAME'],
				'path' => '/',
				'secure' => isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : 0
			);
			set_cookie($cookie);
		} 
		else 
		{
			if (get_cookie('rememberme_token') == true) 
				delete_cookie('rememberme_token');
		}
		
        if ($this->login_model->validation() == true)
		{
			$row = $this->login_model->data($username, $password);
            if ($row != false) 
            {
				if ($row->aktif == 'Y') 
                {
					$user_sesi = array(
						'SESS_USER_ID' => $row->userid,
						'SESS_USER_NAME' => $row->nama,
						'SESS_USER_PHOTO' => $row->foto,
						'SESS_USER_LEVEL' => $row->level,
						'SESS_USER_REGISTER' => $row->daftar,
						'SESS_USER_LOGIN' => $row->login
					);
					$this->session->set_userdata($user_sesi);
					
                    /*remove tmp file user*/
                    array_map('unlink', glob('./tmp/'.$row->userid.'*'));
                    
                    $data = array(
						'dashboardlink' => base_url().'dashboard',
                        'title' => 'Berhasil', 'notif' => 'modal-success', 'messg' => 'login pengguna: berhasil'
                    );
                    user_log('login pengguna: berhasil', 'fa-sign-in');
				} 
                else 
                {
					if (get_cookie('rememberme_token') == true) 
					{
						$users = explode('|', get_cookie('rememberme_token'));
						$data = array(
							'username' => $users[0],
							'remember' => 'checked',
                            'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data pengguna belum diaktifkan!'
						);
					}
					else 
					{
						$data = array(
							'username' => '',
							'remember' => '',
                            'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Data pengguna belum diaktifkan!'
						);
					}
                    user_log('login pengguna: gagal - pengguna belum diaktifkan', 'fa-ban');
				}
			} 
            else 
            {
				if (get_cookie('rememberme_token') == true) 
				{
					$users = explode('|', get_cookie('rememberme_token'));
					$data = array(
						'username' => $users[0],
						'remember' => 'checked',
                        'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Nama Pengguna dan KataSandi tidak sama!'
					);
				}
				else 
				{
					$data = array(
						'username' => '',
						'remember' => '',
                        'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => 'Nama Pengguna dan KataSandi tidak sama!'
					);
				}
                user_log('login pengguna: gagal - pengguna tidak ada', 'fa-ban');
			}
		}
		else
		{
			$cookie_username = (get_cookie('rememberme_token') ? stristr(get_cookie('rememberme_token'), '|', true) : null);
            $cookie_remember = (get_cookie('rememberme_token') ? 'checked' : null);
            if (form_error("txtusername"))
            {
                $data = array(
                    'username' => $cookie_username,
					'remember' => $cookie_remember,
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => form_error('txtusername'), 'focus' => '#txtusername'
                );
            }
            else if (form_error("txtpassword"))
            {
				$data = array(
                    'username' => $cookie_username,
					'remember' => $cookie_remember,
                    'title' => 'Kesalahan', 'notif' => 'modal-danger', 'messg' => form_error('txtpassword'), 'focus' => '#txtpassword'
                );
            }
		}
        
        echo json_encode($data);
	}
}
