<?php
/**
 *
 * @author Ketampanan
 *         Kelas yang menangani parsing data ke server Oracle
 */
class Oracledb extends CI_Model {
	private $oracle;
	// array untuk mapping dari ip ke witel
	private $mapingWitel = array('10.9.0' => 'SEMARANG', '10.9.1' => 'SEMARANG', '10.9.2' => 'SEMARANG',
			'10.9.3' => 'SEMARANG', '10.9.4' => 'SEMARANG', '10.9.5' => 'SEMARANG', '10.9.6' => 'SEMARANG',
			'10.9.15' => 'SEMARANG', '10.9.15' => 'PEKALONGAN', '10.9.17' => 'PEKALONGAN', '10.9.19' => 'PEKALONGAN',
			'10.9.20' => 'PEKALONGAN', '10.9.26' => 'KUDUS', '10.9.30' => 'SEMARANG', '10.9.31' => 'SEMARANG',
			'10.9.32' => 'SEMARANG', '10.9.33' => 'SEMARANG', '10.9.34' => 'SEMARANG', '10.9.36' => 'SEMARANG',
			'10.9.37' => 'SEMARANG', '10.9.39' => 'SEMARANG', '10.9.40' => 'MAGELANG', '10.9.55' => 'SEMARANG',
			'10.9.64'=> 'SEMARANG', '10.9.65' => 'SEMARANG', '10.9.7' => 'YOGYAKARTA', '10.9.8' => 'MAGELANG',
			'10.9.9' => 'MAGELANG', '10.9.10' => 'YOGYAKARTA', '10.9.11' => 'YOGYAKARTA', '10.9.12' => 'YOGYAKARTA',
			'10.9.13' => 'PURWOKERTO', '10.9.14' => 'PURWOKERTO', '10.9.16' => 'YOGYAKARTA', '10.9.18' => 'YOGYAKARTA',
			'10.9.21' => 'SOLO', '10.9.22' => 'SOLO', '10.9.23' => 'SOLO', '10.9.24' => 'SOLO', '10.9.25' => 'SOLO',
			'10.9.29' => 'YOGYAKARTA', '10.9.35' => 'YOGYAKARTA', '10.9.38' => 'YOGYAKARTA', '10.9.41' => 'YOGYAKARTA',
			'10.9.42' => 'YOGYAKARTA', '10.9.43' => 'YOGYAKARTA', '10.9.44' => 'YOGYAKARTA', '10.9.45' => 'YOGYAKARTA',
			'10.9.46' => 'YOGYAKARTA', '10.9.48' => 'YOGYAKARTA', '10.9.49' => 'YOGYAKARTA', '10.9.56' => 'SOLO',
			'10.9.57' => 'MAGELANG', '10.9.58' => 'SOLO', '10.9.59' => 'YOGYAKARTA', '10.9.60' => 'SOLO',
			'10.9.61' => 'SOLO', '10.9.62' => 'SOLO', '10.9.74' => 'MAGELANG', '10.9.99' => 'YOGYAKARTA',
			'10.3.0' => 'SEMARANG', '10.3.1' => 'SEMARANG', '10.3.3' => 'SEMARANG', '10.3.4' => 'SEMARANG', 
			'10.3.20' => 'KUDUS', '10.3.21' => 'KUDUS', '10.3.22' => 'KUDUS', '10.4.10' => 'SOLO', '10.4.11' => 'SOLO',
			'10.4.12' => 'SOLO', '10.4.13' => 'SOLO', '10.4.14' => 'SOLO', '10.4.15' => 'SOLO', '10.4.30' => 'PURWOKERTO', 
			'10.4.32' => 'PURWOKERTO', '10.4.20' => 'MAGELANG', '10.4.21' => 'MAGELANG', '10.4.22' => 'MAGELANG',
			'10.4.40' => 'YOGYAKARTA', '10.4.41' => 'YOGYAKARTA', '10.4.42' => 'YOGYAKARTA', '10.4.44' => 'YOGYAKARTA', 
			'10.4.46' => 'YOGYAKARTA', '10.15.50' => 'KUDUS', '10.15.51' => 'KUDUS', '10.15.52' => 'KUDUS', 
			'10.15.53' => 'KUDUS', '10.15.71' => 'KUDUS', '10.15.10' => 'KUDUS', '10.15.11' => 'KUDUS', 
			'10.15.12' => 'KUDUS', '10.15.13' => 'KUDUS', '10.15.14' => 'KUDUS', '10.17.54' => 'SOLO', 
			'10.17.55' => 'SOLO', '10.17.56' => 'SOLO', '10.17.57' => 'SOLO', '10.17.19' => 'SOLO', '10.17.20' => 'SOLO',
			'10.17.21' => 'SOLO', '10.17.22' => 'SOLO', '10.15.23' => 'PURWOKERTO', '10.15.24' => 'PURWOKERTO', 
			'10.15.25' => 'PURWOKERTO', '10.15.26' => 'PURWOKERTO', '10.15.27' => 'PURWOKERTO', '10.15.28' => 'PURWOKERTO',
			'10.15.15' => 'PURWOKERTO', '10.15.16' => 'PURWOKERTO', '10.15.17' => 'PURWOKERTO', '10.15.18' => 'PURWOKERTO',
			'10.16.29' => 'PEKALONGAN', '10.16.30' => 'PEKALONGAN', '10.16.31' => 'PEKALONGAN', '10.16.32' => 'PEKALONGAN', 
			'10.16.33' => 'PEKALONGAN', '10.16.34' => 'PEKALONGAN', '10.16.35' => 'PEKALONGAN', '10.16.36' => 'PEKALONGAN',
			'0.0.0' => 'Not Set'
	);
	
