<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Result extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function check_result()
    {
        $angka_result = $this->input->post('hasil');
        $angkapecah = [$angka_result, substr($angka_result, -3, 3), substr($angka_result, -2, 2), substr($angka_result, 1, 1)];
        $master = $this->pesan->gets(['m_status' => 1, 'status' => 0]);
        $data['hasil_pengguna'] = [];
        $regex = "/[A-Z]+[(x|.)0-9]+|[0-9]+/i";
        $regex_number = "/[0-9]+|[A-Z]+|[a-z]+/";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];
        foreach ($master as $key_master => $value_master) {
            $rowValue = preg_match_all($regex, $value_master->name, $matches);
            foreach ($matches as $key_search => $value_search) {
                foreach ($value_search as $key_match => $value_match) {
                    if (!is_numeric($value_match)) {
                        $rowValue = preg_match_all($regex_number, $value_match, $matches3[$value_master->id][]);
                    } else {
                        $matches2[$value_master->id]['number'][] = $value_match;
                    }
                }
            }
        }

        foreach ($master as $key_master => $value_master) {
            $x = 0;
            $y = 1;
            $flag = false;
            foreach ($matches2[$value_master->id]['number'] as $key => $value) {
                if ($x == $key) {
                    if (in_array($value, $angkapecah) && strlen($value) <= 4) {
                        if (empty($user_win[$value_master->id])) {
                            $user_win[$value_master->id] = 1;
                        }

                        $result4d[$value_master->id]['angka'][strlen($value)][] = $value;
                        $dummyangka = strlen($value);
                        $y = $key + 1;
                        $flag = true;
                    } else {
                        $flag = false;
                    }
                    $x = $x + 2;
                }
                if ($y == $key && $flag == true) {
                    $result4d[$value_master->id]['hasil'][$dummyangka][] = $value;
                }
            }

            foreach ($matches3[$value_master->id] as $key => $value) {
                foreach ($value as $keys => $values) {
                    $xformat = 999;
                    $yformat = 999;
                    $zformat = 999;
                    $uformat = 999;
                    $flag = false;
                    $flagx = false;
                    foreach ($values as $keyd => $valued) {
                        if ($valued == "CB" || $valued == "SET") {
                            $zformat = $keyd + 1;
                            $dummyformat_validate = $valued;
                        }

                        if ($zformat == $keyd) {
                            if ($valued == "x") {
                                $yformat = $keyd + 1;
                            } else {
                                if (in_array($valued, str_split($angka_result)) || $valued == $angka_result) {
                                    if (empty($user_win[$value_master->id])) {
                                        $user_win[$value_master->id] = 1;
                                    }
                                    $resultformat[$value_master->id]['angka'][$dummyformat_validate][] = $valued;
                                    $uformat = $keyd + 2;
                                    $flagx = true;
                                }
                            }
                        } else {
                            if ($zformat !== $keyd && $valued == "x" && $flagx == true) {
                                $uformat = $keyd + 1;
                            }
                        }

                        if ($uformat == $keyd & $flagx == true) {
                            $resultformat[$value_master->id]['hasil'][$dummyformat_validate][] = $valued;
                        }

                        if ($yformat == $keyd) {
                            $dummyhasil_validate = $valued;
                            $xformat = $keyd + 1;
                        }

                        if ($xformat == $keyd) {
                            if (in_array($valued, str_split($angka_result)) || $valued == $angka_result) {
                                if (empty($user_win[$value_master->id])) {
                                    $user_win[$value_master->id] = 1;
                                }
                                $resultformat[$value_master->id]['angka'][$dummyformat_validate][] = $valued;
                                $resultformat[$value_master->id]['hasil'][$dummyformat_validate][] = $dummyhasil_validate;
                            }
                        }
                    }
                }
            }
        }

        $html_result = "";
        $html4d = [];
        $vv_angka = [];

        if (!empty($user_win)) {
            foreach ($user_win as $key_result => $val_result) {
                $html4d[$key_result] = "";
                $htmlformat[$key_result] = "";
                $master = $this->pesan->get(['id' => $key_result]);
                $get_kontak[$key_result] = $master->kontak;
                $change_data = $this->master->get_change_field();
                $master->kontak = !empty($change_data["kontak"]($master)) ? $change_data["kontak"]($master) : $master->kontak;

                for ($i = 4; $i > 1; $i -= 1) {

                    if (!empty($result4d[$key_result]['angka'][$i])) {
                        foreach ($result4d[$key_result]['angka'][$i] as $key => $value) {
                            if (empty($format[$key_result][$i]) && $key == 0) {
                                $format[$key_result][$i] = $i . "D";
                            } else {
                                $format[$key_result][$i] = "";
                            }

                            $hasil4d = $result4d[$key_result]['hasil'][$i][$key];
                            $hadiah4d = $hasil4d * $this->master->price_pool($angka_result, $value, $get_kontak[$key_result]);
                            $html4d[$key_result] .= $this->load->view($this->main . '/angka', ['angka' => $value, 'hasil' => $hasil4d, 'hadiah' => $hadiah4d, 'format' => $format[$key_result][$i]], true);
                        }
                    }
                }

                foreach ($resultformat[$key_result]['angka'] as $key2 => $value2) {
                    if (!empty($value2)) {
                        foreach ($resultformat[$key_result]['angka'][$key2] as $key => $value) {
                            if (!empty($resultformat[$key_result]['hasil'][$key2][$key])) {
                                $hasilformat = $resultformat[$key_result]['hasil'][$key2];

                                if ($key == 0) {
                                    $vv_format = $key2;
                                } else {
                                    $vv_format = "";
                                }

                                $htmlformat[$key_result] .= $this->master->priceformat($angka_result, $hasilformat[$key], $hasilformat, $vv_format, $get_kontak[$key_result], $value, $key2);
                            }
                        }
                    }
                }

                $html_result .= $this->load->view('result/pengguna', ['master' => $master, 'angka' => $html4d[$key_result], 'player' => $master->kontak, 'hformat' => $htmlformat[$key_result]], true);
            }
        }

        $output = array(
            "preview" => $html_result,
        );
        echo json_encode($output);
    }



    public function previewChat()
    {
        $id = $this->input->post('id');
        $master = $this->pesan->gets(['id' => $id, 'status' => 0]);
        $data['hasil_pengguna'] = [];
        // $regex = "/[A-Z]+[(x|.)0-9]+|[0-9]+/i";
        $regex = "/(?<format>[A-Z]+[(x|.)0-9]+)|(?<number2>[0-9.]+x[0-9].)|(?<number>[0-9]+)/i";
        $regex_number = "/[0-9]+|[A-Z]+|[a-z]+/";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];
        foreach ($master as $key_master => $value_master) {
            $rowValue = preg_match_all($regex, $value_master->name, $matches, PREG_SET_ORDER);
            foreach ($matches as $key_search => $value_search) {
                foreach ($value_search as $key_match => $value_match) {
                    if (!is_numeric($key_match) && !empty($value_match)) {
                        $matches2[$value_master->id][$key_match][] = $value_match;
                    }
                }
            }
        }

        foreach ($master as $key_master => $value_master) {


            if (!empty($matches2[$value_master->id]['format'])) {
                foreach ($matches2[$value_master->id]['format'] as $keyd => $valued) {
                    $xformat = 999;
                    $yformat = 999;
                    $zformat = 999;
                    $uformat = 999;
                    $flag = false;
                    $flagx = false;
                    if ($valued == "CB" || $valued == "SET") {
                        $zformat = $keyd + 1;
                        $dummyformat_validate = $valued;
                    }

                    if ($zformat == $keyd) {
                        if ($valued == "x") {
                            $yformat = $keyd + 1;
                        } else {
                            if (empty($user_win[$value_master->id])) {
                                $user_win[$value_master->id] = 1;
                            }
                            $resultformat[$value_master->id]['angka'][$dummyformat_validate][] = $valued;
                            $uformat = $keyd + 2;
                            $flagx = true;
                        }
                    } else {
                        if ($zformat !== $keyd && $valued == "x" && $flagx == true) {
                            $uformat = $keyd + 1;
                        }
                    }

                    if ($uformat == $keyd & $flagx == true) {
                        $resultformat[$value_master->id]['hasil'][$dummyformat_validate][] = $valued;
                    }

                    if ($yformat == $keyd) {
                        $dummyhasil_validate = $valued;
                        $xformat = $keyd + 1;
                    }

                    if ($xformat == $keyd) {
                        if (empty($user_win[$value_master->id])) {
                            $user_win[$value_master->id] = 1;
                        }
                        $resultformat[$value_master->id]['angka'][$dummyformat_validate][] = $valued;
                        $resultformat[$value_master->id]['hasil'][$dummyformat_validate][] = $dummyhasil_validate;
                    }
                }
            }
        }
        print_r($resultformat);
        die();

        $html_result = "";
        $html4d = [];
        $validate_color = ['black', 'info', 'primary', 'success', 'danger'];
        if (!empty($user_win)) {
            foreach ($user_win as $key_result => $val_result) {
                $html4d[$key_result] = "";
                $htmlformat[$key_result] = "";
                $count[$key_result] = "";
                $master = $this->pesan->get(['id' => $key_result]);
                $get_kontak[$key_result] = $master->kontak;

                for ($i = 4; $i > 1; $i -= 1) {
                    if (!empty($result4d[$key_result]['angka'][$i])) {
                        foreach ($result4d[$key_result]['angka'][$i] as $key => $value) {
                            if (!empty($result4d[$key_result]['hasil'][$i][$key]) && !empty($value)) {
                                if (empty($format[$key_result][$i]) && $key == 0) {
                                    $format[$key_result][$i] = $i . "D";
                                } else {
                                    $format[$key_result][$i] = "";
                                }
                                $hasil4d = $result4d[$key_result]['hasil'][$i][$key];
                                $hasil4d > 100 ? $color = "" : $color = $validate_color[$i];
                                $html4d[$key_result] .= $this->load->view('pesan/angka', ['angka' => $value, 'hasil' => $hasil4d, 'format' => $format[$key_result][$i], 'color' => $color], true);
                            }
                        }
                        $count[$key_result] .= $i . "D: " . count($result4d[$key_result]['angka'][$i]) . " ";
                    }
                }

                if (!empty($resultformat[$key_result]['angka'])) {
                    foreach ($resultformat[$key_result]['angka'] as $key2 => $value2) {
                        if (!empty($value2)) {
                            foreach ($resultformat[$key_result]['angka'][$key2] as $key => $value) {
                                if (!empty($resultformat[$key_result]['hasil'][$key2][$key])) {
                                    $hasilformat = $resultformat[$key_result]['hasil'][$key2][$key];
                                    if ($key == 0) {
                                        $vv_format = "<br />" . $key2 . "<br />";
                                    } else {
                                        $vv_format = "";
                                    }
                                    $htmlformat[$key_result] .= $this->load->view('pesan/format', ['angka' => $value, 'hasil' => $hasilformat, 'format' => $vv_format, 'color' => 'info'], true);
                                }
                            }
                        }
                        $count[$key_result] .= $key2 . ": " . count($resultformat[$key_result]['angka'][$key2]) . " ";
                    }
                }

                $html_result .= $this->load->view('pesan/pengguna', ['master' => $master, 'angka' => $html4d[$key_result], 'player' => $master->kontak, 'hformat' => $htmlformat[$key_result]], true);
            }
        }

        if (empty($count[$id])) $count[$id] = 0;

        $output = array(
            "preview" => $html_result,
            "count4d" => $count[$id],
        );
        echo json_encode($output);
    }
} //End
