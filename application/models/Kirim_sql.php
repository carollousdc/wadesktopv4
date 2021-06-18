<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kirim_sql extends MY_model {
    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "kirim";
        $this->column_order = array(null, 'id'); //field yang ada di table user
        $this->column_search = array('id'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
        $this->changeHeaderName = ['name' => 'Pesan'];
        $this->remove_action_edit = 1;
    }

    public function get_field_data() {
        $allfield = $this->db->list_fields($this->tabel);
        $res = ['no'];
        $res = array_merge($res, $allfield);
        $res = array_reverse(array_reverse(array_diff($res, ["id", "kontak", "create_date", "creator", "status"])));
        return $res;
    }

    public function getHeaderName() {
        $TableHeader = "<thead><tr>";
        $fieldName = $this->get_field_data();
        foreach ($fieldName as $key => $value) {
            if (!empty($this->changeHeaderName[$value])) {
                $TableHeader .= "<th>" . $this->changeHeaderName[$value] . "</th>";
            } else {
                $TableHeader .= "<th>" . ucwords($value) . "</th>";
            }

        }
        $TableHeader .= "<th>Action</th>";
        $TableHeader .= "</tr></thead>";
        return $TableHeader;
    }

    public function get_change_field()
    {   
        $res = parent::get_change_field();
        $khusus = [
            "name" => function ($value) {
                $html_view = "<div style='width:auto;'>". $value->name ."</div>";
                return $html_view;
            },
        ];
        $res = array_merge($res, $khusus);
        return $res;
    }
} //End
