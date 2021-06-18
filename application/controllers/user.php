<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class User extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
        $this->change_option['gender'] = ['custom' => ['Pria', 'Wanita'], 'must' => 1];
    }
} //End
