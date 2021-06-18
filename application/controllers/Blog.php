<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/homeTemplate.php';
class Blog extends homeTemplate
{
    public function __construct()
    {
        parent::__construct('content', 'create');
        $this->load->model('create_sql');
    }

    function detail($slug)
    { //fungsi untuk menampilkan detail artikel
        $data = $this->create_sql->get_post_by_slug($slug);
        // if ($data->num_rows() > 0) { // validasi jika data ditemukan
        $this->data['x'] = $data;
        $this->data['bodyClass'] = '<body class="single-post">';
        $this->load->view('headerHome', $this->data);
        $this->load->view('content', $this->data);
        $this->load->view('footerHome', $this->data);
        // } else {
        //     //jika data tidak ditemukan, maka kembali ke blog
        //     redirect('blog');
        // }
    }
}//End