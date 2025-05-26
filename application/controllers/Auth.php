<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	
	}

	public function index()
	{
		$check=$this->auth_model->current_user();
		//var_dump($check);die();
		 if ($check == 1) {
              redirect(INDEX_URL.'dashboard');
         }
		$this->load->view('login_form');
	}

	public function login()
	{   
		
		$username = $this->input->post('username');
	    $password = md5($this->input->post('password'));

		if ($this->auth_model->login($username, $password)) {
			$response = array(
				'status' => 1,
				'message' => 'Berhasil login',
			);
		}
		else{
			$response = array(
				'status' => 2,
				'message' => 'Data Tidak Ditemukan',
			);
		}
		echo json_encode($response);
	}

	public function logout()
	{
		$this->load->model('auth_model');
		$this->auth_model->logout();
		redirect(site_url(INDEX_URL.'login'));
	}
}
