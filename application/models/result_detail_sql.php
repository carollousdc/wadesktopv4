<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Result_detail_sql extends MY_model {
    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "result_detail";
        $this->tabel_prefix = "RSD";
        $this->column_order = array(null, 'id', 'kontak', 'name'); //field yang ada di table user
        $this->column_search = array('id', 'kontak', 'name'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
        $this->changeHeaderName = ['id' => 'Nama / No.HP', 'name' => 'Pesan Masuk', 'create_date' => 'Tanggal', 'm_status' => 'Status'];
        $this->validate_format = ['CB', 'CP', 'SET', 'SH'];
    }
}