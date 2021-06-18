<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Navigation extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
        $this->change_tipe_manual['tipe'] = ['Master Menu', 'Root', 'Single'];
        $this->change_option['tipe'] = ['where' => [], 'must' => 1, 'custom' => $this->change_tipe_manual['tipe']];
        $this->disabled = ['root'];
    }

    function ambilData() {
        $data = [];
        $field = $this->master->gets();
        foreach ($field as $key => $value) {
            $data[$key] = $value;
            if (empty($value->link)) {
                $data[$key]->link = '-';
            }

            if (!empty($value->root)) {
                $val = $this->master->getRoot($value->root);
                $data[$key]->root = $val->name;
            } else {
                $data[$key]->root = "-";
            }

        }
        echo json_encode($data);
    }

    public function editroot() {
        $data_key = [];
        $data = $this->master->get(['id' => $this->input->post('id')]);
        $count_data = $this->master->get_validate_data_edit();

        foreach ($count_data as $key => $val) {
            if (!in_array($val, $this->disabled)) {
                $data_key[$key] = $val;
            }
        }

        $output = array(
            "data" => $data,
            "key" => $data_key,
            "key_count" => count($data_key),
        );
        echo json_encode($output);
    }

    function optionRoot() {
        $result = "";
        $masterdata = $this->master->gets(['tipe' => 0, 'status' => 0]);
        empty($this->input->post('tipe')) ? $tipe = 0 : $tipe = $this->input->post('tipe');
        if ($tipe == 1) {
            $display = true;
            foreach ($masterdata as $key => $value) {
                $result .= '<option value=' . $value->id . '>' . $value->name . '</option>';
            }
        } else {
            $display = false;
        }

        $output = array(
            'preview' => $result,
            'display' => $display,
        );
        echo json_encode($output);
    }

    function optionRootedit() {
        $result = "";
        $masterdata = $this->master->gets(['tipe' => 0, 'status' => 0]);
        empty($this->input->post('tipe_edit')) ? $tipe_edit = 0 : $tipe_edit = $this->input->post('tipe_edit');
        if ($tipe_edit == 1) {
            $display = true;
            foreach ($masterdata as $key => $value) {
                $result .= '<option value=' . $value->id . '>' . $value->name . '</option>';
            }
        } else {
            $display = false;
        }

        $output = array(
            'preview' => $result,
            'display' => $display,
        );
        echo json_encode($output);
    }
} //End