	public function __construct() {
		// Call the CI_Model constructor
		parent::__construct ();
	}
	
	/**
	 * Fungsi untuk mengambil data Autelan dari server dan menyimpannya kedalam DB lokal
	 *
	 * @return number
	 */
	public function parseDBAutelan() {
		// Memanggil DB Autelan
		$this->oracle = $this->load->database ( "oracle", TRUE );
		$index = 0;
		$data = array ();
	
		$query = $this->oracle->query ( "SELECT loc_id, ap_name, mac_address, ap_ip_address, location, status
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
		else{
			$this->db->empty_table ( 'tbl_autelan' );
			return "kosong";
		}
			
	}
	
	public function getAP(){
		$result = array();
		$this->db->empty_table ( 'tbl_apunverif' );
		$this->db->empty_table ( 'tbl_apdivre' );
		$this->db->query("ALTER TABLE tbl_apunverif AUTO_INCREMENT = 1");
		$this->db->query("ALTER TABLE tbl_apdivre AUTO_INCREMENT = 1");
		$result[0] = $this->getAPUVAutelan();
		$result[1] = $this->getAPUVCisco();
		$result[2] = $this->parseDBAutelan();
		$result[3] = $this->getDivreAutelan();
		$result[4] = $this->getDivreCisco();
		if(is_numeric($result[0]) && is_numeric($result[1]) && is_numeric($result[3]) && is_numeric($result[4])){
			$result[0] += $result[1] + $result[2] + $result[3] + $result[4];
		}else{
			$result[0] = "Query kosong";
		}
		return $result[0];
	}
	
	public function getAPUVCisco() {
		$this->oracle = $this->load->database ( "oracle", TRUE );
		
		$query = $this->oracle->query ( "SELECT b.witel,a.* FROM wifi_nms_ap_detail a, wifi_site_predefined b
					WHERE a.status='Up' AND b.periode in (SELECT max(periode) FROM wifi_site_predefined) 
						AND a.loc_id=b.loc_id AND a.under_verify=1 AND b.divre='DIVRE IV' AND a.mac_address in
						(SELECT mac_address FROM wifi_nms_ap_master WHERE controler_name not like 'Not%')
					order by 1" 
				);
		
		$result = array();
		$index = 0;
	if($query->num_rows() > 0){
			foreach ($query->result () as $row){
				if($row->JUMLAH_USER == null)
					$row->JUMLAH_USER = "Not Set";
				if($row->UP_TIME == null)
					$row->UP_TIME = "Not Set";
				if($row->NSR == null)
					$row->NSR = "Not Set";
				if($row->BATCH_P == null)
					$row->BATCH_P = "Not Set";
				if($row->PARTNERSHIP == null)
					$row->PARTNERSHIP = "Not Set";
					
				$temp = array (
						"witel" => $row->WITEL,
						"loc_id" => $row->LOC_ID,
						"ap_name" => $row->AP_NAME,
						"mac_address" => $row->MAC_ADDRESS,
						"ap_ip_address" => $row->AP_IP_ADDRESS,
						"sn" => $row->SN,
						"location" => $row->LOCATION,
						"status" => $row->STATUS,
						"jenis" => $row->JENIS,
						"nms_source" => $row->NMS_SOURCE,
						"p_or_contr_name" => $row->CONTR_NAME
				);
				// Memasukkan kedalam DB lokal
				$data [$index ++] = $temp;
			}
			$this->db->insert_batch ( 'tbl_apunverif', $data );
			return $index;
		}else{
			return "kosong";
		}
		
	}
	
	public function getAPUVAutelan() {
		$this->oracle = $this->load->database("oracle", TRUE);
		
		$query = $this->oracle->query("SELECT b.witel,a.* FROM wifi_nms_ap_detail a, wifi_site_predefined b
					WHERE b.periode in (SELECT max(periode) FROM wifi_site_predefined) AND a.loc_id=b.loc_id AND 
						a.under_verify=1 AND b.divre='DIVRE IV' AND a.mac_address in
						(SELECT mac_address FROM wifi_nms_ap_master_otl WHERE status='Up') AND a.status='Up' 
					order by 1"
				);
		$result = array();
		$index = 0;
		if($query->num_rows() > 0){
			foreach ($query->result () as $row){
				if($row->JUMLAH_USER == null)
					$row->JUMLAH_USER = "Not Set";
				if($row->UP_TIME == null)
					$row->UP_TIME = "Not Set";
				if($row->NSR == null)
					$row->NSR = "Not Set";
				if($row->BATCH_P == null)
					$row->BATCH_P = "Not Set";
				if($row->PARTNERSHIP == null)
					$row->PARTNERSHIP = "Not Set";
					
				$temp = array (
						"witel" => $row->WITEL,
						"loc_id" => $row->LOC_ID,
						"ap_name" => $row->AP_NAME,
						"mac_address" => $row->MAC_ADDRESS,
						"ap_ip_address" => $row->AP_IP_ADDRESS,
						"sn" => $row->SN,
						"location" => $row->LOCATION,
						"status" => $row->STATUS,
						"jenis" => $row->JENIS,
						"nms_source" => $row->NMS_SOURCE,
						"p_or_contr_name" => $row->P_CONTR_NAME
				);
				// Memasukkan kedalam DB lokal
				$data [$index ++] = $temp;
			}
			$this->db->insert_batch ( 'tbl_apunverif', $data );
			return $index;
		}else{
			return "kosong";
		}
	}
	
	public function getDivreCisco() {
		$this->oracle = $this->load->database("oracle", TRUE);
		
		$query = $this->oracle->query("SELECT loc_id, ap_name,location,mac_address,ap_ip_address,SN,status,contr_name,nms_source FROM wifi_nms_ap_detail 
					WHERE (nms_source='NMS_JTN06' or nms_source='NMS_YGY11') AND witel='WITEL' AND ap_name not like 'DIS%' 
					AND ap_name not like 'RSK%' AND ap_name not like 'HLG%' order by 1"
		);
		
		$result = array();
		$ip = array();
		$index = 0;
		if($query->num_rows() > 0){
			foreach ($query->result () as $row){
				if($row->LOC_ID == null)
					$row->LOC_ID = "Not Set";
				// Mapping ip ke witel
				$ip = explode(".", $row->AP_IP_ADDRESS);
				$vlan = $ip[0].".";
				$vlan .= $ip[1].".";
				$vlan .= $ip[2];
				if(array_key_exists($vlan, $this->mapingWitel))
					$witel = $this->mapingWitel[$vlan];
				else 
					$witel = 'Not Set';
				$temp = array(
						"loc_id" => $row->LOC_ID,
						"ap_name" => $row->AP_NAME,
						"location" => $row->LOCATION,
						"mac_address" => $row->MAC_ADDRESS,
						"ap_ip_address" => $row->AP_IP_ADDRESS,
						"witel" => $witel,
						"sn" => $row->SN,
						"status" => $row->STATUS,
						"p_or_contr_name" => $row->CONTR_NAME,
						"nms_source" => $row->NMS_SOURCE,
						"tipe" => "divrecisco"
				);
				$data [$index ++] = $temp;
			}
			$this->db->insert_batch ( 'tbl_apdivre', $data );
			return $index;
		}else{
			return "kosong";
		}
	}
	
	public function getDivreAutelan() {
		$this->oracle = $this->load->database("oracle", TRUE);
	
		$query = $this->oracle->query("select loc_id, ap_name,location,mac_address,ap_ip_address,SN,status,p_contr_name,nms_source FROM wifi_nms_ap_detail 
				WHERE (p_contr_name='WAC-D4-GBL01' OR p_contr_name='WAC-D4-GBL02' OR p_contr_name='WAC-D4-GBL03' OR
				p_contr_name='WAC-D4-KBU01' OR p_contr_name='WAC-D4-KBU03' OR p_contr_name='WAC-D4-KBU02') 
				AND witel='WITEL' AND ap_name not like 'DIS%' AND ap_name not like 'RSK%' AND ap_name not like 'HLG%'"
		);
		$result = array();
		$ip = array();
		$index = 0;
		if($query->num_rows() > 0){
			foreach ($query->result () as $row){
				if($row->LOC_ID == null)
					$row->LOC_ID = "Not Set";
				// Mapping ip ke witel
				$ip = explode(".", $row->AP_IP_ADDRESS);
				$vlan = $ip[0].".";
				$vlan .= $ip[1].".";
				$vlan .= $ip[2];
				$witel = $this->mapingWitel[$vlan];
				$temp = array(
						"loc_id" => $row->LOC_ID,
						"ap_name" => $row->AP_NAME,
						"location" => $row->LOCATION,
						"mac_address" => $row->MAC_ADDRESS,
						"ap_ip_address" => $row->AP_IP_ADDRESS,
						"witel" => $witel,
						"sn" => $row->SN,
						"status" => $row->STATUS,
						"p_or_contr_name" => $row->P_CONTR_NAME,
						"nms_source" => $row->NMS_SOURCE,
						"tipe" => "divreautelan"
				);
				$data [$index ++] = $temp;
			}
			$this->db->insert_batch ( 'tbl_apdivre', $data );
			return $index;
		}else{
			return "kosong";
		}
	}
}