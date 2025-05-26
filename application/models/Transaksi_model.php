<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Transaksi_model extends CI_Model
{  
	private $table = "tandon";
    private $column_order = array('nim','barcode','judul','penulis','penerbit','tgl_pinjam','tgl_kembali','op_pinjam','op_kembali');
    private $column_search = array('nim','barcode','judul','penulis','penerbit','tgl_pinjam','tgl_kembali','op_pinjam','op_kembali');
    private $order = array('tgl_pinjam' => 'desc');
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
	}


    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop kolom 
        {  
       $Search=$this->input->post('search');

       
            if ($Search['value']) // jika datatable mengirim POST untuk search
            {
                if ($i === 0) // looping pertama
                {
                    $this->db->group_start();
                    $this->db->like($item, $Search['value']);
                } else {
                    $this->db->or_like($item, $Search['value']);
                }
                if (count($this->column_search) - 1 == $i) //looping terakhir
                    $this->db->group_end();
            }
            $i++;
        }


          ## Search
        if (!empty($_POST['searchNim'])) {
              $this->db->where('nim like "%' . $_POST['searchNim'] . '%"');
        }

        if (!empty($_POST['searchTanggal'])) {
               $tgl = explode(" - ", $_POST['searchTanggal']);
               $tgl1 = date('y-m-d', strtotime($tgl[0]));
               $tgl2 = date('y-m-d', strtotime($tgl[1]));
                $this->db->where("tgl_pinjam BETWEEN '" . $tgl1 . " 00:00:00' and '" . $tgl2 . " 23:00:00'");
        }


        // jika datatable mengirim POST untuk order
        if ($this->input->post('order')) {
            $Order=$this->input->post('order');
            $this->db->order_by($this->column_order[$Order['0']['column']], $Order['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($now = false)
    {
        $this->_get_datatables_query();

        if ($now == true) {
            $date = date('y-m-d');
            $this->db->where("tgl_pinjam LIKE '%" . $date . "%'");
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        return $query->result();
    }

    function count_filtered($now = false)
    {
        $this->_get_datatables_query();
        if ($now == true) {
            $date = date('y-m-d');
            $this->db->where("tgl_pinjam LIKE '%" . $date . "%'");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($now = false)
    {
        $this->db->from($this->table);
        if ($now == true) {
            $date = date('y-m-d');
            $this->db->where("tgl_pinjam LIKE '%" . $date . "%'");
        }
        return $this->db->count_all_results();
    }


        public function getDataPengunjungExcel($tanggal)
    {
        $tanggal1 = explode("-", $tanggal);
        $start = date_create($tanggal1[0]);
        $start1 = date_format($start, "Y-m-d");
        $end = date_create($tanggal1[1]);
        $end1 = date_format($end, "Y-m-d");
        $query = $this->db->query('SELECT nim,barcode,judul,penulis,tgl_pinjam,tgl_kembali,op_pinjam,op_kembali FROM `tandon` WHERE tgl_pinjam BETWEEN "' . $start1 . ' 00:00:00" AND "' . $end1 . ' 23:00:00"');
        return $query->result();
    }


    public function insertTransaksi($data)
    {
        $this->db->insert('tandon', $data);

        return $this->db->insert_id();
    }

    public function getBukuByBarcode($no_barcode){
        $this->db->from('item_buku');
        $this->db->where('no_barcode', $no_barcode);
        $this->db->join('buku', 'buku.kd_buku = item_buku.kd_buku', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTransaksiByBarcode($no_barcode){
        $this->db->from('tandon');
        $this->db->where('barcode', $no_barcode);
        $this->db->where('tgl_kembali', '0000-00-00');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getTransaksiHariIni() {
        $this->db->from('tandon');
        $this->db->where('DATE(tgl_pinjam) = CURRENT_DATE()');
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function getTransaksiHariIniBelumKembali() {
        $this->db->from('tandon');
        $this->db->where('DATE(tgl_pinjam) = CURRENT_DATE()');
        $this->db->where('tgl_kembali','0000-00-00');
        $query = $this->db->get();
        return $query->num_rows();
        
    }

    public function getTanggungan() {
        $this->db->from('tandon');
        $this->db->where('tgl_pinjam < CURDATE()');
        $this->db->where('tgl_kembali','0000-00-00');
        $query = $this->db->get();
        return $query->result_array();
        
    }

    public function getJumTanggungan() {
        $this->db->from('tandon');
        $this->db->where('tgl_pinjam < CURDATE()');
        $this->db->where('tgl_kembali','0000-00-00');
        $query = $this->db->get();
        return $query->num_rows();
        
    }

    public function updateTransaksi($barcode){
        $this->db->set('tgl_kembali',date('Y-m-d H:i:s'));
        $this->db->set('op_kembali',$this->session->userdata('inisial'));
        $this->db->where('barcode', $barcode);
        $this->db->update('tandon');
    }

    public function getPeminjamanDalamSeminggu()
    {  
       
        $query = $this->db->query('SELECT DATE(tgl_pinjam) AS tgl_pinjam,DATE_FORMAT(tgl_pinjam, "%d %M") AS tgl, COUNT(tgl_pinjam) AS jumlah FROM `tandon` WHERE DATE(tgl_pinjam) > (NOW() - INTERVAL 7 DAY) GROUP BY DATE(tgl_pinjam)');
        return $query->result_array();

    }

     public function getStatistik()
      {
        //$query = $this->db->query('SELECT DATE(tgl_pinjam) AS tgl_pinjam,DATE_FORMAT(tgl_pinjam, "%d %M") AS tgl, COUNT(tgl_pinjam) AS jumlah FROM `tandon` WHERE DATE(tgl_pinjam) > (NOW() - INTERVAL 7 DAY) GROUP BY  DATE(tgl_pinjam)');
        $query = $this->db->query('select date_format(tgl_pinjam, "%M %Y") as blnTahun, count(tgl_pinjam) as jml
        from tandon
        where year(tgl_pinjam) = year(now()) or year(tgl_pinjam) = year(now()) - 1
        group by month(tgl_pinjam), year(tgl_pinjam) 
        order by year(tgl_pinjam) asc, month(tgl_pinjam) asc limit 0,24');
        return $query->result_array();
      }

      public function jumlahPemustaka($bulantahun)
      {
        $query = $this->db->query('SELECT COUNT(DISTINCT nim) AS jmlNim FROM tandon
    WHERE DATE_FORMAT(tgl_pinjam,"%M %Y") LIKE "' . $bulantahun . '" group by day(tgl_pinjam) ');
        $q = $query->result_array();
        $jumlah = 0;
        foreach ($q as $key => $value) {
          $jumlah += $value['jmlNim'];
        }
        return $jumlah;
      }

      function most_viwer_booked()
      {
        $query = $this->db->query("select count(barcode) as jumlah,barcode,judul from tandon group by barcode ORDER BY jumlah DESC LIMIT 5");
        return $query->result_array();
      }




}