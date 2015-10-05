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
	 * Fungsi untuk mengambil data Autelan dari server dan menyimpannya kedalam DB lokal
	 *
	 * @return number
	 */
	public function parseDB() {
		// Memanggil DB Autelan
		$this->autelan = $this->load->database ( "autelan", TRUE );
		$index = 0;
		$data = array ();
		
		$query = $this->autelan->query ( "SELECT loc_id, ap_name, mac_address, ap_ip_address, location, status 
								FROM wifi_nms_ap_detail WHERE 
									p_contr_name = 'WAC-D4-GBL01' OR
									p_contr_name = 'WAC-D4-GBL02' OR
									p_contr_name = 'WAC-D4-GBL03' OR
									p_contr_name = 'WAC-D4-KBU01' OR
									p_contr_name = 'WAC-D4-KBU02' OR
									p_contr_name = 'WAC-D4-KBU03'
				" );
		
		if ($query->num_rows () > 0){
			$this->db->empty_table ( 'tbl_autelan' );
			
			foreach ( $query->result () as $row ) {
				if($row->LOC_ID == null)
					$row->LOC_ID = "Not Set";
				$temp = array (
						"id" => $index+1,
						"loc_id" => $row->LOC_ID,
						"ap_name" => $row->AP_NAME,
						"mac_address" => $row->MAC_ADDRESS,
						"ap_ip_address" => $row->AP_IP_ADDRESS,
						"location" => $row->LOCATION,
						"status" => $row->STATUS
				);
					
				// Memasukkan kedalam DB lokal
				$data [$index ++] = $temp;
			}
			$this->db->insert_batch ( 'tbl_autelan', $data );
			return $index;
		}
		else 
			return "Query Kosong";
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
		}
		
		$query = $this->db->get ( 'tbl_autelan' );
		$data ['data'] = array();
		$cntDown = 0;
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
	}
}