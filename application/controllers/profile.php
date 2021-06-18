<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/core/saTemplate.php';
class Profile extends saTemplate {
    public function __construct() {
        parent::__construct(pathinfo(__FILE__, PATHINFO_FILENAME), 1);
    }

    public function index() {
        $this->data['linkImage'] = $this->user->get(['id' => $_SESSION['id']]);
        if (empty($this->data['linkImage']->picture)) {
            ($this->data['linkImage']->gender) ? $this->data['showImage'] = "asset/img/avatar3.png" : $this->data['showImage'] = "asset/img/avatar5.png";
        } else {
            $this->data['showImage'] = "file/" . $this->data['linkImage']->picture;
        }

        $this->data['roleprofile'] = $this->role->get(['id' => $this->data['linkImage']->role])->name;

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
                    move_uploaded_file($file_tmp, 'file/' . $nama);
                    $user['picture'] = $nama;
                    $query = $this->user->edit($user, ['id' => $_SESSION['id']]);
                    if ($query) {
                        echo 'FILE BERHASIL DI UPLOAD';
                        header("Location: ../profile");
                    } else {
                        echo 'GAGAL MENGUPLOAD GAMBAR' . '<a href="../profile">kembali</a>';
                    }
                } else {
                    echo 'UKURAN FILE TERLALU BESAR' . '<a href="../profile"> kembali</a>';
                }
            } else {
                echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN' . '<a href="../profile"> kembali</a>';
            }
        }

        $dataPicture = $this->user_sql->get(['email' => $_SESSION['email']])->picture;
        $this->data['showImage'] = "";
        $this->data['showImage'] .= "<img src=../file/" . $dataPicture . ">";
    }
} //End