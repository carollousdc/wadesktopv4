<?php
defined('BASEPATH') or exit('No direct script access allowed');
class saTemplate extends CI_Controller {
    public $data;
    public $viewpage = "";
    protected $change_data = [];
    public $master;
    public $main;
    public $change_name;

    public function __construct($path = "", $in = "", $detail = "") {
        parent::__construct();
        $this->data = $_POST;
        $this->data['cssFile'] = "";
        $this->data['jsFile'] = "";
        $this->data['info'] = "";
        $this->data['headData'] = "";
        $this->data['isiData'] = "";
        $this->data["blank"] = "";
        $this->data["input_form"] = "";
        $this->data["edit_form"] = "";
        $this->validate = [];
        $this->change_option = [];
        $this->change_data = [];
        $this->change_data_edit = [];
        $this->change_data_model = [];
        $this->change_primary_name = [];
        $this->change_tipe = [];
        $this->change_tipe_manual = [];
        $this->remove_data_edit = [];
        $this->remove_data_hapus = [];
        $this->remove_action_edit = 0;
        $this->remove_action_delete = 0;
        $this->datatable_where = [];
        $this->disabled = [];
        $this->to_change = [];
        $this->select_change = [];
        $this->change_format_data = [];
        $this->change_header_name = [];
        $this->my_api_whatsapp = "6YYYBG2COJH11HVLKROA";
        if (!empty($path)) {
            $this->main = $path;
            $this->load->model('navigation_sql', "navigation");
            if (empty($in)) {
                $this->load->model($this->main . '_sql', "link");
                $this->master = $this->link;
                if (!empty($detail)) {
                    $this->load->model($this->main . '_detail_sql', "link_arr");
                    $this->master_arr = $this->link_arr;
                }
            } else {
                $this->master = "";
            }

        }
        $this->engine = $this->dashboard->get(['id' => 'BB1']);
        if (empty($this->change_primary_name)) {
            $this->change_primary_name = "id";
        }
    }

