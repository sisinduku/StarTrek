<?php

class Apuv extends CI_Model {
	public function __construct() {
		// Call the CI_Model constructor
		parent::__construct ();
	}
	
	public function getUVAutelan() {
		$query = $this->db->get_where ( 'tbl_apunverif', array('jenis' => 'AUTELAN') );
		$data ['data'] = array();
		$index = 0;
		$cntDown = 0;
		if ($query->num_rows() > 0){
			foreach ( $query->result () as $row ) {
				$data ['data'][$index++] = $row;
			}
			$result = array (
					'list_data' => $data,
					'msg' => 'Success',
					'total' => $index
			);
			return $result;
		}else {
			$result = array (
					'msg' => 'Hasil Tidak Ditemukan karena tabel kosong. Mohon periksa Database Oracle'
			);
			return $result;
		}
		
	}
	
	public function getUVCisco() {
		$query = $this->db->get_where ( 'tbl_apunverif', array('jenis' => 'CISCO') );
		$data ['data'] = array();
		$index = 0;
		$cntDown = 0;
		if ($query->num_rows() > 0){
			foreach ( $query->result () as $row ) {
				$data ['data'][$index++] = $row;
			}
			$result = array (
					'list_data' => $data,
					'msg' => 'Success',
					'total' => $index
			);
			return $result;
		}else {
			$result = array (
					'msg' => 'Hasil Tidak Ditemukan karena tabel kosong. Mohon periksa Database Oracle'
			);
			return $result;
		}
	}
	
	public function getDivreAutelan() {
		$query = $this->db->get_where ( 'tbl_apdivre', array('tipe' => 'divreautelan') );
		$data ['data'] = array();
		$index = 0;
		$cntDown = 0;
		if ($query->num_rows() > 0){
			foreach ( $query->result () as $row ) {
				$data ['data'][$index++] = $row;
			}
			$result = array (
					'list_data' => $data,
					'msg' => 'Success',
					'total' => $index
			);
			return $result;
		}else {
			$result = array (
					'msg' => 'Hasil Tidak Ditemukan karena tabel kosong. Mohon periksa Database Oracle'
			);
			return $result;
		}
	}
	
	public function getDivreCisco() {
		$query = $this->db->get_where ( 'tbl_apdivre', array('tipe' => 'divrecisco') );
		$data ['data'] = array();
		$index = 0;
		$cntDown = 0;
		if ($query->num_rows() > 0){
			foreach ( $query->result () as $row ) {
				$data ['data'][$index++] = $row;
			}
			$result = array (
					'list_data' => $data,
					'msg' => 'Success',
					'total' => $index
			);
			return $result;
		}else {
			$result = array (
					'msg' => 'Hasil Tidak Ditemukan karena tabel kosong. Mohon periksa Database Oracle'
			);
			return $result;
		}
	}
}