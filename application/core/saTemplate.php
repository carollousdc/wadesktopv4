<?php
defined('BASEPATH') or exit('No direct script access allowed');
class saTemplate extends CI_Controller
{
    public $data;
    public $viewpage = "";
    protected $change_data = [];
    public $master;
    public $main;
    public $change_name;

    public function __construct($path = "", $in = "", $detail = "")
    {
        parent::__construct();
        $this->data = $_POST;
        $this->data['cssFile'] = "";
        $this->data['jsFile'] = "";
        $this->data['info'] = "";
        $this->data['headData'] = "";
        $this->data['isiData'] = "";
        $this->data["blank"] = "";
        $this->data["input_form"] = "";
        $this->data['edit_form'] = "";
        $this->validate = [];
        $this->change_option = [];
        $this->change_data = [];
        $this->change_data_edit = [];
        $this->change_data_model = [];
        $this->change_primary_name = "";
        $this->change_column_name = "";
        $this->change_tipe = [];
        $this->change_tipe_manual = [];
        $this->remove_data_edit = [];
        $this->remove_data_hapus = [];
        $this->datatable_where = [];
        $this->disabled = [];
        $this->to_change = [];
        $this->select_change = [];
        $this->change_format_data = [];
        $this->change_header_name = [];
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

        if (!empty($_SESSION['id'])) {
            $this->creator = $this->user->get(['id' => $_SESSION['id']])->id;
            $this->session_whatsapp = $this->user->get(['id' => $_SESSION['id']]);
            $this->my_api_whatsapp = $this->dashboard->get(['id' => 'BB1'])->apikey;
        }
    }

    public function index()
    {

        if ($this->navigation->get(['link' => $this->main])) {
            $this->data['menu'] = $this->navigation->get(['link' => $this->main]);
        } else {
            $this->data['menu'] = $this->main;
        }

        (!empty($this->data['menu']->root)) ? $this->data['masterMenu'] = $this->navigation->get(['id' => $this->data['menu']->root]) : $this->data['masterMenu'] = $this->data['menu'];

        $this->data['engine'] = $this->engine;

        $validateColNum = [1, 12, 6, 4, 3, 2, 4, 3, 3, 12];
        if (!empty($this->master)) {
            $this->data['tableHeader'] = $this->master->getHeaderName();
            $value_change = array();
            foreach ($this->master->get_field_type(1) as $keyd) {
                if (in_array($keyd->name, $this->master->get_field_data())) {
                    isset($this->master->changeHeaderName[$keyd->name]) ? $value_change = $this->master->changeHeaderName[$keyd->name] : $value_change = $keyd->name;
                    if (!in_array($keyd->name, $this->disabled)) {
                        $this->data['input_form'] .= '<div class="p-2 w-100">';
                        if (isset($this->change_option[$keyd->name])) {
                            $this->data['input_form'] .= $this->master->getFormField($keyd->name, 'option', $this->change_option[$keyd->name]);
                        } else {
                            $type = $keyd->type;
                            $this->data['input_form'] .= $this->master->getFormField($keyd->name, $type);
                        }
                        $this->data['input_form'] .= '</div>';
                    } else {
                        $this->data['input_form'] .= '<div id="' . $keyd->name . '_display">';
                        $this->data['input_form'] .= '<div class="p-2 w-100">';
                        $this->data['input_form'] .= '<label for="name">' . ucwords($value_change) . '</label>' . $this->master->optionOnly($keyd->name);
                        $this->data['input_form'] .= '</div>';
                        $this->data['input_form'] .= '</div>';
                    }
                }
            }
            (empty($this->change_primary_name)) ? $p_name = "id" : $p_name = $this->change_primary_name;
            $this->data['edit_form'] .= '<div class="form-group">';
            if ($this->main !== 'user') {
                $this->data['edit_form'] .= '<input type="hidden" id="' . $p_name . '_edit" name="' . $p_name . '_edit">';
            }
            $this->data['edit_form'] .= '<input type="hidden" id="creator_edit" name="creator_edit" value="' . $this->creator . '">';
            foreach ($this->master->get_field_type() as $keyd) {
                if (!in_array($keyd->name, $this->disabled)) {
                    if (isset($this->change_option[$keyd->name])) {
                        $this->data['edit_form'] .= $this->master->getFormFieldEdit($keyd->name, 'option', $this->change_option[$keyd->name]);
                    } else {
                        $type = $keyd->type;
                        $this->data['edit_form'] .= $this->master->getFormFieldEdit($keyd->name, $type);
                    }
                } else {
                    $this->data['edit_form'] .= '<div id="' . $keyd->name . '_edit_display">';
                    $this->data['edit_form'] .= '<label for="name">' . ucwords($keyd->name) . '</label>' . $this->master->optionOnly($keyd->name . '_edit');
                    $this->data['edit_form'] .= '</div>';
                }
            }
            $this->data['edit_form'] .= '</div>';
        }

        $noPermission = ['dashboard'];
        if (!empty($this->main)) {
            if ($this->navigation->get(['second_id' => $this->main]) && !in_array($this->main, $noPermission)) {
                $validateMenu = $this->navigation->get(['second_id' => $this->main])->id;
                if ($this->permission->get(['role' => $_SESSION['role'], 'menu' => $validateMenu]) || $_SESSION['role'] == 1) {
                    $getMenu = $this->main;
                } else {
                    $getMenu = "dashboard";
                }
            } else {
                $getMenu = $this->main;
            }
        } else {
            $getMenu = $this->main;
        }

        if ($this->data['menu'] == $this->main) {
            $validate_asset = 'error404';
        } else {
            $validate_asset = $this->main;
        }

        $this->data['cssFile'] .= '<link rel="stylesheet" href="' . base_url() . 'asset/css/' . $validate_asset . '.css">';
        $this->data['jsFile'] .= '<script src="' . base_url() . 'asset/js/' . $validate_asset . '.js"></script>';
        $this->load->view('header', $this->data);
        $this->load->view($getMenu, $this->data);
        $this->load->view('footer', $this->data);
    }

