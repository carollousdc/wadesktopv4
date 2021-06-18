<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Pesan extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));

        if (empty($this->data['m_status'])) {
            $this->data['m_status'] = 0;
        }

        $this->data['optionStatus'] = $this->master->option('m_status_edit', $this->data['m_status'], [], 1, $this->master->status_name);
    }

    public function editData() {
        $data       = $this->master->get(['id' => $this->input->post('id'), 'm_status !=' => 1]);
        $data_key   = [];
        $count_data = $this->master->get_validate_data_edit();

        foreach ($count_data as $key => $val) {
            $data_key[$key] = $val;
        }

        if ($this->kontak->get(['phone' => $data->kontak, 'status' => 0])) {
            $get_contact = $this->kontak->get(['phone' => $data->kontak, 'status' => 0])->name;
        } else {
            $get_contact = $data->kontak;
        }

        $output = array(
            "data"      => $data,
            "kontak"    => $get_contact,
            "key"       => $data_key,
            "key_count" => count($count_data),
        );
        echo json_encode($output);
    }

    public function tambahData() {
        $my_apikey        = "6YYYBG2COJH11HVLKROA";
        $markaspulled     = 1;
        $getnotpulledonly = 1;
        $api_url          = "http://panel.rapiwha.com/get_messages.php?apikey=" . $my_apikey . "&type=IN&markaspulled=" . $markaspulled . "&getnotpulledonly=" . $getnotpulledonly;
        $my_json_result   = file_get_contents($api_url, false);
        $my_php_arr       = json_decode($my_json_result);
        $data['result']   = [];

        $master_id = $this->master->getLastId();
        $check_id  = $this->master->getLastId(-1);

        if (!empty($my_php_arr)) {
            foreach ($my_php_arr as $item) {
                $regex = "/([0-9]+)|([0-9]+)(x|\.)/i";
                preg_match_all($regex, $item->text, $text);
                $i    = 1;
                $x    = 0;
                $stop = ((count($text[1]) + 1) / 2);
                for ($i = 1; $i <= $stop; $i++) {
                    $data['result'][] = ['angka' => $text[1][$x++], 'hasil' => $text[1][$x++]];
                }

                if ($this->master->gets(['id' => $check_id, 'kontak' => $item->from, 'm_status !=' => 1])) {
                    $this->master->edit(['name' => $item->text, 'process_date' => $item->process_date, 'm_status' => 0, 'creator' => $this->creator], ['id' => $check_id, 'kontak' => $item->from]);
                } else {
                    $this->master->add(['id' => $master_id, 'kontak' => $item->from, 'name' => $item->text, 'process_date' => $item->process_date, 'id_whatsapp' => $item->number, 'creator' => $this->creator]);
                }
            }
            $flag  = true;
            $check = $this->kontak->get(['phone' => $item->from, 'status' => 0]);
            if ($check) {
                $sender    = $check->name;
                $toastInfo = 'info';
            } else {
                $sender    = $item->from;
                $toastInfo = 'warning';
            }

        } else {
            $flag      = false;
            $toastInfo = '';
            $sender    = '';
        }

        $master = $this->master->gets(['m_status !=' => 1, 'status' => 0]);

        $result = array(
            'count'    => count($data),
            'callback' => $flag,
            'info'     => $toastInfo,
            'sender'   => $sender,
            'data'     => $data,
        );
        $json = json_encode($data);
        echo $json;
    }

    public function perbaruiData() {
        $data      = [];
        $my_apikey = "6YYYBG2COJH11HVLKROA";
        $data      = $this->master->loopingDataPost($this->input->post(), "_edit");

        if ($this->master->edit($data, ['id' => $data['id'], 'm_status !=' => 1])) {
            $master           = $this->master->gets(['id' => $data['id']]);
            $api_url_message  = "https://panel.rapiwha.com/send_message.php?apikey=" . urlencode($my_apikey) . "&number=" . urlencode($master[0]->kontak) . "&text=" . urlencode("pesan: " . $data['name'] . " status: " . $this->master->status_name[$data['m_status']] . " date: " . $master[0]->create_date);
            $my_result_object = json_decode(file_get_contents($api_url_message, false));
        }
    }

} //End
