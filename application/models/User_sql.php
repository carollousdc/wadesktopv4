<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_sql extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "user";
        $this->column_order = array(null, 'id', 'email', 'firstname', 'gender', 'role'); //field yang ada di table user
        $this->column_search = array('id', 'email', 'firstname', 'gender', 'role'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
        $this->changeHeaderName = ['last_login' => 'Login Terakhir', 'id_whatsapp' => 'Nomor Whatsapp'];
    }

    public function get_field_data()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = ['no'];
        $res = array_merge($res, $allfield);
        $res = array_reverse(array_reverse(array_diff($res, ["is_active", "last_login", "picture", "lastname", "password", "role", "notification", "is_active", "process_date", "creator", "status"])));
        return $res;
    }

    public function get_validate_data()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["creator", "create_date", "status"])));
        return $res;
    }

    public function get_validate_data_edit()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["is_active", "last_login", "picture", "password", "role", "notification", "picture", "creator", "status"])));
        return $res;
    }

    public function get_change_field()
    {
        $res = parent::get_change_field();
        $khusus = [
            "name" => function ($value) {
                return $this->master->get(['id' => $value->id])->firstname;
            },
            "firstname" => function ($value) {
                return $value->firstname . " " . $value->lastname;
            },
            "gender" => function ($value) {
                return $this->gender[$value->gender];
            },
            "role" => function ($value) {
                return $this->role->get(['id' => $value->role])->name;
            },
            "picture" => function ($value) {
                $html = "<div class='user-panel' id='image'><img src=file/" . $value->picture . " class='img-circle elevation-2' id='editFoto' alt='User Image'></img></div>";
                if (empty($html)) {
                    $html = "-";
                }

                return $html;
            },
        ];
        $res = array_merge($res, $khusus);
        return $res;
    }
} //End
