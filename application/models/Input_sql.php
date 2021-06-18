<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Input_sql extends MY_model {
    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "pesan";
        $this->column_order = array(null, 'id'); //field yang ada di table user
        $this->column_search = array('id', 'kontak', 'name'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
    }
} //End