    public function index() {
        $this->data['menu'] = $this->navigation->get(['link' => $this->main]);
        (!empty($this->data['menu']->root)) ? $this->data['masterMenu'] = $this->navigation->get(['id' => $this->data['menu']->root]) : $this->data['masterMenu'] = $this->data['menu'];

        $this->data['engine'] = $this->engine;

        $validateColNum = [1, 12, 6, 4, 3, 2, 3, 4, 6, 12];
        if (!empty($this->master)) {
            $this->data['tableHeader'] = $this->master->getHeaderName();
            $count = count($this->master->get_validate_data());
            $value_change = array();
            foreach ($this->master->get_validate_data() as $key => $value) {
                (isset($this->change_name[$value])) ? $value_change = $this->change_name[$value] : $value_change = $value;
                if (!in_array($value, $this->change_data)) {
                    $this->data['input_form'] .= '<div class="input-group mb-3">
                    <div class="input-group-prepend">';
                    $this->data['input_form'] .= '<span class="input-group-text"><i class="fas fa-check"></i></span></div>';
                    if (empty($this->data[$value])) {
                        $this->data[$value] = 0;
                    }

                    foreach ($this->master->get_field_type() as $k) {
                        if (!in_array($value, $this->change_data)) {
                            if ($k->name == $value && $k->type == 'int') {
                                $this->data['input_form'] .= '<input type="number" class="form-control" name="' . $value . '" required="required" placeholder="' . ucwords($value_change) . '">';
                            }

                            if ($k->name == $value && $k->type == 'varchar') {
                                $this->data['input_form'] .= '<input type="text" class="form-control" name="' . $value . '" required="required" placeholder="' . ucwords($value_change) . '">';
                            }

                            if ($k->name == $value && $k->type == 'text') {
                                $this->data['input_form'] .= '<textarea class="form-control" name="' . $value . '" required="required" placeholder="' . ucwords($value_change) . '"></textarea>';
                            }

                            if ($k->name == $value && $k->type == 'date') {
                                $this->data['input_form'] .= '<input type="date" class="form-control" name="' . $value . '" required="required" placeholder="' . ucwords($value_change) . '">';
                            }

                        }
                    }
                    $this->data['input_form'] .= '</div>';
                } else {
                    if (!in_array($value, $this->disabled)) {
                        $this->data['input_form'] .= '<div class="input-group mb-3">
                        <div class="input-group-prepend">';
                        $this->data['input_form'] .= '<span class="input-group-text"><i class="fas fa-check"></i></span></div>';
                        if (empty($this->data[$value])) {
                            $this->data[$value] = $this->tipe->gets(['role' => $this->main])[0]->id;
                        }

                        $this->data['input_form'] .= $this->tipe->option($value, $this->data[$value], ['role' => $this->main], 1);
                        $this->data['input_form'] .= '</div>';
                    }
                }
            }

            (empty($this->change_primary_name)) ? $p_name = "id" : $p_name = $this->change_primary_name;
            $this->data['edit_form'] .= '<input type="hidden" id="' . $p_name . '_edit" name="' . $p_name . '_edit">';
            foreach ($this->master->get_validate_data() as $key => $value) {
                $this->data['edit_form'] .= '<div class="form-group">';
                foreach ($this->master->get_field_type() as $k) {

                    if (!in_array($value, $this->remove_data_edit)) {
                        (isset($this->change_header_name[$value])) ? $value_change = $this->change_header_name[$value] : $value_change = $value;
                        if ($k->name == $value && $k->type == 'int') {
                            $this->data['edit_form'] .= '<label for="name">' . ucwords($value_change) . '</label><input type="number" class="form-control" name="' . $value . '_edit" id="' . $value . '_edit" required="required">';
                        }

                        if ($k->name == $value && $k->type == 'varchar') {
                            $this->data['edit_form'] .= '<label for="name">' . ucwords($value_change) . '</label><input type="text" class="form-control" name="' . $value . '_edit" id="' . $value . '_edit" required="required">';
                        }

                        if ($k->name == $value && $k->type == 'date') {
                            $this->data['edit_form'] .= '<label for="name">' . ucwords($value_change) . '</label><input type="date" class="form-control" name="' . $value . '_edit" id="' . $value . '_edit" required="required">';
                        }

                        if ($k->name == $value && $k->type == 'text') {
                            $this->data['edit_form'] .= '<label for="name">' . ucwords($value_change) . '</label><textarea class="form-control" name="' . $value . '_edit" id="' . $value . '_edit"></textarea>';
                        }

                    }

                }
                $this->data['edit_form'] .= '</div>';
            }
        }

        $noPermission = ['dashboard'];
        if (!empty($this->main)) {
            if ($this->navigation->get(['second_id' => $this->main]) && !in_array($this->main, $noPermission)) {
                $validateMenu = $this->navigation->get(['second_id' => $this->main])->id;
                if ($this->permission->get(['role' => $_SESSION['role'], 'menu' => $validateMenu]) || $_SESSION['role'] == 1) {
                    $getMenu = $this->main;
                } else {
                    $getMenu = "error404";
                }

            } else {
                $getMenu = $this->main;
            }

        } else {
            $getMenu = $this->main;
        }

        $this->data['cssFile'] .= '<link rel="stylesheet" href="' . base_url() . 'asset/css/' . $this->main . '.css">';
        $this->data['jsFile'] .= '<script src="' . base_url() . 'asset/js/' . $this->main . '.js"></script>';
        $this->load->view('header', $this->data);
        $this->load->view($getMenu, $this->data);
        $this->load->view('footer', $this->data);
    }

