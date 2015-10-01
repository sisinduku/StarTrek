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
	 * @return number
	 */
	public function parseDB() {
		//Memanggil DB Autelan
		$this->autelan = $this->load->database ( "autelan", TRUE );
		$count = 0;
		
		$this->autelan->select ( "loc_id, ap_name, mac_address, ap_ip_address, location, status" );
		$this->autelan->or_where(array(
				'p_contr_name' => 'WAC-D4-GBL01',
				'p_contr_name' => 'WAC-D4-GBL02',
				'p_contr_name' => 'WAC-D4-GBL03',
				'p_contr_name' => 'WAC-D4-KBU01',
				'p_contr_name' => 'WAC-D4-KBU02',
				'p_contr_name' => 'WAC-D4-KBU03',
		));
		$query = $this->autelan->get ( "nms_wifi_ap_detail" );
		
		foreach ( $query->result () as $row ) {
			$data = array (
					"loc_id" => $row->loc_id,
					"ap_name" => $row->ap_name,
					"mac_address" => $row->mac_address,
					"ap_ip_address" => $row->ap_ip_address,
					"location" => $row->location,
					"status" => $row->status 
			);
			
			//Memasukkan kedalam DB lokal
			$this->db->insert ( 'tbl_autelan', $data );
			$count += $this->db->affected_rows();
		}
		return $count;
	}
	/**
	 * Fungsi untuk mengambil data Autelan pada tbl_autelan
	 * @return multitype:string unknown 
	 */
	public function getDataAutelan(){
		$this->searchBy = $this->input->post('searchBy');
		$this->searchQuery = $this->input->post('search');
		$searchCategory = array(
				'name' => 'ap_name',
				'location' => 'location',
				'ethernetMac' => 'mac_address',
				'serialNumber' => '',
				'macAddress' => ''
		);
		$index = 0;
		$this->db->like($searchCategory[$this->searchBy], $this->searchQuery);
		$query = $this->db->get('tbl_autelan');
		
		foreach ($query->result() as $row){
			$data[$index++] = $row;
		}
		$result = array(
			'list_data' => $data,
			'msg' => 'Success'
		);
		return $result;
	}
	
}