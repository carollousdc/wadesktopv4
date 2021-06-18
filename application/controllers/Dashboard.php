<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Dashboard extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME));
    }

    public function index() {
        parent::index();
    }

    public function aksi() {
        $this->data["blank"] = "";

        if ($_POST['upload']) {
            $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
            $nama = $_FILES['file']['name'];
            $x = explode('.', $nama);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['file']['size'];
            $file_tmp = $_FILES['file']['tmp_name'];

            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if ($ukuran < 1044070) {
                    move_uploaded_file($file_tmp, 'asset/img/logo/' . $nama);
                    $dashboard['logo'] = $nama;
                    $query = $this->dashboard->edit($dashboard, ['id' => 'BB1']);
                    if ($query) {
                        echo 'FILE BERHASIL DI UPLOAD';
                        header("Location: ../dashboard");
                    } else {
                        echo 'GAGAL MENGUPLOAD GAMBAR' . '<a href="../dashboard">kembali</a>';
                    }
                } else {
                    echo 'UKURAN FILE TERLALU BESAR' . '<a href="../dashboard"> kembali</a>';
                }
            } else {
                echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN' . '<a href="../dashboard"> kembali</a>';
            }
        }

        $dataPicture = $this->user->get(['email' => $_SESSION['email']])->picture;
        $this->data['showImage'] = "";
        $this->data['showImage'] .= "<img src=../asset/img/logo/" . $dataPicture . ">";
    }
} //End