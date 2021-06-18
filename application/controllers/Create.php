<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Create extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    function tambahData()
    {
        $data = [];
        foreach ($this->input->post() as $key => $value) {
            if (!empty($value)) {
                $data[$key] = $value;
                $data['creator'] = $_SESSION['id'];
            }
        }

        $string = preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $data['name']);
        $trim = trim($string);
        $pre_slug = strtolower(str_replace(" ", "-", $trim));
        $slug = $pre_slug . '.html';
        $data['slug'] = $slug;

        $data = $this->master->add($data);
        echo json_encode($data);
    }
}//End