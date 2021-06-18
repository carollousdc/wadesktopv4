<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Tipe extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
        $this->disabled = ['role'];
        $this->change_data = ['role'];
        $this->to_change['role'] = 'navigation';
        $this->select_change['role'] = 'second_id';

        if (empty($this->data['role'])) $this->data['role'] = $this->navigation_sql->gets(['tipe !=' => 0])[0]->second_id;
        $this->data['optionRole'] = $this->navigation_sql->option("role", $this->data['role'], ['tipe !=' => 0], 1, [], "", 'second_id');
    }
}//End  