    public function get_data() {
        $where = $this->input->post('where');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        $length = $this->input->post('length');
        $start = $this->input->post('start');
        $edit = $this->input->post('edit');
        $delete = $this->input->post('delete');
        $draw = $this->input->post('draw');
        $where = $this->input->post('where');

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (in_array($key, $this->master->get_field_name())) {
                    $where['m.' . $key] = $value;
                    unset($where[$key]);
                }
            }
        }

        if (empty($this->change_data)) {
            $this->change_data = $this->master->get_change_field();
        }

        $list = $this->master->gets_datatable($length, $start, $search, $order, $where);
        $query = $this->db->last_query();
        $data = array();
        $no = 1;
        foreach ($list as $value) {
            $row = array();
            $row[] = $no++;
            foreach ($this->master->get_validate_data() as $k => $val) {
                if ($val == 'time') {
                    $row[] = gmdate("F j, Y, G:i:s", $value->$val);
                } else if (!empty($this->change_tipe_manual[$val])) {
                    $row[] = $this->change_tipe_manual[$val][$value->$val];
                } else {
                    if (in_array($val, $this->change_data_model)) {
                        if (!empty($value->$val)) {
                            (isset($this->to_change_model[$val])) ? $x = $this->to_change_model[$val] : $x = $val;
                            (empty($this->select_change_model[$val])) ? $y = $k : $y = $this->select_change_model[$val];
                            $row[] = $this->$x->get([$y => $value->$val])->name;
                        } else {
                            $row[] = "-";
                        }

                    } else {
                        if (in_array($val, $this->change_option)) {
                            if (!empty($value->$val)) {
                                $row[] = $this->$val->get(['id' => $value->$val])->name;
                            } else {
                                $row[] = "-";
                            }

                        } else {
                            if (is_numeric($value->$val) && in_array($val, $this->validate)) {
                                if (!empty($this->change_format_data[$val])) {
                                    $row[] = $value->$val . " " . $this->change_format_data[$val];
                                } else {
                                    $row[] = number_format($value->$val, 2, ",", ".");
                                }

                            } else {
                                $row[] = $value->$val;
                            }

                        }
                    }
                }
            }

            (empty($this->change_primary_name)) ? $p_name = "id" : $p_name = $this->change_primary_name;
            (!empty($value->m_status)) ? $value->m_status : $value->m_status = 0;
            (empty($this->remove_action_edit)) ? $btn_edit = '<button data-id="' . $value->$p_name . '" class="btn btn-primary btn_edit">Proses</button>' : $btn_edit = '';
            (empty($this->remove_action_delete)) ? $btn_delete = '<button style="margin-left: 5px;" data-id="' . $value->$p_name . '" class="btn btn-danger btn_hapus">Hapus</button>' : $btn_delete = '';

            $row[] = $btn_edit . $btn_delete;

            $data[] = $row;
        }
        $output = array(
            "recordsTotal" => $this->master->count_all(),
            "recordsFiltered" => $this->master->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function tambahData() {
        $data = [];
        foreach ($this->input->post() as $key => $value) {
            $data[$key] = $value;
        }

        if (!empty($data['password'])) {
            $cost = 8;
            do {
                $cost++;
                $start = microtime(true);
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ["cost" => $cost]);
                $end = microtime(true);
            } while (($end - $start) < $timeTarget);
        }

        $data = $this->master->add($data);
        echo json_encode($data);
    }

    public function ambilData() {
        $data = $this->master->gets();
        echo json_encode($data);
    }

    public function ambilDataById() {
        $where[$this->change_primary_name] = $this->input->post('id');
        $data = $this->master->get($where);
        $data_key = [];
        $count_data = $this->master->get_validate_data_edit();

        foreach ($count_data as $key => $val) {
            $data_key[$key] = $val;
        }

        $output = array(
            "data" => $data,
            "key" => $data_key,
            "key_count" => count($count_data),
        );
        echo json_encode($output);
    }

    public function hapusData() {
        $where[$this->change_primary_name] = $this->input->post('id');
        $data = $this->master->delete($where);
        echo json_encode($data);
    }

    public function perbaruiData() {
        $data = [];
        foreach ($this->input->post() as $key => $value) {
            $key = explode("_edit", $key);
            $data[$key[0]] = $value;
        }
        (empty($this->change_primary_name)) ? $p_name = "id" : $p_name = $this->change_primary_name;
        $result = $this->master->edit($data, [$p_name => $data[$p_name]]);
        echo json_encode($result);
    }

    public function reset() {
        $id = "temporary";
        if ($this->master->delete(['id' => $id])) {
            $this->master_arr->delete([$this->main => $id]);
            $flag = true;
        }

        $output = array(
            "status" => $flag,
        );
        echo json_encode($output);
    }

    public function getRootLink() {
        $data = $this->navigation_sql->get(['link' => $this->main]);
        $getTitle = $this->navigation_sql->get(['second_id' => $this->main]);
        if (!empty($data->root)) {
            $getRootLink = $this->navigation_sql->get(['id' => $data->root])->second_id;
        } else {
            $getRootLink = $this->navigation_sql->get(['link' => $this->main])->second_id;
        }

        $title = "BAKMI PELITA 2 | " . $getTitle->name;

        $output = array(
            "data" => $getRootLink,
            "title" => $title,
        );
        echo json_encode($output);
    }

    public function validateName() {
        $flag = [];
        if ($this->master->get(['name' => $this->input->post('name')])) {
            $flag['validity'] = 1;
        } else {
            $flag['validty'] = 2;
        }

        $output = array(
            "data" => intval($flag['validity']),
        );
        echo json_encode($output);
    }

    public function getSidebar() {
        $this->data['sidebar'] = "";
        $this->data['navbar'] = "";
        $mainTipe = $this->navigation_sql->getsTipe();
        if (!empty($mainTipe)) {
            foreach ($mainTipe as $key => $value) {
                if ($this->permission->get(['role' => $_SESSION['role'], 'menu' => $value->id]) || $_SESSION['role'] == 1) {
                    $this->data['sidebar'] .= '<li class="nav-item has-treeview" id="' . $value->second_id . '1">';
                    $this->data['sidebar'] .= '<a href="#" class="nav-link" id="' . $value->second_id . '">';
                    $this->data['sidebar'] .= '<i class="' . $value->icon . '"></i>';
                    $this->data['sidebar'] .= '<p>' . $value->name . '<i class="right fas fa-angle-left"></i></p></a>';
                    $this->data['sidebar'] .= '<ul class="nav nav-treeview" id="nav">';
                    $secondTipe = $this->navigation->getsSecondTipe($value->id);
                    if (!empty($secondTipe)) {
                        foreach ($secondTipe as $k => $val) {
                            $this->data['sidebar'] .= '<li class="nav-item">';
                            $this->data['sidebar'] .= '<a href="' . $val->link . '" id="' . $val->second_id . '" class="nav-link">';
                            $this->data['sidebar'] .= '<i class="' . $val->icon . '"></i>';
                            $this->data['sidebar'] .= '<p>' . $val->name . '</p>';
                            $this->data['sidebar'] .= '</a></li>';
                        }
                        $this->data['sidebar'] .= '</ul></li>';
                    } else {
                        $this->data['sidebar'] .= '</ul></li>';
                    }

                }
            }
        }
        $this->data['sidebar'] .= '<br />';
        $otherTipe = $this->navigation_sql->getsTipe(2);
        if (!empty($otherTipe)) {
            foreach ($otherTipe as $key => $value) {
                $this->data['sidebar'] .= '<li class="nav-item" id="' . $value->second_id . '1">';
                $this->data['sidebar'] .= '<a href="' . $value->link . '" class="nav-link" id="' . $value->second_id . '">';
                $this->data['sidebar'] .= '<i class="' . $value->icon . '"></i>';
                $this->data['sidebar'] .= '<p>' . $value->name . '</p></a></li>';
            }
        }

        $getsNavbar = $this->navigation_sql->gets(['tipe' => 1, 'root' => 1, 'status' => 0]);
        foreach ($getsNavbar as $key => $value) {
            $this->data['navbar'] .= '<li class="nav-item d-none d-sm-inline-block"><a href="' . $value->link . '" class="nav-link">' . $value->name . '</a></li>';
        }

        $output = array(
            "data" => $this->data['sidebar'],
            "navbar" => $this->data['navbar'],
        );
        echo json_encode($output);
    }

    public function getNotifMessage() {
        $count_message = '<span class="badge badge-danger navbar-badge">';
        $count_message .= count($this->pesan->gets(['m_status =' => 0, 'status' => 0]));
        $count_message .= '</span>';

        $data['countNotification'] = $this->load->view('notification/count_notif', ['count' => $count_message], true);
        $data['valueNotif'] = $this->load->view('notification/value_notif', ['value' => "masuk"], true);
        $value = $this->load->view('notification/preview', $data, true);

        $output = array(
            "value" => $value,
        );
        echo json_encode($output);
    }
}
