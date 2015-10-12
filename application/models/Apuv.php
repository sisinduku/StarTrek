<?php

class Apuv extends CI_Model {
	public function __construct() {
		// Call the CI_Model constructor
		parent::__construct ();
	}
	
	public function getUVAutelan() {
		$query = $this->db->get ( 'tbl_uvautelan' );
		$data ['data'] = array();
		$index = 0;
		$cntDown = 0;
		if ($query->num_rows() > 0){
			// Pengulangan sekaligus hitung yang 'down'
			foreach ( $query->result () as $row ) {
				$data ['data'][$index++] = $row;
				if (strtolower($row->status) == "down") {
					// Perlu dikasi property background?
					// $data ['data'][$index]['background'] = "#c62828";
					$cntDown++;
				}
			}
			$data['down'] = $cntDown;
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