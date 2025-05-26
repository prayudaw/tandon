<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_model extends CI_Model
{

    public $table = 'anggota';
    public $column_order = array('no_mhs', 'nama', 'angkatan', 'status');
    public $column_search = array('no_mhs', 'nama', 'angkatan'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    public $order = array('no_mhs' => 'desc'); // default order

    public $db_siprus;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function getAnggotaById($no_mhs)
    {  
        $this->db->from($this->table);
        $this->db->where('no_mhs', $no_mhs);
        $this->db->join('fakultas', 'fakultas.kd_fakultas = anggota.kd_fakultas', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

}

/* End of file ModelName.php */
