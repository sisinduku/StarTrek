<?php
/**
 * @author Ketampanan
 * Kelas yang berisi abstraksi dari server Autelan
 */
class Autelan extends CI_Model {
	private $autelan, $searchBy, $searchQuery;
	public function __construct() {
		// Call the CI_Model constructor
		parent::__construct ();
	}
	
	/**
	 * Fungsi untuk mengambil data Autelan pada tbl_autelan
	 *
	 * @return multitype:string unknown
	 */
	public function getDataAutelan() {
		$this->searchBy = $this->input->post ( 'searchBy' );
		$this->searchQuery = $this->input->post ( 'search' );
		$index = 0;
		
		if ($this->searchBy != "serialNumber" && $this->searchBy != "macAddress") {
			$searchCategory = array (
					'name' => 'ap_name',
					'location' => 'location',
					'ethernetMac' => 'mac_address' 
			);
			$this->db->like ( $searchCategory [$this->searchBy], $this->searchQuery );
			$query = $this->db->get ( 'tbl_autelan' );
			$data ['data'] = array();
			$cntDown = 0;
			if ($query->num_rows() > 0){
				// Pengulangan sekaligus hitung yang 'down'
				foreach ( $query->result () as $row ) {
					$data ['data'][$index] = $row;
					if (strtolower($row->status) == "down") {
						// Perlu dikasi property background?
						// $data ['data'][$index]['background'] = "#c62828";
						$cntDown++;
					}
					$index++;
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
		}else{
			$result = array (
					'msg' => 'Hasil Tidak Ditemukan. Silahkan Perbaiki Kata Kunci.'
			);
			return $result;
		}

		$data['down'] = $cntDown;
		$data['total'] = $index;
		$result = array (
				'list_data' => $data,
				'msg' => 'Success',
				'total' => $index,
				"field" => $this->searchBy,
				"query" => $this->searchQuery
		);
		return $result;
	}
}