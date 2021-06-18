<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_sql extends CI_Model{
	private $tabel="user";

	public function add($absensi){
		return $this->db->insert($this->tabel, $absensi);
	}

	public function gets(){
		$query=$this->db->get($this->tabel);
		return $query->result();
	}


} //End
