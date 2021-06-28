<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kesimpulan_sql extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "omset_detail";
        $this->column_order = array(null, 'id', 'kontak'); //field yang ada di table user
        $this->column_search = array('id', 'kontak'); //field yang diizin untuk pencarian
        $this->order = array('angka2d' => 'DESC'); // default order
    }

    public function get_field_data()
    {
        $res = ['angka2d', 'jumlah'];
        return $res;
    }

    public function get_validate_data()
    {
        $res = ['angka2d', 'jumlah'];
        return $res;
    }

    public function get_validate_data_edit()
    {
        $res = ['angka2d', 'jumlah'];
        return $res;
    }

    public function get_change_field()
    {
        $res = parent::get_change_field();
        $khusus = [
            "angka2d" => function ($value) {
                if ($value->format == '2') {
                    return intval($value->angka);
                }
            },
            "jumlah" => function ($value) {
                if ($value->format == '2') {
                    return $value->hasil;
                }
            },
        ];
        $res = array_merge($res, $khusus);
        return $res;
    }

    public function get_action($value, $edit, $delete, $no)
    {

        $value->no = $no;
        return $value;
    }

    public function getsSum($where = "", $group_by = "", $order = "", $where_in = "")
    {
        if (empty($where)) {
            $where = array("m.status" => 0);
        }
        if (empty($order)) {
            $this->db->order_by('angka', 'ASC');
        }
        if (!empty($group_by)) {
            $this->db->select('angka');
            $this->db->select('sum(hasil) as hasil');
            $this->db->select('count(*) as count');
            $this->db->group_by('angka');
        }

        if (!empty($where_in)) {
            $this->db->where_in('format', $where_in);
        }

        $query = $this->db->get_where($this->tabel . " m", $where);
        return $query->result();
    }

    public function getsFormatSum($where = "", $group_by = "", $order = array(), $where_in = "")
    {
        if (empty($where)) {
            $where = array("m.status" => 0);
        }
        if (empty($order)) {
            $this->db->order_by('angka', 'ASC');
        } else $this->db->order_by($order[0], $order[1]);
        if (!empty($group_by)) {
            $this->db->select('angka');
            $this->db->select('sum(hasil) as hasil');
            $this->db->select('count(*) as count');
            $this->db->select('format');
            $this->db->group_by('angka');
        }

        if (!empty($where)) {
            $this->db->where_in('format', $where_in);
        }

        $query = $this->db->get_where($this->tabel . " m", $where);
        return $query->result();
    }

    public function getsWhereIn($where = "", $group_by = "")
    {
        if (empty($where)) {
            $where = array("m.status" => 0);
        }
        if (!empty($group_by)) {
            $this->db->select('angka');
            $this->db->select('sum(hasil) as hasil');
            $this->db->select('count(*) as count');
            $this->db->group_by('angka');
        }

        $query = $this->db->get_where($this->tabel . " m", $where);
        return $query->result();
    }
}
