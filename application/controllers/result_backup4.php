<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Result extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function check_result() {
        $angka_result = $this->input->post('hasil');
        $angkapecah = [$angka_result, substr($angka_result, -3, 3), substr($angka_result, -2, 2)];
        $master = $this->pesan->gets(['m_status' => 1, 'status' => 0]);
        $hasil_view = [];
        $data['hasil_pengguna'] = [];
        $regex = "/[A-Z]+[(x|.)0-9]+|[0-9]+/i";
        $regex_alpha = "/[A-Z]+/";
        $regex_number = "/[0-9]+|[A-Z]+/";
        $regex_other = "/[0-9(x|.)]+/i";
        $master_user = [];
        $result = [];
        $array_alpha = [];
        $uniq_alpha = [];
        $uniq_herro = [];
        $string = "";
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
                        $user_win[$value_master->id] = 1;
                        $result4d[$value_master->id]['angka'][] = $value;
                        $y = $key + 1;
                        $flag = true;
                    } else {
                        $flag = false;
                    }
                    $x = $x + 2;
                }
                if ($y == $key && $flag == true) {
                    $result4d[$value_master->id]['hasil'][] = $value;
                }
            }

            if (!empty($matches3[$value_master->id])) {
                $xformat = 999;
                $yformat = 999;
                $flag = false;
                foreach ($matches3[$value_master->id] as $key => $value) {
                    foreach ($value as $keys => $values) {
                        foreach ($values as $keyd => $valued) {
                            if ($valued == "CB") {
                                $xformat = $keyd + 1;
                            }
                            if ($xformat == $keyd) {
                                $yformat = $keyd + 1;
                                $resultformat[$value_master->id]['angka'][] = $valued;
                            }
                            if ($yformat == $keyd) {
                                $resultformat[$value_master->id]['hasil'][] = $valued;
                            }

                        }
                    }
                }
            }
        }

        $html_result = "";
        $html4d = [];
        $totalhd4a = 0;

        // if (!empty($user_win)) {
        //     foreach ($user_win as $key_result => $val_result) {
        //         $html4d[$key_result] = "";
        //         $totalhd4a = 0;
        //         $master = $this->pesan->get(['id' => $key_result]);
        //         $get_kontak[$key_result] = $master->kontak;
        //         $change_data = $this->master->get_change_field();
        //         $master->kontak = !empty($change_data["kontak"]($master)) ? $change_data["kontak"]($master) : $master->kontak;

        //         if (!empty($result_angka_pasang[$key_result])) {
        //             foreach ($result_angka_pasang[$key_result] as $key => $value) {
        //                 $hasil = $result_angka_hasil[$key_result][$key];
        //                 $hadiah = $hasil * $this->master->price_pool($angka_result, $value, $get_kontak[$key_result]);
        //                 $html4d[$key_result] .= $this->load->view($this->main . '/angka', ['angka' => $value, 'hasil' => $hasil, 'hadiah' => $hadiah], true);
        //             }
        //         }

        //         if (!empty($angka_format)) {
        //             foreach ($angka_format[$key_result] as $value) {
        //                 if (strpos($angka_result, $value)) {
        //                     $angka = $value;
        //                     $hasil = 22;
        //                     $hadiah = 11;
        //                     $html4d[$key_result] .= $this->load->view($this->main . '/angka', ['angka' => $angka, 'hasil' => $hasil, 'hadiah' => $hadiah], true);

        //                 }

        //             }
        //         }

        //     }

        //     $html_result .= $this->load->view('result/pengguna', ['master' => $master, 'angka' => $html4d[$key_result], 'player' => $master->kontak], true);
        // }

        $output = array(
            "preview" => $html_result,
        );
        echo json_encode($output);
    }

} //End
