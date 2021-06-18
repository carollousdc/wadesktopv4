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
        // $regex = "/[^0-9]+/";
        $regex = "/[A-Z]+[(x|.)0-9]+|[0-9]+/i";
        $regex_alpha = "/[A-Z]+/";
        $regex_number = "/[0-9]+/";
        $master_user = [];
        $result = [];
        $array_alpha = [];
        $uniq_alpha = [];
        $uniq_herro = [];
        $validate_format = ['CB', 'CP', 'SET', 'SH'];

        foreach ($master as $key_master => $value_master) {

            $regex2 = "/[0-9.]+[.|\s]/";
            $rowValue2 = preg_match_all($regex, $value_master->name, $matches2);
            foreach ($matches2 as $k_alpha => $seasons) {
                // $result2 = $seasons;

                print_r($seasons);
                foreach ($seasons as $key => $value) {
                    $rowValueAlpha = preg_match_all($regex_number, $seasons[$key], $matches_alpha);
                }
            }

            // $uniq_alpha = array_unique($seasons);
            // $array_alpha[] = $this->pesan->multiexplode($seasons, $value_master->name);
            // $uniq_alpha = array_merge(array_unique($result), [' ']);

            // foreach ($matches_alpha as $k_alpha => $seasons_alpha) {
            //     if (!empty($seasons_alpha)) {
            //         $uniq_alpha = array_merge(array_unique($seasons_alpha), array_unique($matches));
            //         $array_alpha = $this->pesan->multiexplode($uniq_alpha, $value_master->name);
            //         foreach ($array_alpha as $key => $value) {
            //             $uniq_herro[$key] = $value;
            //         }
            //     }

            // }

            // if (!empty($result)) {
            //     $array_explode = array_unique($result);
            //     $array = $this->pesan->multiexplode($array_explode, $value_master->name);
            // }

            // $uniq_herro = array_unique($array_alpha);

            // foreach ($array_alpha as $key => $value) {
            //     if (!empty($value)) {
            //         $angka_master[$value_master->id][] = $value;
            //         $data_player[$value_master->kontak] = $value_master->kontak;
            //     }
            // }
        }

        $validate_angka = [1, 2, 3, 4];
        $validate_hasil = [1, 2, 3, 4];
        $final_array = array();
        $sumHasil = 0;
        $flag = false;
        $i = 0;
        $hasil = [];
        $split_angka = [];
        $split_hasil = [];

        foreach ($angka_master as $rskey => $rsval) {
            $x = 0;
            $y = 1;
            $flag = false;
            foreach ($rsval as $key => $value) {
                if ($x == $key) {
                    if (in_array($rsval[$key], $angkapecah) && strlen($value) <= 4) {
                        $split_angka[$rskey][] = $value;
                        $flag = true;
                        $y = $key + 1;
                    } else {
                        $flag = false;
                    }
                    $x = $x + 2;
                }
                if ($y == $key && $flag == true) {
                    $split_hasil[$rskey][] = $value;
                }
            }
        }

        $html_view = "";
        $angka_keluar = "";
        $hasil_angka = 0;
        $i = 0;

        foreach ($split_angka as $key_result => $val_result) {
            $angka_keluar[$key_result] = "";
            $total_hadiah[$key_result] = 0;
            $master = $this->pesan->get(['id' => $key_result]);
            $origin_contact = $master->kontak;
            $change_data = $this->master->get_change_field();
            $master->kontak = !empty($change_data["kontak"]($master)) ? $change_data["kontak"]($master) : $master->kontak;
            foreach ($val_result as $key => $value) {
                $hasil = $split_hasil[$key_result][$key];
                $hasil_angka += $split_hasil[$key_result][$key];
                $hadiah = $hasil * $this->master->price_pool($angka_result, $val_result[$key], $origin_contact);
                $total_hadiah[$key_result] += $hasil * $this->master->price_pool($angka_result, $val_result[$key], $origin_contact);
                $angka_keluar[$key_result] .= $this->load->view('result/angka', ['angka' => $val_result[$key], 'hasil' => $hasil, 'hadiah' => $hadiah], true);
            }
            $html_view .= $this->load->view('result/pengguna', ['master' => $master, 'angka' => $angka_keluar[$key_result], 'hasil' => $hasil_angka, 'total_hadiah' => $total_hadiah[$key_result], 'player' => $master->kontak], true);
        }

        $output = array(
            "preview" => $html_view,
        );
        echo json_encode($output);
    }

} //End
