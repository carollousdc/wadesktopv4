<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Create_sql extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->tabel = "create";
    }

    function get_post_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get($this->tabel);
        return $query->row();
    }
} //End
