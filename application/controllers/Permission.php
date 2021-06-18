<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Permission extends saTemplate
{
    public function __construct()
    {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
        $this->to_change['menu'] = 'navigation';
        $this->change_tipe_manual['action'] = ['create', 'read', 'update', 'delete'];

        if (empty($this->data['role'])) $this->data['role'] = $this->role->gets()[0]->id;
        $this->data['optionRole'] = $this->role->option("role", $this->data['role'], [], 1);
        if (empty($this->data['menu'])) $this->data['menu'] = $this->navigation->gets(['tipe !=' => 0])[0]->id;
        $this->data['optionMenu'] = $this->navigation->option("menu", $this->data['menu'], ['tipe !=' => 0], 1);
    }
}//End  