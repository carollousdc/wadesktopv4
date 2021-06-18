<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_asli_sql extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "pesan";
        $this->tabel_prefix = "OK";
        $this->column_order = array(null, 'id', 'kontak', 'name'); //field yang ada di table user
        $this->column_search = array('id', 'kontak', 'name'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
    }
}
