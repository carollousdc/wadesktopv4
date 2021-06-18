<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Format_sql extends MY_model {
    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "format";
        $this->tabel_prefix = "FM";
        $this->column_order = array(null, 'name'); //field yang ada di table user
        $this->column_search = array('name'); //field yang diizin untuk pencarian
        $this->order = array('name' => 'asc'); // default order
    }

    public function get_field_data() {
        $allfield = $this->db->list_fields($this->tabel);
        $res = ['no'];
        $res = array_merge($res, $allfield);
        $res = array_reverse(array_reverse(array_diff($res, ["id", "creator", "create", "create_date", "status"])));
        return $res;
    }

    public function get_validate_data() {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["id", "creator", "create", "create_date", "status"])));
        return $res;
    }
} //End
