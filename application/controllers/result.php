<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Result extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function check_result() {

        if (empty($this->input->post('hasil'))) {
            $angka_result = $this->master->get(['date' => date('Y-m-d')])->name;
        } else {
            $angka_result = $angka_result = $this->input->post('hasil');
        }

        $angkapecah = [4 => $angka_result, 3 => substr($angka_result, -3, 3), 2 => substr($angka_result, -2, 2), 1 => substr($angka_result, 1, 1)];
        $master_result = $this->pesan->gets(['process_date' => date('y-m-d'), 'm_status' => 1]);
        $regex = "/(?<format>[A-Z]+[(x|.)0-9]+)|(?<number2>[0-9.]+x[0-9]+[.|\s])|(?<number>[0-9]+)/i";
        $regex_number = "/[0-9]+|[A-Z]+|[a-z]+/";
        $regex_string = "/(?<angka>[0-9]+)|[x0-9](?<hasil>[0-9]+)/";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];

        if ($this->master->get(['id' => $this->master->getLastId(-1), 'date' => date('y-m-d')])) {
            $this->master->edit(['name' => $angka_result], ['id' => $this->master->getLastId(-1), 'date' => date('y-m-d')]);
        } else {
            $this->master->add(['id' => $this->master->getLastId(), 'id_whatsapp' => $this->session_whatsapp->id_whatsapp, 'date' => date('y-m-d'), 'name' => $angka_result, 'creator' => $this->creator]);
        }

        foreach ($master_result as $key_master => $value_master) {
            $rowValue = preg_match_all($regex, $value_master->name, $matches[$value_master->id], PREG_SET_ORDER);
            foreach ($matches[$value_master->id] as $key_search => $value_search) {
                foreach ($value_search as $key_match => $value_match) {
                    if (!is_numeric($key_match) && !empty($value_match)) {
                        $matches2[$value_master->id][$key_match][] = $value_match;
                    }
                }
            }
        }

        foreach ($master_result as $key_master => $value_master) {
            if (!empty($matches2[$value_master->id]['format'])) {
                foreach ($matches2[$value_master->id]['format'] as $key => $value) {
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
                                    $resultformat[$value_master->id]['angka'][$dummyformat_validate][] = $valued;
                                    $uformat = $keyd + 2;
                                }
                            } else {
                                if ($zformat !== $keyd && $valued == "x") {
                                    $uformat = $keyd + 1;
                                }
                            }

                            if ($uformat == $keyd) {
                                $resultformat[$value_master->id]['hasil'][$dummyformat_validate][] = $valued;
                            }

                            if ($yformat == $keyd) {
                                $resultformat[$value_master->id]['hasil'][$dummyformat_validate][] = $valued;
                                $xformat = $keyd + 1;
                            }

                            if ($xformat == $keyd) {
                                $resultformat[$value_master->id]['angka'][$dummyformat_validate][] = $valued;
                            }
                        }
                    }
                }
            }
        }

        foreach ($master_result as $key_master => $value_master) {
            if (!empty($matches2[$value_master->id]['number2'])) {
                foreach ($matches2[$value_master->id]['number2'] as $key_string => $value_string) {
                    $rowValue = preg_match_all($regex_string, $value_string, $string_val);
                    $dum_hasil = implode(array_filter($string_val['hasil']));

                    foreach ($string_val['angka'] as $key => $value) {
                        if (!empty($value)) {
                            $result4d[$value_master->id]['angka'][strlen($value)][] = $value;
                            $result4d[$value_master->id]['hasil'][strlen($value)][] = $dum_hasil;
                        }
                    }
                }
            }
        }
        foreach ($master_result as $key_master => $value_master) {
            if (!empty($matches2[$value_master->id]['number'])) {
                $x = 0;
                $y = 1;
                foreach ($matches2[$value_master->id]['number'] as $key => $value) {
                    if (!empty($value)) {
                        if ($key == $x) {
                            $result4d[$value_master->id]['angka'][strlen($value)][] = $value;
                            $x = $key + 2;
                            $strln = strlen($value);
                        }
                        if ($key == $y) {
                            $result4d[$value_master->id]['hasil'][$strln][] = $value;
                            $y = $key + 2;
                        }
                    }
                }
            }
        }

        $html_result = "";
        $validate_color = ['black', 'info', 'primary', 'success', 'danger'];
        foreach ($master_result as $key_result => $val_result) {
            $totalprice[$val_result->id] = 0;
            $count[$val_result->id] = "";
            $htmlformatresult[$val_result->id] = "";
            $html4dresult[$val_result->id] = "";
            $sum_price[$val_result->id] = 0;
            $master_row = $this->pesan->get(['id' => $val_result->id]);
            $change_name = $this->kontak->get(['phone' => $val_result->kontak])->name;
            $get_kontak[$val_result->id] = $val_result->kontak;

            if (!empty($result4d[$val_result->id]['angka'])) {
                foreach ($result4d[$val_result->id]['angka'] as $keyd => $valued) {
                    $list[$val_result->id][$keyd] = "";
                    $counts[$val_result->id][$keyd] = 0;
                    $i = 1;
                    if ($keyd !== 1 && $keyd < 5) {
                        foreach ($valued as $key => $value) {
                            if (!empty($value) && $value == $angkapecah[$keyd]) {
                                if (!empty($result4d[$val_result->id]['hasil'][$keyd][$key])) {
                                    $hasil4d = $result4d[$val_result->id]['hasil'][$keyd][$key];
                                    $hasil4drow = $hasil4d * $this->master->price4d($keyd, $hasil4d, $get_kontak[$val_result->id]);
                                    $totalprice[$val_result->id] += $hasil4d;
                                    $sum_price[$val_result->id] += $hasil4drow;
                                    if ($keyd !== 1) {
                                        $counts[$val_result->id][$keyd] += $i;
                                    }
                                    $result[$val_result->id][] = ['id' => $this->master->getLastId(-1), 'keypesan' => $val_result->id, 'kontak' => $val_result->kontak, 'angka' => $value, 'hasil' => $hasil4d, 'format' => $keyd . "D"];
                                    $list[$val_result->id][$keyd] .= $this->load->view($this->main . '/angka', ['angka' => $value, 'hasil' => $hasil4d, 'hadiah' => $hasil4drow, 'color' => $validate_color[$keyd]], true);
                                }
                            }
                        }

                        $count[$val_result->id] .= $keyd . "Ax" . $counts[$val_result->id][$keyd] . ". ";
                    }
                }
                $html4dresult[$val_result->id] .= $this->load->view($this->main . '/list', ['angka' => $list[$val_result->id]], true);
            }

            if (!empty($resultformat[$val_result->id]['angka'])) {
                foreach ($resultformat[$val_result->id]['angka'] as $key2 => $value2) {
                    if (!empty($value2)) {
                        $listf[$val_result->id][$key2] = "";
                        $counts[$val_result->id][$key2] = 0;
                        $i = 1;
                        foreach ($resultformat[$val_result->id]['angka'][$key2] as $key => $value) {
                            if (!empty($resultformat[$val_result->id]['hasil'][$key2][$key])) {
                                if (in_array($value, $angkapecah)) {
                                    $hasilformat = $resultformat[$val_result->id]['hasil'][$key2][$key];
                                    $totalprice[$val_result->id] += $hasilformat;
                                    $sum_price[$val_result->id] += $hasilformat;
                                    $counts[$val_result->id][$key2] += $i;
                                    $result[$val_result->id][] = ['id' => $this->master->getLastId(-1), 'keypesan' => $val_result->id, 'kontak' => $val_result->kontak, 'angka' => $value, 'hasil' => $hasilformat, 'format' => $key2];
                                    $listf[$val_result->id][$key2] .= $this->load->view($this->main . '/format', ['angka' => $value, 'hasil' => $hasilformat, 'hadiah' => $hasilformat, 'color' => $validate_color[2]], true);
                                }
                            }
                        }
                    }

                    if (!empty($listf[$val_result->id][$key2])) {
                        $count[$val_result->id] .= $key2 . "x" . $counts[$val_result->id][$key2] . ". ";
                        $htmlformatresult[$val_result->id] .= $this->load->view($this->main . '/listf', ['angka' => $listf[$val_result->id][$key2], 'format' => $key2], true);
                    }
                }
            }

            if (!empty($html4dresult[$val_result->id]) || !empty($htmlformatresult[$val_result->id])) {
                $this->result_detail->delete(['id' => $this->master->getLastId(-1), 'keypesan' => $val_result->id, 'kontak' => $val_result->kontak]);
                $this->result_detail->insert_multiple($result[$val_result->id]);
                $html_result .= $this->load->view($this->main . '/pengguna', ['master' => $master_row, 'angka' => $html4dresult[$val_result->id], 'player' => $change_name, 'hformat' => $htmlformatresult[$val_result->id], 'totalhd' => $sum_price[$val_result->id], 'totalprice' => $totalprice[$val_result->id], 'count' => $count[$val_result->id]], true);
            }
        }

        if (!empty($html4dresult) || !empty($htmlformatresult) && !empty($this->creator)) {
            $output = array(
                "preview" => $html_result,
                "result" => $angka_result,
            );
            echo json_encode($output);
        }
    }
} //End
