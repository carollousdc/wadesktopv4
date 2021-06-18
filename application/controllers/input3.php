<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Input extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));

        if (empty($this->data['kontak'])) {
            $this->data['kontak'] = $this->kontak->gets()[0]->phone;
        }
        $this->data['optionKontak'] = $this->kontak->option("kontak", $this->data['kontak'], [], 1, [], "", "phone");
    }

    public function inputwa()
    {
        $data = [];
        $data = $this->master->loopingDataPost($this->input->post());
        $data['id'] = $this->pesan->getLastId(0, $data['kontak']);
        $data['id_whatsapp'] = $this->session_whatsapp->id_whatsapp;
        $data_arr['id'] = $data['id'];
        $omsetId = $this->omset->getLastId();
        $omsetArrId = $omsetId;

        $regex = "/(?<format>[A-Z]+[(x|.)0-9]+)|(?<number2>[0-9(.|\s)]+x[0-9]+[.|\s])|(?<number>[0-9]+)/i";
        $regex_number = "/[0-9]+|[A-Z-a-z]+|[a-z]+/";
        $regex_string = "/(?<angka>[0-9]+)|[x0-9](?<hasil>[0-9]+)/";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];
        if ($this->pesan->add(['id' => $data['id'], 'kontak' => $data['kontak'], 'id_whatsapp' => $data['id_whatsapp'], 'name' => $data['name'], 'process_date' => date('y-m-d'), 'm_status' => 1, 'creator' => $this->creator])) {
            $this->pesan_detail->add(['id' => $data_arr['id'], 'name' => $data['name'], 'kontak' => $data['kontak'], 'm_status' => 1]);
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
                                $dummyformat_validate = strtoupper($valued);
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
                                    $omset4d = $hasil4d * $this->pesan->price4d($keyd, $hasil4d, $data['kontak']);
                                    $resultomset[] = ['id' => $omsetArrId, 'keypesan' => $data_arr['id'], 'kontak' => $data['kontak'], 'angka' => $value, 'hasil' => $hasil4d, 'format' => $keyd . "D"];
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
                                $omsetformat += $hasilformat;
                                $resultomset[] = ['id' => $omsetArrId, 'keypesan' => $data_arr['id'], 'kontak' => $data['kontak'], 'angka' => $value, 'hasil' => $hasilformat, 'format' => strtoupper($key2)];
                            }
                        }
                    }
                }
            }

            if (!empty($resultomset)) {
                if ($this->omset->add(['id' => $omsetId, 'keypesan' => $data_arr['id'], 'name' => $data['name'], 'kontak' => $data['kontak'], 'id_whatsapp' => $this->session_whatsapp->id_whatsapp, 'omset4d' => $omset4d, 'omsetformat' => $omsetformat, 'date' => date('Y-m-d'), 'creator' => $this->creator])) {
                    $this->omset_detail->insert_multiple($resultomset);
                }
            }
        }
    } //1

    public function getpreviewchat()
    {
        $kontak = $this->input->post('kontak');
        $name_value = $this->input->post('name');
        $regex = "/(?<format>((?!x([A-Z-a-z]+))[0-9]+x[0-9(.|\s)]+))|(?<number2>[0-9(.|\s)]+x[0-9]+[.|\s])|(?<number>[0-9]+)/i";
        $regex_number = "/[0-9]+|[A-Z-a-z]+|[a-z]+/";
        $regex_string = "/(?<angka>[0-9]+)|[x0-9](?<hasil>[0-9]+)/";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];

        $rowValue = preg_match_all($regex, $name_value, $matches, PREG_SET_ORDER);
        foreach ($matches as $key_search => $value_search) {
            foreach ($value_search as $key_match => $value_match) {
                if (!is_numeric($key_match) && !empty($value_match)) {
                    $matches2[$key_match][] = $value_match;
                }
            }
        }

        print_r($matches);
        print_r($matches2);
        // print_r('masuk');

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
                        if (in_array(strtoupper($valued), $validate_format)) {
                            $zformat = $keyd + 1;
                            $dummyformat_validate = strtoupper($valued);
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

        // print_r($matches2);

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
                            $htmlformat .= $this->load->view('pesan/format', ['angka' => $value, 'hasil' => $hasilformat, 'format' => strtoupper($vv_format), 'color' => 'info'], true);
                        }
                    }
                }
                $count .= $key2 . ": " . count($resultformat['angka'][$key2]) . " ";
            }
        }

        $html_result .= $this->load->view($this->main . '/pengguna', ['angka' => $html4d, 'player' => $kontak, 'hformat' => $htmlformat, 'sum_price' => $sum_price], true);

        if (empty($count)) {
            $count = 0;
        }

        $output = array(
            "preview" => $html_result,
            "count4d" => $count,
        );
        echo json_encode($output);
    }
} //End
