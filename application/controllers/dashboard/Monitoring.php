<?php
// require APPPATH . '/core/BaseController.php';

class Monitoring extends CI_Controller
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
        $data['getTransaksiNow']=$this->transaksi_model->getTransaksiHariIni();
        $data['jumlahBelumKembali']=count($this->transaksi_model->getTransaksiHariIni());
        $data['page_title'] = 'Monitoring';
        $this->load->view('dashboard/monitoring', $data);
    }

    



}