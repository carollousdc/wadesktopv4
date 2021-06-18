<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Omset extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function omset()
    {
        $master_wherein = $this->omset->getsGroupResult(['date' => date('y-m-d')], "kontak");
        $html_view = "";
        $validate_format = ['CB', 'CP', 'SET', 'SH'];

        foreach ($master_wherein as $key => $value) {
            $angka_result[$value->kontak] = "";
            $change_name = $this->kontak->get(['phone' => $value->kontak])->name;
            $list[$value->kontak] = "";
            $listf[$value->kontak] = "";
            $totalomset[$value->kontak] = 0;
            foreach ($this->omset->gets(['date' => date('y-m-d'), 'kontak' => $value->kontak]) as $keyd => $valued) {
                $angkaformat_result[$valued->kontak] = "";
                $omsetrow[$valued->kontak] = 0;
                $omsetformatrow[$valued->kontak] = 0;

                $rowresult = $this->omset_detail->gets(['id' => $valued->id, 'kontak' => $valued->kontak]);
                foreach ($rowresult as $keys => $values) {
                    if (in_array($values->format, ['2D', '3D', '4D'])) {
                        $angka_result[$values->kontak] .= " (" . $values->angka . ") ";
                        $omsetrow[$values->kontak] += $values->hasil;
                    } else {
                        if (in_array($values->format, $validate_format)) {
                            $angkaformat_result[$values->kontak] .= " (" . $values->angka . ") ";
                            $omsetformatrow[$values->kontak] += $values->hasil;
                        }
                    }
                }
                $totalomset[$valued->kontak] += $omsetrow[$valued->kontak];
                $omsetkepala[$valued->kontak]['kepala'] = substr($valued->name, 0, 5);
                $list[$value->kontak] .= $this->load->view($this->main . '/list', ['omsetrow' => $omsetrow[$valued->kontak], 'kepala' => $omsetkepala[$valued->kontak]['kepala']], true);
                $listf[$value->kontak] .= $this->load->view($this->main . '/listf', ['kepala' => $omsetkepala[$valued->kontak]['kepala'], 'omsetformatrow' => $omsetformatrow[$valued->kontak]], true);
            }
            $count[$value->kontak] = count($this->omset->gets(['date' => date('y-m-d'), 'kontak' => $value->kontak]));
            if (!empty($angka_result[$value->kontak])) {
                $html_view .= $this->load->view($this->main . '/pengguna', ['player' => $change_name, 'list' => $list[$value->kontak], 'listf' => $listf[$value->kontak], 'totalomset' => $totalomset[$value->kontak], 'count' => $count[$value->kontak], 'angka_result' => $angka_result[$valued->kontak], 'time' => $value->create_date], true);
            }
        }

        $output = array(
            "html_view" => $html_view,
        );

        echo json_encode($output);
    }

    public function downloadomset()
    {
        $filecontent = "This is sample";
        $downloadfile = "test.txt";

        $writer = new txt($filecontent);
        header('Content-Type: plain/text');
        header('Content-Disposition: attachment; filename="' . urlencode($downloadfile) . '"');
        $writer->save('php://output');
    }
} //End
