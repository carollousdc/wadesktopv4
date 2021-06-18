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
        $regex_number = "/[0-9]+/";
        $regex_other = "/[0-9(x|.)]+/i";
        $master_user = [];
        $result = [];
        $array_alpha = [];
        $uniq_alpha = [];
        $uniq_herro = [];
        $string = "";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];
        foreach ($master as $key_master => $value_master) {
            $regex2 = "/[0-9.]+[.|\s]/";
            $rowValue2 = preg_match_all($regex, $value_master->name, $matches2);
            foreach ($matches2 as $k_alpha => $seasons) {
                $x = 0;
                $y = 1;
                $flag = false;
                foreach ($seasons as $key => $value) {
                    if (is_numeric($value)) {
                        if ($x == $key) {
                            if (in_array($value, $angkapecah) && strlen($value) <= 4) {
                                $user_win[$value_master->id] = 1;
                                $result_angka_pasang[$value_master->id][] = $seasons[$x];
                                $y = $key + 1;
                                $flag = true;
                            } else {
                                $flag = false;
                            }
                            $x = $x + 2;
                        }
                        if ($y == $key && $flag == true) {
                            $result_angka_hasil[$value_master->id][] = $value;
                        }
                    } else {
                        $rowValueFormat = preg_match_all($regex_alpha, $value, $matches_format);
                        $rowValue = preg_match_all($regex_number, $value, $matches_value_format);
                        foreach ($matches_format as $value_format) {
                            if ($value_format[0] == 'CB') {
                                $user_win[$value_master->id] = 1;
                                $result_angka_format[$value_master->id][] = $matches_value_format[0][0];
                                $result_hasil_format[$value_master->id][] = $matches_value_format[0][1];

                                $result_kode_format[$value_master->id][] = $value_format[0];
                            }
                        }
                        $x = $key + 1;
                    }
                }
            }
        }

        $html_result = "";
        $html4d = "";
        $totalhd4a = 0;

        foreach ($user_win as $key_result => $val_result) {
            $angka_keluar[$key] = "";
            $total_hadiah[$key] = 0;
            $master = $this->pesan->get(['id' => $key_result]);
            $get_kontak[$key_result] = $master->kontak;
            $change_data = $this->master->get_change_field();
            $master->kontak = !empty($change_data["kontak"]($master)) ? $change_data["kontak"]($master) : $master->kontak;
            if (!empty($result_angka_pasang)) {
                foreach ($result_angka_pasang[$key_result] as $key => $value) {
                    $hasil = $result_angka_hasil[$key_result][$key];
                    $totalhd4a += $result_angka_hasil[$key_result][$key];
                    $hadiah = $hasil * $this->master->price_pool($angka_result, $value, $get_kontak[$key_result]);
                    $html4d .= $this->load->view($this->main . '/angka', ['angka' => $value, 'hasil' => $hasil, 'hadiah' => $hadiah], true);
                }
            }

            // if (!empty($result_angka_format)) {
            //     foreach ($result_angka_format[$key_result] as $key => $value) {
            //         $hasil = $result_angka_hasil[$key_result][$key];
            //         $kode = $result_angka_format[$key_result][$key];
            //         $totalhd4a += $result_angka_hasil[$key_result][$key];
            //         $hadiah = $hasil * $this->master->price_pool($angka_result, $value, $get_kontak[$key_result]);
            //         $html4d .= $this->load->view($this->main . '/angka', ['angka' => $value, 'hasil' => $hasil, 'hadiah' => $hadiah], true);
            //     }
            // }

            $html_result .= $this->load->view('result/pengguna', ['master' => $master, 'angka' => $html4d, 'hasil' => $totalhd4a, 'total_hadiah' => $hadiah, 'player' => $master->kontak], true);
        }

        // print_r($html_result);

        $output = array(
            "preview" => $html_result,
        );
        echo json_encode($output);
    }

} //End
