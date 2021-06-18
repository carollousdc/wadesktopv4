<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan_sql extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $this->tabel = "pesan";
        $this->tabel_prefix = "WA";
        $this->column_order = array(null, 'id', 'kontak', 'name'); //field yang ada di table user
        $this->column_search = array('id', 'kontak', 'name'); //field yang diizin untuk pencarian
        $this->order = array('id' => 'asc'); // default order
        $this->changeHeaderName = ['id' => 'Nama / No.HP', 'name' => 'Pesan Masuk', 'create_date' => 'Tanggal', 'm_status' => 'Status'];
    }
    public function get_field_data()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = ['no'];
        $res = array_merge($res, $allfield);
        $res = array_reverse(array_reverse(array_diff($res, ["id", "id_whatsapp", "process_date", "creator", "status"])));
        return $res;
    }

    public function get_validate_data()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["id_whatsapp", "process_date", "creator", "status"])));
        return $res;
    }

    public function get_validate_data_edit()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["id", "kontak", "m_status", "id_whatsapp", "process_date", "creator", "status", "create_date"])));
        return $res;
    }

    public function get_change_field()
    {
        $res = parent::get_change_field();
        $khusus = [
            "m_status" => function ($value) {
                return $this->status_name[$value->m_status];
            },
            "name" => function ($value) {
                if (parse_url($value->name, PHP_URL_PATH) == true) {
                    $viewImage = "<div style='width:350px;max-height:500px;'>" . $this->changeImageUrl($value->name, "350px", 1, $value->id) . "</div>";
                    return $viewImage;
                } else {
                    return "<div style='width:350px;max-height:500px;'>" . $value->name . "</div>";
                }
            },
            "create_date" => function ($value) {
                return $value->create_date;
            },
            "kontak" => function ($value) {
                $check_user = $this->kontak->get(['phone' => $value->kontak, 'status' => 0]);
                empty($check_user) ? $value->kontak = $value->kontak . '  <button data-id="' . $value->kontak . '" type="button" class="btn btn-xs btn-info btnAddkontak"><i class="fas fa-save"></i> Save</button>' : $value->kontak = $check_user->name;
                return $value->kontak;
            },
        ];
        $res = array_merge($res, $khusus);
        return $res;
    }

    public function get_action($value, $edit, $delete, $no)
    {

        empty($this->change_primary_name) ? $change_name_id = "id" : $change_name_id = $this->change_primary_name;
        $change_data = $this->get_change_field();
        $value->id = $value->$change_name_id;
        if (empty($this->remove_action_edit)) {
            if ($value->m_status != 1) {
                $editBtn = '<button data-id="' . $value->id . '" class="btn btn-primary btn_edit form-control">Proses</button>';
            } else {
                $editBtn = "";
            }
        } else {
            $editBtn = "";
        }

        if (empty($this->remove_action_delete)) {
            if ($value->m_status == 1) {
                $auto_width = 'form-control';
            } else {
                $auto_width = "";
            }

            $deleteBtn = '<button data-id="' . $value->id . '" class="btn btn-danger ' . $auto_width . ' btn_hapus form-control">Hapus</button>';
        } else {
            $deleteBtn = "";
        }

        $value->action = "<div class='form-group'>" . $editBtn . "</div>" . "<div class='form-group'>" . $deleteBtn . "</div>";
        $value->no = $no;
        return $value;
    }

    public function gets_datatable($length, $start, $search, $order, $where)
    {
        $where = ['process_date' => date('Y-m-d'), 'm_status !=' => 1];
        $this->gets_query($search, $order);
        if ($length != -1) {
            $this->db->limit($length, $start);
        }
        return $this->gets($where);
    }
} //End
