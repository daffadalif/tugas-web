<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getAllUsers(){
		$query = $this->db->get('tbl_users');
		return $query->result(); 
	}

	public function insert($user){
		$this->db->insert('tbl_users', $user);
		return $this->db->insert_id(); 
	}

	// public function getUser($id){
	// 	$query = $this->db->get_where('tbl_users',array('user_id'=>$id));
	// 	return $query->row_array();
	// }

	public function activate($data){
		$key = substr($data, 0,12);
		$email = substr($data, 12, (strlen($data) - 12));
		$sql = "SELECT * FROM tbl_users WHERE user_email = ? AND code = ?";
		$hsl = $this->db->query($sql, array($email, $key));

		if($hsl->num_rows() > 0){
			$sql1 = "UPDATE tbl_users SET active = 1 WHERE user_email = ?";
			$hsl1 = $this->db->query($sql1, array($email));
			return "berhasil";
		}else{
			return "gagal";
		}
	}

	public function base64_url_encode($input) {
 	return strtr(base64_encode($input), '+/=', '._-');
	}

	public function base64_url_decode($input) {
 	return base64_decode(strtr($input, '._-', '+/='));
	}

}
