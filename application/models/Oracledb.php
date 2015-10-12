<?php
/**
 *
 * @author Ketampanan
 *         Kelas yang menangani parsing data ke server Oracle
 */
class Oracledb extends CI_Model {
	private $oracle;
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
		$result = 0;
		$this->db->empty_table ( 'tbl_apunverif' );
		$this->db->empty_table ( 'tbl_apdivre' );
		$this->db->query("ALTER TABLE tbl_apunverif AUTO_INCREMENT = 1");
		$this->db->query("ALTER TABLE tbl_apdivre AUTO_INCREMENT = 1");
		if($this->parseDBAutelan() != "kosong" && $this->getAPUVAutelan() != "kosong" && $this->getAPUVCisco() != "kosong" && $this->getDivreAutelan() != "kosong" && $this->getDivreCisco() != "kosong"){
			$result += $this->getAPUVAutelan();
			$result += $this->getAPUVCisco();
			$result += $this->parseDBAutelan();
			$result += $this->getDivreAutelan();
			$result += $this->getDivreCisco();
		}else{
			$result = "Query kosong";
		}
		return $result;
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
						"throughput" => $row->THROUGHPUT,
						"holding_time" => $row->HOLDING_TIME,
						"jumlah_user" => $row->JUMLAH_USER,
						"up_time" => $row->UP_TIME,
						"nsr" => $row->NSR,
						"propinsi" => $row->PROPINSI,
						"kota" => $row->KOTA,
						"user_auth" => $row->USER_AUTH,
						"user_asoc" => $row->USER_ASOC,
						"po" => $row->PO,
						"jml_client" => $row->JML_CLIENT,
						"regional" => $row->REGIONAL,
						"bsr" => $row->BSR,
						"onair_date" => $row->ONAIR_DATE,
						"divisio" => $row->DIVISIO,
						"onair_loc" => $row->ONAIR_LOC,
						"batch_p" => $row->BATCH_P,
						"segmen1" => $row->SEGMEN1,
						"segmen2" => $row->SEGMEN2,
						"jenis" => $row->JENIS,
						"under_verify" => $row->UNDER_VERIFY,
						"partnership" => $row->PARTNERSHIP,
						"nms_source" => $row->NMS_SOURCE,
						"contr_name" => $row->CONTR_NAME,
						"p_contr_name" => $row->P_CONTR_NAME,
						"tipe" => "uvcisco"
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
						(SELECT mac_address FROM wifi_nms_ap_master_otl WHERE status='Up')
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
						"throughput" => $row->THROUGHPUT,
						"holding_time" => $row->HOLDING_TIME,
						"jumlah_user" => $row->JUMLAH_USER,
						"up_time" => $row->UP_TIME,
						"nsr" => $row->NSR,
						"propinsi" => $row->PROPINSI,
						"kota" => $row->KOTA,
						"user_auth" => $row->USER_AUTH,
						"user_asoc" => $row->USER_ASOC,
						"po" => $row->PO,
						"jml_client" => $row->JML_CLIENT,
						"regional" => $row->REGIONAL,
						"bsr" => $row->BSR,
						"onair_date" => $row->ONAIR_DATE,
						"divisio" => $row->DIVISIO,
						"onair_loc" => $row->ONAIR_LOC,
						"batch_p" => $row->BATCH_P,
						"segmen1" => $row->SEGMEN1,
						"segmen2" => $row->SEGMEN2,
						"jenis" => $row->JENIS,
						"under_verify" => $row->UNDER_VERIFY,
						"partnership" => $row->PARTNERSHIP,
						"nms_source" => $row->NMS_SOURCE,
						"contr_name" => $row->CONTR_NAME,
						"p_contr_name" => $row->P_CONTR_NAME,
						"tipe" => "uvautelan"
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
		
		$query = $this->oracle->query("select loc_id, ap_name,location,mac_address,ap_ip_address,SN,status,nms_source 
					from wifi_nms_ap_detail where (nms_source='NMS_JTN06' or nms_source='NMS_YGY11') and status='Up' and witel='WITEL'"
		);
		$result = array();
		$index = 0;
		if($query->num_rows() > 0){
			foreach ($query->result () as $row){
				if($row->LOC_ID == null)
					$row->LOC_ID = "Not Set";
				$temp = array(
						"loc_id" => $row->LOC_ID,
						"ap_name" => $row->AP_NAME,
						"location" => $row->LOCATION,
						"mac_address" => $row->MAC_ADDRESS,
						"ap_ip_address" => $row->AP_IP_ADDRESS,
						"sn" => $row->SN,
						"status" => $row->STATUS,
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
	
		$query = $this->oracle->query("select loc_id, ap_name,location,mac_address,ap_ip_address,SN,status,nms_source 
					from wifi_nms_ap_detail where 
					(p_contr_name='WAC-D4-GBL01' or
					p_contr_name='WAC-D4-GBL02' or
					p_contr_name='WAC-D4-GBL03' or
					p_contr_name='WAC-D4-KBU01' or
					p_contr_name='WAC-D4-KBU03' or
					p_contr_name='WAC-D4-KBU02') and status='Up' and witel='WITEL'"
		);
		$result = array();
		$index = 0;
		if($query->num_rows() > 0){
			foreach ($query->result () as $row){
				if($row->LOC_ID == null)
					$row->LOC_ID = "Not Set";
				$temp = array(
						"loc_id" => $row->LOC_ID,
						"ap_name" => $row->AP_NAME,
						"location" => $row->LOCATION,
						"mac_address" => $row->MAC_ADDRESS,
						"ap_ip_address" => $row->AP_IP_ADDRESS,
						"sn" => $row->SN,
						"status" => $row->STATUS,
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
}