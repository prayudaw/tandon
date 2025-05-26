<?php
// require APPPATH . '/core/BaseController.php';
class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('transaksi_model');
        $check = $this->auth_model->current_user();
        //var_dump($check);die();
        if ($check != 1) {
            redirect(INDEX_URL . 'login');
        }
    }

    public function index()
    {
        $data['page'] = 'Dashboard';
        $data['most_viewed_book'] = $this->transaksi_model->most_viwer_booked();
        $this->load->view('dashboard/home', $data);
    }



    public function getStatistik()
    {
        $getpinjam = $this->transaksi_model->getStatistik();

        // get data statistik
        $getData = array();
        foreach ($getpinjam as $key => $value) {
            $jumlah_pemustaka = $this->transaksi_model->jumlahPemustaka($value['blnTahun']);
            // echo $jumlah_pemustaka;
            $getData[$key]['jumlah_koleksi'] = $value['jml'];
            $getData[$key]['blnTahun'] = $value['blnTahun'];
            $getData[$key]['jumlah_pemustaka'] = $jumlah_pemustaka;
        }

        $data = array(
            'status' => true,
            'data' => $getData,
        );

        echo json_encode($data);
    }
}