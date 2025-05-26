<?php
// require APPPATH . '/core/BaseController.php';

class Tanggungan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('transaksi_model');
        $this->load->model('anggota_model');
        $check=$this->auth_model->current_user();
		if ($check != 1) {
            redirect(INDEX_URL.'login');
        }
    }

    public function index()
    {  
        $data['getTanggungan']=$this->transaksi_model->getTanggungan();
        $data['jumlahTanggungan']=$this->transaksi_model->getJumTanggungan();
        $data['page_title'] = 'Tanggungan';
        $this->load->view('dashboard/tanggungan', $data);
    }

    



}