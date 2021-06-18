<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function index()
	{
		$this->data['password_info'] = "";
		if (isset($_SESSION['error'])) {
			$this->data['password_info'] .= "<div class='alert alert-danger alert-dismissible'>";
			$this->data['password_info'] .= "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
			$this->data['password_info'] .= "<h5>Alert!</h5>";
			$this->data['password_info'] .= "Username atau password yang Anda masukkan salah.";
			$this->data['password_info'] .= "</div>";
			session_destroy();
		}
		$this->load->view('login', $this->data);
	}

	public function login_validation()
	{
		$email = $this->input->post('id');
		$password 	= $this->input->post('pass');
		$error = 'error';
		$cekLogin = $this->user->doLogin($email, $password);
		if (!empty($cekLogin)) {
			$this->user->edit(['is_active' => 1], ['id' => $this->input->post('id')]);
			header("Location: ../dashboard");
		} else {
			$this->session->set_userdata('error', $error);
			header("Location: ../login");
		}
	}
}
