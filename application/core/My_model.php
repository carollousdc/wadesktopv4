<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_model extends CI_Model
{
    public $tabel = "";
    public $tabel_prefix = "";

    protected $change_field_query = []; //field yang ada di table user
    protected $select_query = "";
    public $column_search = array('name'); //field yang diizin untuk pencarian
    public $column_order = [];
    public $field_id = ["id"];
    public $field_date = [];
    public $order = array('id' => 'asc'); // default order
    public $changeHeaderName = ['create_date' => "Tanggal"]; //default change name
    protected $queryOptionTipe = ["creator" => "c.id"];
    protected $joinTabelQuery = ["user c" => ["m.creator=c.id", "left"]];
    protected $dataListTipe = [];
    public $status_name = ['Diterima', 'Proses'];

    public $remove_action_edit = 0;
    public $remove_action_delete = 0;
    public $month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    public $gender = ['Pria', 'Wanita'];
    public $response_message_api = ['Pesan Terkirim', 'Koneksi API Gagal', 'Missing parameters', 'Tidak dapat mengirim pesan ke nomor ini.', 'Jumlah kirim sudah melebihi batas ke nomor ini.', 'API Disconnected', 'Parameters must to encode', 'Saldo tidak cukup', 'Jumlah respon whatsapp sudah melebihi batas', 'Error Something', 'Saldo Token tidak cukup'];
    public $change_tipe_manual = [];
    public function __construct()
    {
        parent::__construct();
    }

    function is_connected()
    {
        $connected = @fsockopen("www.google.com", 80); //website, port  (try 80 or 443)
        if ($connected) {
            fclose($connected);
            return true;
        }
        return false;
    }

    public function add($data)
    {
        return $this->db->insert($this->tabel, $data);
    }

    public function insert_multiple($data)
    {
        return $this->db->insert_batch($this->tabel, $data);
    }

    public function gets($where = "", $api = 0, $order = "", $group = "")
    {
        if (empty($where)) {
            $where = array("m.status" => 0);
        }
        if (!empty($order)) {
            $this->db->order_by($order[0], $order[1]);
        }

        if (!empty($group)) {
            $this->db->group_by($group);
        }

        $query = $this->db->get_where($this->tabel . " m", $where);
        if (empty($api)) {
            return $query->result();
        } else {
            return $query;
        }
    }

    public function get($where = "", $order = "")
    {
        if (empty($where)) {
            $where = array("status" => 0);
        }

        if (!empty($order)) {
            $this->db->order_by($order, 'DESC');
        }

        return $this->db->get_where($this->tabel . " m", $where)->row();
    }

    public function edit($data, $where)
    {
        return $this->db->update($this->tabel, $data, $where);
    }

    public function delete($where, $delete_db = 1)
    {
        if (empty($delete_db)) {
            return $this->db->update($this->tabel, ['status' => 1], $where);
        } else {
            return $this->db->delete($this->tabel, $where);
        }
    }

    public function loopingDataPost($parm1, $exp = "", $where = "")
    {
        $data = [];
        foreach ($parm1 as $key => $value) {
            if (!empty($exp) && strpos($key, $exp)) {
                $key = explode($exp, $key)[0];
                $data[$key] = $value;
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function getLastId($count = 0, $code = "")
    {
        if (empty($code)) {
            if (empty($this->tabel_prefix)) {
                $this->tabel_prefix = substr($this->tabel, 0, 1);
            }

            $code = $this->tabel_prefix . date('Ymd');
        }
        $this->db->select_max('id');
        $this->db->like('id', $code);
        $res1 = $this->db->get($this->tabel);
        $id = $res1->row()->id;
        $id = intval(substr($id, strlen($code), strlen($id) + 5));
        if (empty($count)) {
            $id++;
        } else {
            $id += $count + 1;
        }

        $id = "00000" . $id;
        return $code . substr($id, strlen($id) - 5);
    }

    public function get_field_data()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = ['no'];
        $res = array_merge($res, $allfield);
        $res = array_reverse(array_reverse(array_diff($res, ["id", "status", "creator"])));
        return $res;
    }

    public function get_validate_data()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["id", "creator", "create_date", "status"])));
        return $res;
    }

    public function get_validate_data_edit()
    {
        $allfield = $this->db->list_fields($this->tabel);
        $res = array_reverse(array_reverse(array_diff($allfield, ["id", "creator", "create_date", "create", "status"])));
        return $res;
    }

    public function get_field_data_full()
    {
        $field_data = $this->get_field_data();
        array_push($field_data, 'action');
        $field_data = array_reverse(array_reverse($field_data));
        return $field_data;
    }

    public function get_field_name()
    {
        return $this->db->list_fields($this->tabel);
    }

    public function get_field_type($type = "")
    {
        $data = [];
        $query = $this->db->field_data($this->tabel);
        foreach ($query as $key) {
            if (!empty($type)) {
                if (in_array($key->name, $this->get_validate_data())) {
                    $data[] = $key;
                }
            } else {
                if (in_array($key->name, $this->get_validate_data_edit())) {
                    $data[] = $key;
                }
            }
        }
        return $data;
    }

    public function getsGroupResult($where = "", $parameter = "", $where_in = "")
    {
        if (!empty($where_in) && !empty($parameter)) {
            $this->db->where_in($parameter, $where_in);
        }
        if (empty($where)) {
            $where = array("m.status" => 0);
        }

        if (!empty($parameter)) {
            $this->db->group_by($parameter);
        }
        $query = $this->db->get_where($this->tabel . " m", $where);
        return $query->result();
    }

    public function getsGroup()
    {
        $this->db->select("email");
        $this->db->group_by("email");
        $query = $this->db->get($this->tabel);
        return $query->result();
    }

    public function getUser($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tabel);
        return $query->row();
    }

    public function getRoot($root)
    {
        $this->db->where('id', $root);
        $query = $this->db->get($this->tabel);
        return $query->row();
    }

    public function updateData($id, $data)
    {
        $this->db->where('id', $id); // where no induk
        $this->db->update($this->tabel, $data); //mengupdate tb_siswa sesuai kondisi di atas
    }

    public function getDataByid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->tabel);
        return $query->result();
    }

    public function doLogin($email, $password)
    {
        $this->db->where('email', $email)
            ->or_where('id', $email);
        $user = $this->db->get($this->tabel)->row();
        // jika user terdaftar
        if ($user) {
            // periksa password-nya
            $isPasswordTrue = password_verify($password, $user->password);
            // periksa role-nya
            // $isAdmin = $user->role = 1;
            // jika password benar dan dia admin
            if ($isPasswordTrue) {
                // login sukses yay!
                $this->session->set_userdata('email', $user->email);
                $this->session->set_userdata('id', $user->id);
                $this->session->set_userdata('role', $user->role);
                return true;
            }
        }
        // login gagal
        return false;
    }

    public function getHeaderName()
    {
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

    public function optionOnly($name)
    {

        $isi = "<select id='" . $name . "' name='" . $name . "' class='form-control select2bs4'></select>";
        return $isi;
    }

    public function option($nama, $selected = "", $where = "", $must = "", $data = [], $disabled = "", $setValue = "")
    {
        empty($this->change_tipe_manual) ? $datlist = $data : $datlist = $this->change_tipe_manual;
        $isi = '<select id="' . $nama . '" name="' . $nama . '" class="form-control select2bs4" value="' . $selected . '" ' . $disabled . '>';
        $selectedFlag = "";
        if ($selected == "") {
            $selectedFlag = "selected";
        }

        if (empty($must)) {
            $isi .= '<option ' . $selectedFlag . ' value="default">Silahkan Pilih</option>';
        }

        $getArray = $this->gets($where);
        if (!empty($datlist)) {
            $getArray = $datlist;
        }

        $no = 0;
        foreach ($getArray as $key => $value) {

            $selectedFlag = "";
            if (empty($datlist)) {
                (!empty($setValue)) ? $x = $setValue : $x = "id";
                if ($selected == $value->$x) {
                    $selectedFlag = "selected";
                }

                $isi .= '<option value="' . $value->$x . '" ' . $selectedFlag . '>' . $value->name . '</option>';
            } else {
                if ($selected == $value) {
                    $selectedFlag = "selected";
                }

                $isi .= '<option value="' . $no . '" ' . $selectedFlag . '>' . $value . '</option>';
            }
            $no++;
        }
        $isi .= '</select>';
        return $isi;
    }

    public function multiexplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    public function validateURL($link)
    {
        $pattern_1 = "^[^?]*\.(jpg|jpeg|gif|png)(?![\w.\-_]";
        if (preg_match_all($pattern_1, $link, $input)) {
            return preg_match_all($pattern_1, $link, $input);
        } else {
            return $link;
        }
    }

    public function changeImageUrl($link, $width = "", $hyperlink = 0, $id = "")
    {
        if (empty($width)) {
            $width = "350px";
        }

        $pattern = '~\b(?:ht|f)tps?://[a-z0-9.-]+\.[a-z]{2,3}(?:/\S*)?~i';
        $imgExt = ['.png', '.gif', '.jpg', '.jpeg'];
        $callback = function ($m) use ($imgExt, $width, $hyperlink, $id) {
            if (false === $extension = parse_url($m[0], PHP_URL_PATH)) {
                return $m[0];
            }

            $master = $this->pesan->get(['id' => $id, 'status' => 0]);
            $extension = strtolower(strrchr($extension, '.'));
            if (in_array($extension, $imgExt)) {
                if ($hyperlink == 1) {
                    return '<img src="' . $m[0] . '" style="max-height:500px;border-radius:10px;width:' . $width . ';" class="message-image" alt="Pengirim: ' . $master->kontak . " | Tanggal: " . $master->create_date . '">';
                } else {
                    return '<img src="' . $m[0] . '" style="max-height:60px;border-radius:10px;width:' . $width . ';" class="message-image" alt="Pengirim: ' . $master->kontak . " Tanggal: " . $m[0] . '">';
                }
            }
            # better to do that via a css rule --^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
            return '<a href="' . $m[0] . '" target="_blank">' . $m[0] . '</a>';
        };

        $result = preg_replace_callback($pattern, $callback, $link);
        return $result;
    }

    //new

    protected function createQueryOptionTipe($dataList, $key_tipe)
    {
        $this->queryOptionTipe[$key_tipe] = "CASE";
        foreach ($dataList as $key => $value) {
            $this->queryOptionTipe[$key_tipe] .= " WHEN m.$key_tipe = $key THEN '$value'";
        }
        $this->queryOptionTipe[$key_tipe] .= " END";
    }
    //memasukan tanggal ke query
    protected function createQueryDate()
    {
        foreach ($this->field_date as $key) {
            $this->queryOptionTipe[$key] = "CASE ";
            foreach ($this->month as $k => $val) {
                $x = $k + 1;
                $this->queryOptionTipe[$key] .= " WHEN MONTH(m.$key)=$x then CONCAT_WS(' ',DAY(m.$key),'$val',YEAR(m.$key))";
            }
            $this->queryOptionTipe[$key] .= "ELSE '-' END";
        }
    }
    //memasukan datalisttipe ke query
    protected function gets_query_option()
    {
        foreach ($this->dataListTipe as $key => $value) {
            $this->createQueryOptionTipe($value, $key);
        }
        $this->createQueryDate();
        foreach ($this->queryOptionTipe as $key => $value) {
            if (in_array($key, $this->get_field_name())) {
                $this->change_field_query[$key] = "$value AS $key";
            } else {
                if (!empty($this->select_query)) {
                    $this->select_query .= " , ";
                }

                $this->select_query .= "$value AS $key";
            }
        }
    }

    public function get_def_order()
    {
        return [$this->get_field_data()[1] => 'asc'];
    }

    public function gets_query($search, $order)
    {
        $this->gets_query_option();
        $change_order = $this->get_change_order();
        $i = 0;
        $select = "";
        foreach ($this->get_field_name() as $item) // looping awal
        {
            if ($select != "") {
                $select .= ",";
            }

            if (isset($this->change_field_query[$item])) {
                $select .= $this->change_field_query[$item];
            } else {
                $select .= "m." . $item;
            }

            if ($search['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like("m." . $item, $search['value']);
                } else {
                    $this->db->or_like("m." . $item, $search['value']);
                }

                if (count($this->get_field_name()) - 1 == $i) {
                    $this->get_like_query($search);
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if ($select != "" && !empty($this->select_query)) {
            $select .= ",";
        }

        $select .= $this->select_query;
        $this->db->select($select);
        $this->get_join_query();

        if ($order !== null) {
            if (empty($this->column_order)) {
                $this->column_order = $this->get_field_data();
            }
            if (!isset($change_order[$this->column_order[$order['0']['column']]])) {
                $this->db->order_by($this->column_order[$order['0']['column']], $order['0']['dir']);
            } else {
                $change_order[$this->column_order[$order['0']['column']]]($order['0']['dir']);
            }
        } else {
            $order_def = $this->get_def_order();
            if (!isset($change_order[key($order_def)])) {
                $this->db->order_by(key($order_def), $order_def[key($order_def)]);
            } else {
                $change_order[key($order_def)]($order_def[key($order_def)]);
            }
        }
    }
    //amb

    public function gets_datatable($length, $start, $search, $order, $where)
    {
        $this->gets_query($search, $order);
        if ($length != -1) {
            $this->db->limit($length, $start);
        }

        return $this->gets($where);
    }

    function count_filtered($search, $order, $where)
    {
        $this->gets_query($search, $order);
        $query = $this->gets($where, 1);
        return $query->num_rows();
    }
    //  counter data aktif
    public function count_all($where)
    {
        $this->db->where($where);
        $this->db->from($this->tabel . " m");
        return $this->db->count_all_results();
    }

    public function get_change_field()
    {
        return [];
    }
    //change field order
    public function get_change_order()
    {
        return [];
    }
    //get like
    public function get_like_query($search)
    {
        $this->db->or_like("c.id", $search['value']);
        foreach ($this->queryOptionTipe as $value) {
            $this->db->or_like($value, $search['value']);
        }
    }
    //get join
    public function get_join_query()
    {
        foreach ($this->joinTabelQuery as $key => $value) {
            if (isset($value[1])) {
                $this->db->join($key, $value[0], $value[1]);
            } else {
                $this->db->join($key, $value[0]);
            }
        }
    }

    public function get_action($value, $edit, $delete, $no)
    {

        empty($this->change_primary_name) ? $change_name_id = "id" : $change_name_id = $this->change_primary_name;
        $change_data = $this->get_change_field();
        $value->name = isset($change_data["name"]) ? $change_data["name"]($value) : $value->name;
        $value->$change_name_id = $value->$change_name_id;
        if (empty($this->remove_action_edit)) {
            $editBtn = '<button data-id="' . $value->id . '" class="btn btn-primary btn_edit">Proses</button>';
        } else {
            $editBtn = "";
        }

        if (empty($this->remove_action_delete)) {
            $deleteBtn = '<button style="margin-left: 5px;" data-id="' . $value->id . '" class="btn btn-danger btn_hapus">Hapus</button>';
        } else {
            $deleteBtn = "";
        }

        $value->action = $editBtn . " " . $deleteBtn;
        $value->no = $no;
        return $value;
    }

    public function price_pool($result, $value, $kontak)
    {
        $angkapecah = [$result, substr($result, -3, 3), substr($result, -2, 2)];
        if (in_array($value, $angkapecah)) {
            if ($this->kontak->get(['phone' => $kontak, 'status' => 0])) {
                $kontak = $this->kontak->get(['phone' => $kontak, 'status' => 0]);
                $result_price = [0, ($kontak->persen2a / 100) * $kontak->hd2a, ($kontak->persen3a / 100) * $kontak->hd3a, ($kontak->persen4a / 100) * $kontak->hd4a];
                return $result_price[strlen($value) - 1];
            } else {
                $result_price = [0, 70, 500, 3000];
                return $result_price[strlen($value) - 1];
            }
        }
    }

    public function price4d($ilength, $value, $phone)
    {
        if ($this->kontak->get(['phone' => $phone, 'status' => 0])) {
            $kontak = $this->kontak->get(['phone' => $phone, 'status' => 0]);
            $result_price = [2 => $kontak->hd2a, 3 => $kontak->hd3a, 4 => $kontak->hd4a];
            return $result_price[$ilength];
        } else {
            return 0;
        }
    }

    public function priceformat($result, $price = "", $prices = [], $format, $kontak, $valueIndex, $formatstring)
    {
        if ($this->kontak->get(['phone' => $kontak, 'status' => 0])) {
            $html_view = "";
            $dum_price = 0;
            $userinfo = $this->kontak->get(['phone' => $kontak, 'status' => 0]);
            if (!empty($formatstring)) {
                if ($formatstring == "CB") {
                    $row_result['hasil'] = $price;
                    $row_result['hadiah'] = $row_result['hasil'] * (($userinfo->persencb / 100) * $userinfo->hdcb4);
                    $html_view .= $this->load->view('result/format', ['angka' => $valueIndex, 'hasil' => $row_result['hasil'], 'hadiah' => $row_result['hadiah'], 'format' => $format], true);
                }
                if ($formatstring == "SET") {
                    $row_result['hasil'] = "";
                    $result_price = [($userinfo->persen4a / 100) * $userinfo->hd4a, ($userinfo->persen3a / 100) * $userinfo->hd3a, ($userinfo->persen2a / 100) * $userinfo->hd2a];
                    foreach ($prices as $key => $value) {
                        if ($key < 3) {
                            if ($key == 0) {
                                $formatset = "SET";
                            } else {
                                $formatset = "";
                            }

                            $xkey = 5;
                            $row_result['hasil'] = $value;
                            $row_result['hadiah'] = $value * $result_price[$key];
                            $html_view .= $this->load->view('result/format', ['angka' => substr($valueIndex, $key, $xkey -= 1), 'hasil' => $row_result['hasil'], 'hadiah' => $row_result['hadiah'], 'format' => $formatset], true);
                        }
                    }
                }
                return $html_view;
            }
        }
    }

    public function getFormField($name, $type, $validate = "")
    {
        if ($type !== 'tinyint') {
            $validate['where'] = "";
            $validate['must'] = "";

            isset($this->master->changeHeaderName[$name]) ? $change_name = $this->master->changeHeaderName[$name] : $change_name = $name;
            $normal = ['int' => 'number', 'varchar' => 'text', 'datetime' => 'date', 'date' => 'date', 'tinyint' => 'number'];
            $custom['text'] = '<textarea class="form-control" name="' . $name . '" id="' . $name . '" rows=6></textarea>';
            if (!empty($validate) && $type == 'option') {
                if (!empty($validate['custom'])) {
                    $custom['option'] = $this->master->option($name, "", $validate['where'], $validate['must'], $validate['custom']);
                } else {
                    $custom['option'] = $this->master->option($name, "", $validate['where'], $validate['must']);
                }
            }

            if (isset($normal[$type])) {
                $form = '<label for="name">' . ucwords($change_name) . '</label><input type="' . $normal[$type] . '" class="form-control" name="' . $name . '" id="' . $name . '" required="required">';
            } else {
                $form = '<label for="name">' . ucwords($change_name) . '</label>' . $custom[$type];
            }

            return $form;
        }
    }

    public function getFormFieldEdit($name, $type, $validate = "")
    {
        if ($type !== 'tinyint') {
            $validate_key['where'] = [];
            $validate_key['must'] = 0;
            if (!empty($validate)) {
                foreach ($validate as $key => $value) {
                    if (!empty($value)) {
                        $validate_key[$key] = $value;
                    }
                }
            }

            isset($this->master->changeHeaderName[$name]) ? $change_name = $this->master->changeHeaderName[$name] : $change_name = $name;
            $normal = ['int' => 'number', 'varchar' => 'text', 'datetime' => 'date', 'date' => 'date'];
            $custom['text'] = '<textarea class="form-control" name="' . $name . '_edit" id="' . $name . '_edit" rows=6></textarea>';
            if (!empty($validate_key) && $type == 'option') {
                if (!empty($validate_key['custom'])) {
                    $custom['option'] = $this->master->option($name . '_edit', "", $validate_key['where'], $validate_key['must'], $validate_key['custom']);
                } else {
                    $custom['option'] = $this->master->option($name . '_edit', "", $validate_key['where'], $validate_key['must']);
                }
            }

            if (isset($normal[$type])) {
                $form = '<label for="name">' . ucwords($change_name) . '</label><input type="' . $normal[$type] . '" class="form-control" name="' . $name . '_edit" id="' . $name . '_edit" required="required">';
            } else {
                $form = '<label for="name">' . ucwords($change_name) . '</label>' . $custom[$type];
            }
            return $form;
        }
    }

    public function angka4d($angka, $hasil, $id = "", $keypesan = "", $kontak, $resultomset)
    {
        $c = strlen($angka);
        $result = $resultomset;
        if ($c >= 4) {
            foreach ($hasil as $keyd => $valued) {
                $f = array();
                $e = array();
                $d = array();
                if ($keyd == 0) {
                    $x = 0;
                    for ($i = 0; $i < $c; $i++) {
                        for ($j = 0; $j < $c; $j++) {
                            for ($k = 0; $k < $c; $k++) {
                                for ($l = 0; $l < $c; $l++) {
                                    if (($i != $j) && ($i != $k) && ($i != $l) && ($j != $k) && ($j != $l) && ($k != $l) && !in_array(
                                        substr($angka, $i, 1) . substr($angka, $j, 1) . substr($angka, $k, 1) . substr($angka, $l, 1),
                                        $f
                                    )) {
                                        $f[] = substr($angka, $i, 1) . substr($angka, $j, 1) . substr($angka, $k, 1) . substr($angka, $l, 1);
                                        $value['angka'] = substr($angka, $i, 1) . substr($angka, $j, 1) . substr($angka, $k, 1) . substr($angka, $l, 1);
                                        $value['hasil'] = $valued;
                                        $result[] = ['id' => $id, 'keypesan' => $keypesan, 'kontak' => $kontak, 'angka' => $value['angka'], 'hasil' => $value['hasil'], 'format' => "4D"];
                                        $x++;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($keyd == 1) {
                    $x = 0;
                    for ($i = 0; $i < $c; $i++) {
                        for ($j = 0; $j < $c; $j++) {
                            for ($k = 0; $k < $c; $k++) {
                                if (($i != $j) && ($i != $k) && ($k != $j) && !in_array(substr($angka, $i, 1) . substr($angka, $j, 1) . substr($angka, $k, 1), $e)) {
                                    $e[] = substr($angka, $i, 1) . substr($angka, $j, 1) . substr($angka, $k, 1);
                                    $value['angka'] = substr($angka, $i, 1) . substr($angka, $j, 1) . substr($angka, $k, 1);
                                    $value['hasil'] = $valued;
                                    $result[] = ['id' => $id, 'keypesan' => $keypesan, 'kontak' => $kontak, 'angka' => $value['angka'], 'hasil' => $value['hasil'], 'format' => "3D"];
                                    $x++;
                                }
                            }
                        }
                    }
                }
                if ($keyd == 2) {
                    $x = 0;
                    for ($i = 0; $i < $c; $i++) {
                        for ($j = 0; $j < $c; $j++) {
                            if (($i != $j) && !in_array(substr($angka, $i, 1) . substr($angka, $j, 1), $d)) {
                                $d[] = substr($angka, $i, 1) . substr($angka, $j, 1);
                                $value['angka'] = substr($angka, $i, 1) . substr($angka, $j, 1);
                                $value['hasil'] = $valued;
                                $result[] = ['id' => $id, 'keypesan' => $keypesan, 'kontak' => $kontak, 'angka' => $value['angka'], 'hasil' => $value['hasil'], 'format' => "2D"];
                                $x++;
                            }
                        }
                    }
                }
            }
            return $result;
        }
    }
} //End
