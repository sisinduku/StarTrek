<?php

class Apuv extends CI_Model {
	public function __construct() {
		// Call the CI_Model constructor
		parent::__construct ();
	}
	
	public function getUVAutelan() {
		$query = $this->db->get_where ( 'tbl_apunverif', array('jenis' => 'AUTELAN') );
		$fieldArray = $query->list_fields();
		
		$data ['data'] = array();
		$data ['fields'] = array();
		$cntDown = 0;
		if ($query->num_rows() > 0){
			$index = 0;
			foreach ( $fieldArray as $field ) {
				if($field == 'p_or_contr_name')
					$field = 'p_contr_name';
				$data ['fields'][$index++] = $field;
			}
			$index = 0;
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
		$fieldArray = $query->list_fields();
		
		$data ['data'] = array();
		$data ['fields'] = array();
		
		$cntDown = 0;
		if ($query->num_rows() > 0){
			$index = 0;
			foreach ( $fieldArray as $field ) {
				if($field == 'p_or_contr_name')
					$field = 'contr_name';
				$data ['fields'][$index++] = $field;
			}
			$index = 0;
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
		$fieldArray = $query->list_fields();
		
		$data ['data'] = array();
		$data ['fields'] = array();
		
		$cntDown = 0;
		if ($query->num_rows() > 0){
			$index = 0;
			foreach ( $fieldArray as $field ) {
				if($field == 'p_or_contr_name')
					$field = 'p_contr_name';
				$data ['fields'][$index++] = $field;
			}
			$index = 0;
			foreach ( $query->result () as $row ) {
				$data ['data'][$index++] = $row;
				if (strtolower($row->status) == "down") {
					$cntDown++;
				}
			}
			$result = array (
					'list_data' => $data,
					'msg' => 'Success',
					'total' => $index,
					'down' => $cntDown
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
		$fieldArray = $query->list_fields();
		
		$data ['data'] = array();
		$data ['fields'] = array();
		
		$cntDown = 0;
		if ($query->num_rows() > 0){
			$index = 0;
			foreach ( $fieldArray as $field ) {
				if($field == 'p_or_contr_name')
					$field = 'contr_name';
				$data ['fields'][$index++] = $field;
			}
			$index = 0;
			$cntDown = 0;
			foreach ( $query->result () as $row ) {
				$data ['data'][$index++] = $row;
				if (strtolower($row->status) == "down") {
					$cntDown++;
				}
			}
			
			$result = array (
					'list_data' => $data,
					'msg' => 'Success',
					'total' => $index,
					'down' => $cntDown
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