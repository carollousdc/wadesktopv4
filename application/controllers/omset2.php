<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Omset extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function omset() {
        $master_wherein = $this->pesan->getsGroupResult(['process_date' => date('y-m-d'), 'm_status' => 1], "kontak");
        $html_view = "";
        foreach ($master_wherein as $key => $value) {
            $list[$value->kontak] = "";
            $totalomset[$value->kontak] = 0;
            $change_name = $this->kontak->get(['phone' => $value->kontak])->name;
            $groupid = $this->pesan->getsGroupResult(['id' => $value->id, 'kontak' => $value->kontak], "id");
            $count[$value->kontak] = count($groupid);
            $angka_result[$value->kontak] = "";
            foreach ($groupid as $keyd => $valued) {
                $omsetrow[$valued->kontak][$valued->id] = 0;
                $rowresult = $this->pesan->gets(['id' => $valued->id]);
                foreach ($rowresult as $keys => $values) {
                    if (in_array($values->format, ['2D', '3D', '4D'])) {
                        $angka_result[$values->kontak] .= $values->format . " (" . $values->angka . ") ";
                        $omsetrow[$valued->kontak][$valued->id] += $values->hasil;
                    }
                }
                $omsetkepala[$valued->kontak]['kepala'] = substr($this->pesan->get(['id' => $valued->id, 'kontak' => $valued->kontak])->name, 0, 7);
                $list[$value->kontak] .= $this->load->view($this->main . '/list', ['omsetrow' => $omsetrow[$valued->kontak][$valued->id], 'kepala' => $omsetkepala[$valued->kontak]['kepala']], true);
                $totalomset[$valued->kontak] += $omsetrow[$valued->kontak][$valued->id];
            }

            $html_view .= $this->load->view($this->main . '/pengguna', ['player' => $change_name, 'list' => $list[$value->kontak], 'totalomset' => $totalomset[$valued->kontak], 'count' => $count[$value->kontak], 'angka_result' => $angka_result[$value->kontak], 'time' => $value->create_date], true);
        }

        $output = array(
            "html_view" => $html_view,
        );

        echo json_encode($output);
    }
} //End
