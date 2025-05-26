<?php
// require APPPATH . '/core/BaseController.php';

class Pengembalian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('transaksi_model');
        $this->load->model('anggota_model');
        $check=$this->auth_model->current_user();
        //var_dump($check);die();
		if ($check != 1) {
            redirect(INDEX_URL.'login');
        }
    }

    public function index()
    {  
        $data['page_title'] = 'Pengembalian';
        $this->load->view('dashboard/pengembalian', $data);
    }

    public function proses_kembali()
    {   
        $barcode = $this->input->post('barcode');
        //check transaksi
        $check_buku_pinjaman = $this->transaksi_model->getTransaksiByBarcode($barcode); 
        //var_dump($check_buku_pinjaman);die();
        $status='';
        $message='';
        if(count($check_buku_pinjaman) == 0){
            $status=0;
            $message = 'Buku Tidak Dalam Pinjaman';
        }
        else {
            $update=$this->update($barcode);
            $status=1;
            $message = 'Proses Pengembalian Berhasil';
        } 
        
        $data = array(
            'status' => $status,
            'message' =>$message,
        );
        echo json_encode($data);
    }

    private function update($barcode)
    {
        $this->transaksi_model->updateTransaksi($barcode);
    }



}