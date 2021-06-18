<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Pesan_asli extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function getHistoryMessage() {
        $preview = "";
        $master = $this->pesan->gets(['m_status' => 1, 'process_date' => date('y-m-d')], 0, ['create_date', 'DESC']);
        $tablerow = "";
        $no = 1;
        foreach ($master as $key => $value) {
            if (!empty($this->kontak->get(['phone' => $value->kontak])->name)) {
                $getname = $this->kontak->get(['phone' => $value->kontak])->name;
            } else {
                $getname = $value->kontak;
            }
            $tablerow .= '<tr>';
            $tablerow .= '<td>' . $no++ . '</td>';
            $tablerow .= '<td>' . $getname . '</td>';
            $tablerow .= '<td style="width:500px;white-space: normal;word-break: break-all;">' . $value->name . '</td>';
            $tablerow .= '<td>' . $value->create_date . '</td>';
            $tablerow .= '</tr>';
        }

        $preview .= $this->load->view($this->main . '/table', ['tablerow' => $tablerow], true);

        $output = array(
            "html_view" => $preview,
        );
        echo json_encode($output);
    }

} //End
