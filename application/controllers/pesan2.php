<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Pesan extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));

        if (empty($this->data['m_status'])) {
            $this->data['m_status'] = 0;
        }
        $this->data['optionStatus'] = $this->master->option('m_status_edit', $this->data['m_status'], [], 1, $this->master->status_name);
    }

    public function editData()
    {
        $data = $this->master->get(['id' => $this->input->post('id'), 'm_status !=' => 1]);
        $data_detail = $this->pesan_detail->gets(['kontak' => $data->kontak, 'm_status' => 1], 0, ['create_date', 'DESC']);
        $data_key = [];
        $data_detail_value = "";
        $count_data = $this->master->get_validate_data_edit();

        foreach ($count_data as $key => $val) {
            $data_key[$key] = $val;
        }

        foreach ($data_detail as $key => $val) {
            $data_detail_value .= "<p style='word-wrap:break-word;'><b>" . $val->create_date . "</b></p>";
            $data_detail_value .= "<p style='word-wrap:break-word;'>" . $val->name . "</p><hr />";
        }

        if ($this->kontak->get(['phone' => $data->kontak, 'status' => 0])) {
            $get_contact = $this->kontak->get(['phone' => $data->kontak, 'status' => 0])->name;
        } else {
            $get_contact = $data->kontak;
        }

        $output = array(
            "data" => $data,
            "kontak" => $get_contact,
            "key" => $data_key,
            "key_count" => count($count_data),
            "data_detail" => $data_detail_value,
            "detail_count" => "<h6>Total Kirim <span class='badge bg-info'>" . count($data_detail) . "</span></h6>",
        );
        echo json_encode($output);
    }

    public function tambahData()
    {
        $data = [];
        $markaspulled = 1;
        $getnotpulledonly = 1;
        if ($this->master->is_connected()) {
            $data['connected'] = true;
            $api_url = "http://panel.rapiwha.com/get_messages.php?apikey=" . urlencode($this->my_api_whatsapp) . "&type=IN&markaspulled=" . $markaspulled . "&getnotpulledonly=" . $getnotpulledonly;
            $my_json_result = file_get_contents($api_url, false);
            $my_php_arr = json_decode($my_json_result);
            if (!empty($my_php_arr)) {
                foreach ($my_php_arr as $item) {
                    $master_id = $this->master->getLastId(0, $item->from);
                    $check_id = $this->master->getLastId(-1, $item->from);
                    if ($this->master->gets(['id' => $check_id, 'kontak' => $item->from, 'm_status !=' => 1])) {
                        $this->master->edit(['name' => $item->text, 'process_date' => $item->process_date, 'm_status' => 0, 'creator' => $this->creator], ['id' => $check_id, 'kontak' => $item->from]);
                    } else {
                        $this->master->add(['id' => $master_id, 'kontak' => $item->from, 'name' => $item->text, 'process_date' => $item->process_date, 'id_whatsapp' => $item->number, 'creator' => $this->creator]);
                    }
                }
                $data['flag'] = true;
                $check = $this->kontak->get(['phone' => $item->from, 'status' => 0]);
                if ($check) {
                    $data['sender'] = $check->name;
                    $data['toastInfo'] = 'info';
                } else {
                    $data['sender'] = $item->from;
                    $data['toastInfo'] = 'warning';
                }
            }
        }

        $result = array(
            'data' => $data,
        );
        $json = json_encode($result);
        echo $json;
    }

    public function perbaruiData()
    {
        $data = [];
        $data = $this->master->loopingDataPost($this->input->post(), "_edit");
        $omsetId = $this->omset->getLastId();
        $omsetArrId = $omsetId;

        $regex = "/(?<format>[A-Z]+[(x|.)0-9]+)|(?<number2>[0-9(.|\s)]+x[0-9]+[.|\s])|(?<number>[0-9]+)/i";
        $regex_number = "/[0-9]+|[A-Z-a-z]+|[a-z]+/";
        $regex_string = "/(?<angka>[0-9]+)|[x0-9](?<hasil>[0-9]+)/";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];
        $kontak = $this->master->get(['id' => $data['id'], 'status' => 0]);
        if ($this->master->edit($data, ['id' => $data['id'], 'm_status !=' => 1])) {
            $master = $this->master->gets(['id' => $data['id']]);
            $kontak = $this->master->get(['id' => $data['id'], 'status' => 0]);
            if ($data['m_status'] == 1) {
                $this->pesan_detail->add(['id' => $data['id'], 'name' => $data['name'], 'kontak' => $kontak->kontak, 'm_status' => 1]);
                $rowValue = preg_match_all($regex, $data['name'], $matches, PREG_SET_ORDER);
                foreach ($matches as $key_search => $value_search) {
                    foreach ($value_search as $key_match => $value_match) {
                        if (!is_numeric($key_match) && !empty($value_match)) {
                            $matches2[$key_match][] = $value_match;
                        }
                    }
                }

                if (!empty($matches2['format'])) {
                    foreach ($matches2['format'] as $key => $value) {
                        $xformat = 999;
                        $yformat = 999;
                        $zformat = 999;
                        $uformat = 999;
                        $flag = false;
                        $flagx = false;
                        $rowValue = preg_match_all($regex_number, $value, $value_regex);
                        foreach ($value_regex as $keys => $values) {
                            foreach ($values as $keyd => $valued) {
                                if (in_array($valued, $validate_format)) {
                                    $zformat = $keyd + 1;
                                    $dummyformat_validate = $valued;
                                }
                                if (empty($dummyformat_validate)) {
                                    $dummyformat_validate = strlen($valued);
                                }
                                if ($zformat == $keyd) {
                                    if ($valued == "x") {
                                        $yformat = $keyd + 1;
                                    } else {
                                        $resultformat['angka'][$dummyformat_validate][] = $valued;
                                        $uformat = $keyd + 2;
                                    }
                                } else {
                                    if ($zformat !== $keyd && $valued == "x") {
                                        $uformat = $keyd + 1;
                                    }
                                }
                                if ($uformat == $keyd) {
                                    $resultformat['hasil'][$dummyformat_validate][] = $valued;
                                }
                                if ($yformat == $keyd) {
                                    $resultformat['hasil'][$dummyformat_validate][] = $valued;
                                    $xformat = $keyd + 1;
                                }
                                if ($xformat == $keyd) {
                                    $resultformat['angka'][$dummyformat_validate][] = $valued;
                                }
                            }
                        }
                    }
                }

                if (!empty($matches2['number2'])) {
                    foreach ($matches2['number2'] as $key_string => $value_string) {
                        $rowValue = preg_match_all($regex_string, $value_string, $string_val);
                        $dum_hasil = implode(array_filter($string_val['hasil']));
                        foreach ($string_val['angka'] as $key => $value) {
                            if (!empty($value)) {
                                $result4d['angka'][strlen($value)][] = $value;
                                $result4d['hasil'][strlen($value)][] = $dum_hasil;
                            }
                        }
                    }
                }

                if (!empty($matches2['number'])) {
                    $x = 0;
                    $y = 1;
                    foreach ($matches2['number'] as $key => $value) {
                        if (!empty($value)) {
                            if ($key == $x) {
                                $result4d['angka'][strlen($value)][] = $value;
                                $x = $key + 2;
                                $strln = strlen($value);
                            }
                            if ($key == $y) {
                                $result4d['hasil'][$strln][] = $value;
                                $y = $key + 2;
                            }
                        }
                    }
                }

                $omset4d = 0;
                $omsetformat = 0;

                if (!empty($result4d['angka'])) {
                    foreach ($result4d['angka'] as $keyd => $valued) {
                        $i = 1;
                        if ($keyd !== 1 && $keyd < 5) {
                            foreach ($valued as $key => $value) {
                                if (!empty($value)) {
                                    if (!empty($result4d['hasil'][$keyd][$key])) {
                                        $hasil4d = $result4d['hasil'][$keyd][$key];
                                        $this->omset_detail->add(['id' => $omsetArrId, 'keypesan' => $data['id'], 'kontak' => $kontak->kontak, 'angka' => $value, 'hasil' => $hasil4d, 'format' => $keyd]);
                                        $omset4d = $hasil4d * $this->master->price4d($keyd, $hasil4d, $kontak->kontak);
                                    }
                                }
                            }
                        }
                    }
                }

                if (!empty($resultformat['angka'])) {
                    foreach ($resultformat['angka'] as $key2 => $value2) {
                        if (!empty($value2)) {
                            $i = 1;
                            foreach ($resultformat['angka'][$key2] as $key => $value) {
                                if (!empty($resultformat['hasil'][$key2][$key])) {
                                    $hasilformat = $resultformat['hasil'][$key2][$key];
                                    $this->omset_detail->add(['id' => $omsetArrId, 'keypesan' => $data['id'], 'kontak' => $kontak->kontak, 'angka' => $value, 'hasil' => $hasilformat, 'format' => $key2]);
                                    $omsetformat += $hasilformat;
                                }
                            }
                        }
                    }
                }
                if (!empty($resultformat['angka']) && !empty($result4d['angka'])) {
                    $this->omset->add(['id' => $omsetId, 'keypesan' => $keypesan, 'name' => $data['name'], 'id_whatsapp' => $this->session_whatsapp->id_whatsapp, 'omset4d' => $omset4d, 'omsetformat' => $omsetformat, 'creator' => $this->creator]);
                }
            } else {
                $api_url_message = "https://panel.rapiwha.com/send_message.php?apikey=" . urlencode($this->my_api_whatsapp) . "&number=" . urlencode($master[0]->kontak) . "&text=" . urlencode("pesan: " . $data['name'] . " status: " . $this->master->status_name[$data['m_status']] . " date: " . $master[0]->create_date);
                $my_result_object = json_decode(file_get_contents($api_url_message, false));
            } //3
        } //2
    } //1

    public function getpreviewchat()
    {
        $id = $this->input->post('id');
        if (!empty($this->input->post('name'))) {
            $name_value = $this->input->post('name');
        }

        $master = $this->pesan->gets(['id' => $id, 'status' => 0]);
        $regex = "/(?<format>[A-Z]+[(x|.)0-9]+)|(?<number2>[0-9(.|\s)]+x[0-9]+[.|\s])|(?<number>[0-9]+)/i";
        $regex_number = "/[0-9]+|[A-Z-a-z]+|[a-z]+/";
        $regex_string = "/(?<angka>[0-9]+)|[x0-9](?<hasil>[0-9]+)/";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];
        foreach ($master as $key_master => $value_master) {
            if (!isset($name_value)) {
                $name_value = $value_master->name;
            }

            $rowValue = preg_match_all($regex, $name_value, $matches, PREG_SET_ORDER);
            foreach ($matches as $key_search => $value_search) {
                foreach ($value_search as $key_match => $value_match) {
                    if (!is_numeric($key_match) && !empty($value_match)) {
                        $matches2[$key_match][] = $value_match;
                    }
                }
            }
        }

        if (!empty($matches2['format'])) {
            foreach ($matches2['format'] as $key => $value) {
                $xformat = 999;
                $yformat = 999;
                $zformat = 999;
                $uformat = 999;
                $flag = false;
                $flagx = false;
                $rowValue = preg_match_all($regex_number, $value, $value_regex);
                foreach ($value_regex as $keys => $values) {
                    foreach ($values as $keyd => $valued) {
                        if (in_array($valued, $validate_format)) {
                            $zformat = $keyd + 1;
                            $dummyformat_validate = $valued;
                        }

                        if (empty($dummyformat_validate)) {
                            $dummyformat_validate = strlen($valued);
                        }

                        if ($zformat == $keyd) {
                            if ($valued == "x") {
                                $yformat = $keyd + 1;
                            } else {
                                $resultformat['angka'][$dummyformat_validate][] = $valued;
                                $uformat = $keyd + 2;
                            }
                        } else {
                            if ($zformat !== $keyd && $valued == "x") {
                                $uformat = $keyd + 1;
                            }
                        }

                        if ($uformat == $keyd) {
                            $resultformat['hasil'][$dummyformat_validate][] = $valued;
                        }

                        if ($yformat == $keyd) {

                            $resultformat['hasil'][$dummyformat_validate][] = $valued;
                            $xformat = $keyd + 1;
                        }

                        if ($xformat == $keyd) {
                            $resultformat['angka'][$dummyformat_validate][] = $valued;
                        }
                    }
                }
            }
        }

        if (!empty($matches2['number2'])) {
            foreach ($matches2['number2'] as $key_string => $value_string) {
                $rowValue = preg_match_all($regex_string, $value_string, $string_val);
                $dum_hasil = implode(array_filter($string_val['hasil']));

                foreach ($string_val['angka'] as $key => $value) {
                    if (!empty($value)) {
                        $result4d['angka'][strlen($value)][] = $value;
                        $result4d['hasil'][strlen($value)][] = $dum_hasil;
                    }
                }
            }
        }

        if (!empty($matches2['number'])) {
            $x = 0;
            $y = 1;
            foreach ($matches2['number'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == $x) {
                        $result4d['angka'][strlen($value)][] = $value;
                        $x = $key + 2;
                        $strln = strlen($value);
                    }
                    if ($key == $y) {
                        $result4d['hasil'][$strln][] = $value;
                        $y = $key + 2;
                    }
                }
            }
        }

        $html_result = "";
        $count = "";
        $sum_price = 0;
        $validate_color = ['black', 'info', 'primary', 'success', 'danger'];
        foreach ($master as $key_result => $val_result) {
            $master = $this->pesan->get(['id' => $val_result->id]);
            $get_kontak = $master->kontak;

            for ($i = 4; $i > 1; $i -= 1) {
                $html4d[$i] = "";
                if (!empty($result4d['angka'][$i])) {
                    foreach ($result4d['angka'][$i] as $key => $value) {
                        if (!empty($result4d['hasil'][$i][$key]) && !empty($value)) {
                            if (empty($format[$i]) && $key == 0) {
                                $format[$i] = $i . "D";
                            } else {
                                $format[$i] = "";
                            }
                            $hasil4d = $result4d['hasil'][$i][$key];
                            $sum_price += $hasil4d;
                            $hasil4d > 100 || strlen($value) > 4 ? $color = "dark" : $color = $validate_color[$i];

                            $html4d[$i] .= $this->load->view('pesan/angka', ['angka' => $value, 'hasil' => $hasil4d, 'format' => $format[$i], 'color' => $color], true);
                        }
                    }
                    $count .= $i . "D: " . count($result4d['angka'][$i]) . " ";
                }
            }

            $htmlformat = "";
            if (!empty($resultformat['angka'])) {
                foreach ($resultformat['angka'] as $key2 => $value2) {
                    if (!empty($value2)) {
                        foreach ($resultformat['angka'][$key2] as $key => $value) {
                            if (!empty($resultformat['hasil'][$key2][$key])) {
                                $hasilformat = $resultformat['hasil'][$key2][$key];
                                if ($key == 0) {
                                    $vv_format = "<br />" . $key2 . "<br />";
                                } else {
                                    $vv_format = "";
                                }
                                $sum_price += $hasilformat;
                                $htmlformat .= $this->load->view('pesan/format', ['angka' => $value, 'hasil' => $hasilformat, 'format' => $vv_format, 'color' => 'info'], true);
                            }
                        }
                    }
                    $count .= $key2 . ": " . count($resultformat['angka'][$key2]) . " ";
                }
            }

            $html_result .= $this->load->view('pesan/pengguna', ['master' => $master, 'angka' => $html4d, 'player' => $master->kontak, 'hformat' => $htmlformat, 'sum_price' => $sum_price], true);
        }

        if (empty($count)) {
            $count = 0;
        }

        $output = array(
            "preview" => $html_result,
            "count4d" => $count,
        );
        echo json_encode($output);
    }

    public function getHistoryMessage()
    {
        $preview = "";
        $id = $this->input->post('id');
        $master = $this->master->get(['id' => $id, 'm_status' => 1, 'process_date' => date('y-m-d')]);
        $master_detail = $this->pesan_detail->gets(['id' => $id, 'status' => 0], 0, ['create_date', 'DESC']);
        foreach ($master_detail as $key => $value) {
            $preview .= "<p style='word-wrap:break-word;'><b>" . date('y-m-d', strtotime($this->master->get(['id' => $value->id])->process_date)) . "</b></p>";
            $preview .= "<p style='word-wrap:break-word;'>" . $value->name . "</p><hr />";
        }

        $output = array(
            "callback" => $preview,
            "data" => $master,
            "countmessage" => "<h6>Total Kirim <span class='badge bg-info'>" . count($master_detail) . "</span></h6>",
        );
        echo json_encode($output);
    }
} //End
