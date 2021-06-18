<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Navigation_sql extends MY_model {

    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "navigation";
        $this->tabel_prefix = "OK";
        $this->column_order = array(null, 'root');
        $this->column_search = array('name', 'root'); //field yang diizin untuk pencarian
        $this->order = array('root'); // default order
        $this->change_tipe_manual = ['Master Menu', 'Root', 'Single'];
    }

    public function getsItem() {
        $this->db->select("name");
        $this->db->group_by("name");
        $query = $this->db->get($this->tabel);
        return $query->result();
    }

    public function getRoot($root) {
        $this->db->where('id', $root);
        $query = $this->db->get($this->tabel);
        return $query->row();
    }

    public function getsTipe($tipe = 0) {
        $this->db->where('tipe', $tipe);
        if ($tipe == 2) {
            $this->db->order_by('urutan', 'ASC');
        } else {
            $this->db->order_by('name', 'ASC');
        }

        $query = $this->db->get($this->tabel);
        return $query->result();
    }

    public function getsSecondTipe($root = "") {
        $this->db->where('root', $root);
        $this->db->order_by('urutan', 'ASC');
        $query = $this->db->get($this->tabel);
        return $query->result();
    }

    public function get_action($value, $edit, $delete, $no) {

        empty($this->change_primary_name) ? $change_name_id = "id" : $change_name_id = $this->change_primary_name;
        $change_data = $this->get_change_field();
        $value->name = isset($change_data["name"]) ? $change_data["name"]($value) : $value->name;
        $value->$change_name_id = $value->$change_name_id;
        if (empty($this->remove_action_edit)) {
            $editBtn = '<button data-id="' . $value->id . '" class="btn btn-primary form-control editroot">Edit</button>';
        } else {
            $editBtn = "";
        }

        if (empty($this->remove_action_delete)) {
            $deleteBtn = '<button data-id="' . $value->id . '" class="form-control btn btn-danger btn_hapus">Hapus</button>';
        } else {
            $deleteBtn = "";
        }

        $value->action = "<div class='form-group'>" . $editBtn . "</div>" . "<div class='form-group'>" . $deleteBtn . "</div>";
        $value->no = $no;
        return $value;
    }

    public function get_field_data() {
        $allfield = $this->db->list_fields($this->tabel);
        $res = ['no'];
        $res = array_merge($res, $allfield);
        $res = array_reverse(array_reverse(array_diff($res, ["id", "second_id", "creator", "status", "create"])));
        return $res;
    }

    public function get_validate_data() {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["id", "creator", "status", "create"])));
        return $res;
    }

    public function get_validate_data_edit() {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["id", "second_id", "creator", "status", "create"])));
        return $res;
    }

    public function get_change_field() {
        $res = parent::get_change_field();
        $khusus = [
            "tipe" => function ($value) {
                return $this->change_tipe_manual[$value->tipe];
            },
            "root" => function ($value) {
                if (empty($value->root)) {
                    return "No Root";
                } else {
                    return $this->get(['id' => $value->root])->name;
                }
            },
        ];
        $res = array_merge($res, $khusus);
        return $res;
    }
} //End