    public function get_data()
    {
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
        foreach ($list as $data_val) {
            $data_val = $this->master->get_action($data_val, $edit, $delete, ++$start);
            $row = array();
            foreach ($this->master->get_field_data_full() as $k => $val_header) {
                if (isset($this->change_data[$val_header])) {
                    $row[] = $this->change_data[$val_header]($data_val);
                } else if (isset($data_val->$val_header)) {
                    $row[] = $data_val->$val_header;
                } else {
                    $row[] = "-";
                }
            }

            $data[] = $row;
        }
        $output = array(
            "post" => $this->input->post(),
            "draw" => $draw,
            "query" => $query,
            "recordsTotal" => $this->master->count_all($where),
            "recordsFiltered" => $this->master->count_filtered($search, $order, $where),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function tambahData()
    {
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

        $data['creator'] = $this->creator;
        if (empty($data['id'])) {
            $data['id'] = $this->master->getLastId();
        }

        $data = $this->master->add($data);
        echo json_encode($data);
    }

    public function ambilData()
    {
        $data = $this->master->gets();
        echo json_encode($data);
    }

    public function ambilDataById()
    {
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

    public function hapusData()
    {
        $where[$this->change_primary_name] = $this->input->post('id');
        $data = $this->master->delete($where);
        echo json_encode($data);
    }

    public function perbaruiData()
    {
        $data = [];
        $where = [];
        foreach ($this->input->post() as $key => $value) {
            $key = explode("_edit", $key);
            if ($key[0] !== $this->change_primary_name) {
                $data[$key[0]] = $value;
            } else {
                $where[$key[0]] = $value;
            }
        }

        if (empty($data['creator'])) {
            $data['creator'] = $this->creator;
        }

        $result = $this->master->edit($data, $where);
        echo json_encode($result);
    }

    public function reset()
    {
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

    public function getRootLink()
    {
        $data = $this->navigation_sql->get(['link' => $this->main]);
        $getTitle = $this->navigation_sql->get(['second_id' => $this->main]);
        if (!empty($data->root)) {
            $getRootLink = $this->navigation_sql->get(['id' => $data->root])->second_id;
        } else {
            $getRootLink = $this->navigation_sql->get(['link' => $this->main])->second_id;
        }

        $title = "WHATSAPP API | " . $getTitle->name;

        $output = array(
            "data" => $getRootLink,
            "title" => $title,
        );
        echo json_encode($output);
    }

    public function getSidebar()
    {
        $this->data['sidebar'] = "";
        $this->data['navbar'] = '<li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>';
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

        $getsNavbar = $this->navigation_sql->gets(['tipe' => 1, 'root' => 1, 'status' => 0], 0, ['urutan', 'ASC']);
        foreach ($getsNavbar as $key => $value) {
            $this->data['navbar'] .= '<li class="nav-item d-none d-sm-inline-block"><a href="' . $value->link . '" class="nav-link">' . $value->name . '</a></li>';
        }

        $output = array(
            "data" => $this->data['sidebar'],
            "navbar" => $this->data['navbar'],
        );
        echo json_encode($output);
    }

    public function getNotifMessage()
    {
        $count_message = $this->pesan->gets(['m_status !=' => 1, 'status' => 0]);
        $data['valueNotif'] = "";

        $data['countNotification'] = $this->load->view('notification/count_notif', ['count' => count($count_message)], true);

        foreach ($count_message as $key => $value) {
            empty($this->kontak->get(['phone' => $value->kontak, 'status' => 0])) ? $value->kontak : $value->kontak = $this->kontak->get(['phone' => $value->kontak, 'status' => 0])->name;
            $changeImage = $this->navigation_sql->changeImageUrl($value->name, "100px", 2, $value);
            $data['valueNotif'] .= $this->load->view('notification/value_notif', ['value' => $value, 'content' => $changeImage, 'sender' => $value->kontak], true);
        }
        $preview = $this->load->view('notification/preview', $data, true);

        $output = array(
            "value" => $preview,
        );
        echo json_encode($output);
    }

    public function editData()
    {
        $data_key = [];
        $option_key = [];
        $data = $this->master->get(['id' => $this->input->post('id')]);
        $count_data = $this->master->get_validate_data_edit();

        foreach ($count_data as $key => $val) {
            if (!in_array($val, $this->disabled) && empty($this->change_option[$val])) {
                $data_key[$key] = $val;
            } else {
                if (!empty($this->change_option[$val])) {
                    $option_key[$key] = $val;
                }
            }
        }

        if ($this->main !== 'navigation') {
            if ($check_contact = $this->kontak->get(['id' => $this->input->post('id'), 'status' => 0])) {
                $get_contact = $check_contact->name;
            } else {
                $get_contact = $this->input->post('id');
            }
            $output = array(
                "data" => $data,
                "kontak" => $get_contact,
                "key" => $data_key,
                "option_key" => $option_key,
                "key_count" => count($data_key),
            );
        } else {
            $output = array(
                "data" => $data,
                "key" => $data_key,
                "key_count" => count($data_key),
            );
        }

        echo json_encode($output);
    }
}
