<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_detail_sql extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "pesan_detail";
        $this->tabel_prefix = "WA";
        $this->column_order = array(null, 'id', 'name'); //field yang ada di table user
        $this->column_search = array('id', 'name'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
        $this->changeHeaderName = ['name' => 'Pesan Masuk', 'create_date' => 'Tanggal', 'm_status' => 'Status'];
    }
} //End
