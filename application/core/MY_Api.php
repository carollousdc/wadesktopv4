<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class MY_Api extends REST_Controller {
    protected $tabel_model;
    protected $change_data = [];
    protected $change_code = [];
    protected $system_fill = [];
    protected $unset_fill = [];
    protected $change_keyArrData = [];
    protected $id_keyArrData = [];
    protected $tabel_arr_model = [];
    protected $option_format = [];
    protected $required = [];
    protected $can_empty = [];
    protected $validFileType = array("image/jpeg", "image/jpg", "image/png", "image/bmp");

    function __construct() {
        // Construct the parent class
        parent::__construct();
    }
    public function server_side_post() {
        $search = $this->post('search');
        $order = $this->post('order');
        $length = $this->post('length');
        $start = $this->post('start');
        $edit = $this->post('edit');
        $delete = $this->post('delete');
        $draw = $this->post('draw');
        $where = $this->post('where');
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (in_array($key, $this->tabel_model->get_field_name())) {
                    $where['m.' . $key] = $value;
                    unset($where[$key]);
                }
            }
        }
        if (empty($this->change_data)) {
            $this->change_data = $this->tabel_model->get_change_field();
        }

        $list = $this->tabel_model->gets_datatable($length, $start, $search, $order, $where);
        $query = $this->db->last_query();
        $data = array();
        foreach ($list as $data_val) {
            $data_val = $this->tabel_model->get_action($data_val, $edit, $delete, ++$start);
            $row = array();
            foreach ($this->tabel_model->get_field_data_full() as $val_header) {
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
            "recordsTotal" => $this->tabel_model->count_all(),
            "recordsFiltered" => $this->tabel_model->count_filtered($search, $order, $where),
            "data" => $data,
        );

        $this->set_response($output, REST_Controller::HTTP_OK);
    }
    public function index_delete() {
        $id = $this->delete('id');
        $delete = $this->delete('delete');
        $creator = $this->delete('creator');
        if ($id === null || $delete === null || $creator === null) {
            $this->set_response([
                'status' => FALSE,
                'message' => "Access Denied",
            ], REST_Controller::HTTP_OK);
        } else {
            if ($delete) {
                if (empty($this->change_data)) {
                    $this->change_data = $this->tabel_model->get_change_field();
                }

                $data_val = $this->tabel_model->get(['id' => $id, 'status' => 0]);
                $data_name = isset($this->change_data["name"]) ? $this->change_data["name"]($data_val) : $data_val->name;
                if (!empty($data_val)) {
                    if ($this->tabel_model->delete(['id' => $id], $creator)) {
                        $this->set_response([
                            'status' => TRUE,
                            'message' => "<strong>" . $data_name . "</strong> was successfully deleted.",
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => "<strong>" . $data_name . "</strong> was unsuccessfully deleted.",
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => "Id not found",
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => "Access Denied",
                ], REST_Controller::HTTP_OK);
            }
        }
    }
    private function getArrData($id) {
        $this->change_keyArrData['id'] = isset($this->change_keyArrData['id']) ? $this->change_keyArrData['id'] : $this->tabel_model->tabel;
        $arrData = [];
        foreach ($this->post() as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $val) {
                    if (!empty($val)) {
                        if (!isset($arrData[$k][$id])) {
                            $key_id = isset($this->change_keyArrData['id']) ? $this->change_keyArrData['id'] : 'id';
                            $arrData[$k][$key_id] = $id;
                        }
                        $keychange = isset($this->change_keyArrData[$key]) ? $this->change_keyArrData[$key] : $key;
                        $arrData[$k][$keychange] = $val;
                    }
                }
            }
        }
        return $arrData;
    }
    private function insertedOtherTable($id, $creator) {
        $arrData = $this->getArrData($id);

        foreach ($this->tabel_arr_model as $arr_table) {
            $arr_table['tabel']->delete([$this->change_keyArrData['id'] => $id], $creator);
            foreach ($arrData as $value) {
                if (isset($arr_table["data"])) {
                    foreach ($arr_table["data"] as $key => $key_data) {
                        $data_input[$key_data] = $value[$key];
                    }
                } else {
                    $data_input = $value;
                }

                if (!empty($arr_table['tabel']->get($data_input))) {
                    //update
                    $arr_table['tabel']->activate($data_input, $creator);
                } else {
                    //added
                    $arr_table['tabel']->insert($data_input);
                }
            }
        }
    }
    public function index_post() {
        $creator = $this->post('creator');
        if ($creator === null) {
            $this->set_response([
                'status' => FALSE,
                'message' => "Access Denied",
            ], REST_Controller::HTTP_OK);
        } else {
            if (empty($this->change_data)) {
                $this->change_data = $this->tabel_model->get_change_field();
            }

            $data = [];
            foreach ($this->post() as $key => $value) {
                if (!is_array($value) && !in_array($key, $this->unset_fill)) {
                    if (!empty($value)) {
                        $data[$key] = $value;
                    } else {
                        if (in_array($key, $this->can_empty)) {
                            $data[$key] = $value;
                        }
                    }
                }

            }
            if (count($_FILES) > 0) {
                $validFileType = array("image/jpeg", "image/jpg", "image/png", "image/bmp");
                $max_size_upload = 2048 * 1024; //2mb
                foreach ($_FILES as $key => $value) {
                    if (in_array($key, $this->can_empty)) {
                        $data[$key] = NULL;
                        $data[$key . "_tipe"] = NULL;
                    }
                    if (is_uploaded_file($value['tmp_name'])) {
                        if ($value['size'] > $max_size_upload) {
                            $this->set_response([
                                'status' => FALSE,
                                'message' => "<strong>" . $value['name'] . "</strong> size exceeds 2MB.",
                            ], REST_Controller::HTTP_OK);
                            exit;
                        } else {
                            $propertiesgambar = getimageSize($value['tmp_name']);
                            if (!in_array($propertiesgambar['mime'], $validFileType)) {
                                $this->set_response([
                                    'status' => FALSE,
                                    'message' => "<strong>" . $value['name'] . "</strong> is not image file.",
                                ], REST_Controller::HTTP_OK);
                                exit;
                            } else {
                                $data[$key] = file_get_contents($value['tmp_name']);
                                $data[$key . "_tipe"] = $propertiesgambar['mime'];
                            }
                        }
                    }
                }
            }
            if (!empty($this->system_fill)) {
                foreach ($this->system_fill as $key => $value) {
                    $data[$key] = $value($data);
                }
            }
            if (in_array("id", $this->tabel_model->field_id)) {
                if (empty($data['id'])) {
                    $code = "";
                    if (isset($this->change_code['function'])) {
                        $code = $this->change_code['function']($data);
                    }

                    $data['id'] = $this->tabel_model->getLastId(0, $code);
                }
            }
            $dataID = [];
            foreach ($this->tabel_model->field_id as $value) {
                $dataID[$value] = $data[$value];
            }
            $dataID['status'] = 0;
            $validasi_data = $this->tabel_model->get($dataID);
            if (!empty($validasi_data)) {
                $this->insertedOtherTable($dataID, $creator);
                $data_name = isset($this->change_data["name"]) ? $this->change_data["name"]($data) : $data['name'];
                //update
                if ($this->tabel_model->edit($data, $dataID)) {
                    $this->set_response([
                        'status' => TRUE,
                        'message' => "<strong>" . $data_name . "</strong> was successfully updated.",
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => "<strong>" . $data_name . "</strong> was unsuccessfully updated.",
                    ], REST_Controller::HTTP_OK);
                }
            } else {
                //added
                $this->insertedOtherTable($dataID, $creator);
                $data_name = isset($this->change_data["name"]) ? $this->change_data["name"]($data) : $data['name'];

                if ($this->tabel_model->insert($data)) {
                    $this->set_response([
                        'status' => TRUE,
                        'message' => "<strong>" . $data_name . "</strong> was successfully added.",
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => "<strong>" . $data_name . "</strong> was unsuccessfully added.",
                    ], REST_Controller::HTTP_OK);
                }
            }
        }
    }
    public function img_get() {
        if (!is_null($this->get('id')) && !is_null($this->get('field'))) {
            $where = ["status" => 0, "id" => $this->get('id')];
            $searchID = $this->tabel_model->gets($where);
            if (!empty($searchID)) {
                $value = (array) $searchID[0];
                $tipe = $value[$this->get('field') . "_tipe"];
                $img = $value[$this->get('field')];
                header("Content-type: " . $tipe);
                echo $img;
            }
        }
    }
    public function upload_img_post() {
        if (count($_FILES) > 0) {
            $validFileType = $this->validFileTipe;
            $max_size_upload = 2048 * 1024; //2mb
            $file_name_upload = array_keys($_FILES)[0];
            $file_upload = $_FILES[$file_name_upload];
            $data_name = $file_upload['name'];
            $fileExt = pathinfo(basename($data_name), PATHINFO_EXTENSION);
            if ($file_upload['size'] > $max_size_upload) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => "<strong>" . $data_name . "</strong> size exceeds 2MB.",
                ], REST_Controller::HTTP_OK);
            } else {
                if (!in_array($file_upload['type'], $validFileType)) {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => "<strong>" . $data_name . "</strong> is not image file.",
                    ], REST_Controller::HTTP_OK);
                } else {
                    $location = "upload";
                    if (!file_exists($location)) {
                        $oldmask = umask(0);
                        mkdir($location, 0777);
                        umask($oldmask);
                    }
                    $tipe_file = explode("-", $file_name_upload)[0];
                    $location .= "/" . $tipe_file;
                    if (!file_exists($location)) {
                        $oldmask = umask(0);
                        mkdir($location, 0777);
                        umask($oldmask);
                    }
                    $location .= "/";

                    $date = date('Ymd');
                    $i = 1;
                    $target_file = $location . $date . "_" . $tipe_file . "_" . $i . "." . $fileExt;
                    while (file_exists($target_file)) {
                        $i++;
                        $target_file = $location . $date . "_" . $tipe_file . "_" . $i . "." . $fileExt;
                    }
                    if (move_uploaded_file($file_upload['tmp_name'], $target_file)) {
                        // unlink image
                        if (!empty($this->post($tipe_file))) {
                            unlink($this->post($tipe_file));
                        }

                        $this->set_response([
                            'status' => true,
                            'target' => $target_file,
                            'target_base' => base_url($target_file),
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => "<strong>" . $data_name . "</strong> can't be uploud.",
                        ], REST_Controller::HTTP_OK);
                    }
                }
            }
        }
    }
    public function upload_ico_post() {
        if (count($_FILES) > 0) {
            $validFileType = array("image/x-icon");
            $max_size_upload = 100 * 1024; //100kb
            $file_name_upload = array_keys($_FILES)[0];
            $file_upload = $_FILES[$file_name_upload];
            $data_name = $file_upload['name'];
            $fileExt = pathinfo(basename($data_name), PATHINFO_EXTENSION);
            if ($file_upload['size'] > $max_size_upload) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => "<strong>" . $data_name . "</strong> size exceeds 100KB.",
                ], REST_Controller::HTTP_OK);
            } else {
                if (!in_array($file_upload['type'], $validFileType)) {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => "<strong>" . $data_name . "</strong> is not image file.",
                    ], REST_Controller::HTTP_OK);
                } else {
                    $location = "upload";
                    if (!file_exists($location)) {
                        $oldmask = umask(0);
                        mkdir($location, 0777);
                        umask($oldmask);
                    }
                    $tipe_file = explode("-", $file_name_upload)[0];
                    $location .= "/" . $tipe_file;
                    if (!file_exists($location)) {
                        $oldmask = umask(0);
                        mkdir($location, 0777);
                        umask($oldmask);
                    }
                    $location .= "/";

                    $date = date('Ymd');
                    $i = 1;
                    $target_file = $location . $date . "_" . $tipe_file . "_" . $i . "." . $fileExt;
                    while (file_exists($target_file)) {
                        $i++;
                        $target_file = $location . $date . "_" . $tipe_file . "_" . $i . "." . $fileExt;
                    }
                    if (move_uploaded_file($file_upload['tmp_name'], $target_file)) {
                        // unlink image
                        if (!empty($this->post($tipe_file))) {
                            unlink($this->post($tipe_file));
                        }

                        $this->set_response([
                            'status' => true,
                            'target' => $target_file,
                            'target_base' => base_url($target_file),
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => "<strong>" . $data_name . "</strong> can't be uploud.",
                        ], REST_Controller::HTTP_OK);
                    }
                }
            }
        }
    }
    public function upload_post() {
        $creator = $this->post('creator');

        if (empty($this->change_data)) {
            $this->change_data = $this->tabel_model->get_change_field();
        }

        if ($creator === null) {
            $this->set_response([
                'status' => FALSE,
                'message' => "Access Denied",
            ], REST_Controller::HTTP_OK);
        } else {
            $allowed = array('xlsx', 'xls');
            $filename = $_FILES['file-upload']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                $this->set_response([
                    'status' => FALSE,
                    'message' => "Upload data type mismatch",
                ], REST_Controller::HTTP_OK);
            } else {
                $path = $_FILES["file-upload"]["tmp_name"];
                $loadexcel = $this->excel->load_data($path);
                $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
                $headerFormat = $this->tabel_model->get_header_data_format();
                if (!empty($this->option_format)) {
                    $headerFormat[0] = array_merge($headerFormat[0], array_keys($this->option_format));
                }

                foreach ($headerFormat as $key => $value) {
                    $header[$key + 1] = $value;
                }

                $data = "";
                $keyheader = [];
                $flag = true;

                foreach ($sheet as $row => $value_row) {
                    if ($flag) {
                        if (isset($header[$row])) {
                            foreach ($value_row as $key => $val) {
                                if (in_array($val, $header[$row])) {
                                    $keyheader[strtolower($val)] = $key;
                                }

                            }
                            if (count($header[$row]) != count($keyheader)) {
                                $flag = false;
                                break;
                            }
                        } else {
                            $flagMasuk = true;
                            $newdata = ['creator' => $creator];
                            foreach ($keyheader as $key_header => $key_row) {
                                if ($flagMasuk) {
                                    if (in_array($key_header, $this->required)) {
                                        if (empty($value_row[$key_row])) {
                                            $flagMasuk = false;
                                            break;
                                        }
                                    }
                                    if (!in_array($key_header, $this->option_format)) {
                                        if (isset($this->option_format[$key_header])) {
                                            if (!empty($value_row[$key_row])) {
                                                $newdata[$this->option_format[$key_header]] = $value_row[$key_row];
                                            }

                                        } else {
                                            if (!empty($value_row[$key_row])) {
                                                if (in_array($key_header, array_map('strtolower', $this->tabel_model->change_header_name))) {
                                                    $newdata[array_search($key_header, array_map('strtolower', $this->tabel_model->change_header_name))] = $value_row[$key_row];
                                                } else {
                                                    $newdata[$key_header] = $value_row[$key_row];
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                            if ($flagMasuk) {
                                if (!empty($this->system_fill)) {
                                    foreach ($this->system_fill as $key => $value) {
                                        $newdata[$key] = $value($newdata);
                                    }
                                }
                                $code = "";
                                if (isset($this->change_code['function'])) {
                                    $code = $this->change_code['function']($newdata);
                                }

                                $cek_data = "";
                                if (!empty($this->tabel_model->unik_field)) {
                                    $where = ["status" => 0];
                                    foreach ($this->tabel_model->unik_field as $u_key) {
                                        $where[$u_key] = $newdata[$u_key];
                                    }
                                    $cek_data = $this->tabel_model->get($where);
                                }
                                if (empty($cek_data)) {
                                    if (!empty($this->tabel_model->khusus_field)) {
                                        $where = ["status" => 0];
                                        foreach ($this->tabel_model->khusus_field as $k => $func) {
                                            $where[$k] = $func($newdata);
                                        }
                                        $cek_data = $this->tabel_model->get($where);
                                    }
                                }

                                if (empty($cek_data)) {
                                    $newdata['id'] = $this->tabel_model->getLastId(0, $code);
                                    if ($this->tabel_model->insert($newdata)) {
                                        if (!empty($data)) {
                                            $data .= ",";
                                        }

                                        $data_name = isset($this->change_data["name"]) ? $this->change_data["name"]($newdata) : $newdata['name'];
                                        $data .= $data_name;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($flag) {
                    if (!empty($data)) {
                        $this->set_response([
                            'status' => TRUE,
                            'message' => $data . " added to database",
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => "File is empty",
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => "Upload data format mismatch",
                    ], REST_Controller::HTTP_OK);
                }
            }
        }
    }
}
