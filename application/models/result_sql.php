<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Result_sql extends MY_model {
    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "result";
        $this->tabel_prefix = "RS";
        $this->column_order = array(null, 'id', 'name'); //field yang ada di table user
        $this->column_search = array('id', 'name'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
        $this->changeHeaderName = ['id' => 'Nama / No.HP', 'name' => 'Pesan Masuk', 'create_date' => 'Tanggal'];
        $this->validate_format = ['CB', 'CP', 'SET', 'SH'];
    }
}