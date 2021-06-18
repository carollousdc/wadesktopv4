<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Kirim extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
        if (!isset($this->data['kontak'])) {
            $this->data['kontak'] = $this->kontak->gets()[0]->id;
        }

        $this->data['optionKontak'] = $this->kontak->option("kontak_filter", $this->data['kontak'], [], 1);
        $this->data['optionKontakFilter'] = $this->kontak->option("kontak", $this->data['kontak'], [], 1);
        $this->remove_action_edit = 1;
    }

    public function send_message()
    {
        $exp = "_filter";
        $data = $this->master->loopingDataPost($this->input->post(), $exp);
        $master_kontak = $this->kontak->get(['id' => $data['kontak'], 'status' => 0]);

        $api_url_message = "https://panel.rapiwha.com/send_message.php?apikey=" . urlencode($this->my_api_whatsapp) . "&number=" . urlencode($master_kontak->phone) . "&text=" . urlencode($data['name']);
        $my_result_object = json_decode(file_get_contents($api_url_message, false));

        if ($my_result_object) {
            if ($my_result_object->result_code == 0) {
                if ($this->master->add($data)) {
                    $flag['send'] = 'Dikirim ke: ' . $master_kontak->name;
                    $flag['message'] = $this->master->response_message_api[abs($my_result_object->result_code)];
                }
            } else {
                $flag['send'] = 'GAGAL !!!';
                $flag['message'] = $this->master->response_message_api[abs($my_result_object->result_code)];
            }
        } else {
            $flag['send'] = 'GAGAL !!!' . $master_kontak->name;
            $flag['message'] = $this->master->response_message_api[abs($my_result_object->result_code)];
        }

        $result = array(
            'send' => $flag['send'],
            'message' => $flag['message'],
        );

        $json = json_encode($result);
        echo $json;
    }

    public function reset_message()
    {
        $flag = FALSE;
        $response = "Session login tidak ada. Harap login kembali.";
        $exp = "_filter";
        $data = $this->master->loopingDataPost($this->input->post(), $exp);
        if (!empty($this->creator)) {
            $flag = TRUE;
            if ($this->master->get(['kontak' => $data['kontak']])) {
                $this->master->delete(['kontak' => $data['kontak']]);
                $flag = TRUE;
                $response = "Data pesan " . $this->kontak->get(['id' => $data['kontak']])->name . " berhasil dihapus";
            } else {
                $flag = FALSE;
                $response = "Tidak ada data pesan yang dapat dihapus.";
            }
        }
        $output = array(
            'flag' => $flag,
            'response' => $response,
        );
        echo json_encode($output);
    }
} //End
