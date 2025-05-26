<?php
// require APPPATH . '/core/BaseController.php';

class Peminjaman extends CI_Controller
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
        $data['page_title'] = 'Transaksi Peminjaman';
        $this->load->view('dashboard/peminjaman', $data);
    }


    public function inputPeminjam()
    {   
        $nim = $this->input->post('nim');
        $barcode = $this->input->post('barcode');
        $tamu = $this->input->post('tamu');

        $status='';
        
        //jika tamu meminjam
        if($tamu == true){
            $get_buku=$this->transaksi_model->getBukuByBarcode($barcode);
            $check_pinjaman=$this->transaksi_model->getTransaksiByBarcode($barcode);
          
            if(empty($get_buku)){
                $status=0;
                $message = 'Buku Tidak Ditemukan';
            }
            elseif (!empty($check_pinjaman)) {
                $status=0;
                $message = 'Buku Masih Dalam Pinjaman';
            }
            else {
                $status=1;
                $this->checkout($nim,$get_buku);
                $status = 1;
                $message = 'Berhasil';
            }

        }
        else{
            //check anggota
            $get_data_anggota = $this->anggota_model->getAnggotaById($nim);
            if (empty($get_data_anggota)) {
                $status=0;
                $message = 'Gagal Data Pemustaka Tidak Ditemukan Silakan Menghubungi Petugas';
            } else if (count($get_data_anggota) > 0) {
                if ($get_data_anggota['status'] == 'P') {
                    $status=0;
                    $message = 'Keanggotaan Tidak Aktif';
                } elseif ($get_data_anggota['status'] == 'BP') {
                    $status=0;  
                    $message = 'Mahasiswa Sudah Bebas Pustaka';
                } else {
                    $get_buku=$this->transaksi_model->getBukuByBarcode($barcode);
                    if(empty($get_buku)){
                        $status=0;
                        $message = 'Buku Tidak Ada';
                    }
                    else {
                        $status=1;
                        $this->checkout($nim,$get_buku);
                        $status = 1;
                        $message = 'Berhasil';
                    }
                  
                }
            }

        }
        

        // $getData = $this->transaksi_model->getDataPengunjungMingguan();
        $data = array(
            'status' => $status,
            'message' =>$message,
        );
        echo json_encode($data);
    }

    private function checkout($nim,$get_buku)
    {
        $dataInsert = array(
            'nim' => $nim,
            'barcode' => $get_buku['no_barcode'],
            'judul' => $get_buku['judul'],
            'penulis' => $get_buku['penulis1'],
            'penerbit' => $get_buku['penerbit'],
            'tgl_pinjam' => date('Y-m-d H:i:s'),
            'op_pinjam' => $this->session->userdata('inisial')  
        );
        $this->transaksi_model->insertTransaksi($dataInsert);
    }



}