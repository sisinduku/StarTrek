<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 *
 * @author Ketampanan
 *         Kelas yang berisi halaman utama dari web StarTrek
 */
class Main extends CI_Controller {
	public function index() {
		if (! $this->load->cek_sesi ())
			exit ();
		
		$data ['pageTitle'] = "Dashboard Administrator | StarTrek";
		$data ['pageHeader'] = "Dashboard Administrator";
		$data ['useTables'] = false;
		$this->load->template ( "dashboard", $data );
	}
	public function lihat_api($device = "ap") {
		if (! $this->load->cek_sesi ())
			exit ();
		$data ['useTables'] = true;
		
		if ($this->input->post ( 'submit' ) != false) {
			
			$data ['pageTitle'] = "Lihat API | StarTrek";
			$data ['pageHeader'] = "Lihat Access Point";
			// if($this->form_validation->run() == FALSE){
			// $this->load->template("lihat_api", $data);
			// }else{
			// $this->load->model("api");
			// $data['daftarDevice']["jatengjogja"] = $this->api->getDataAPI($device);
			// $data['daftarDevice']["jogjapartnership"] = $this->api->getDataAPI($device);
			
			$this->load->template ( "lihat_api", $data );
			// }
		} else {
			$data ['pageTitle'] = "Lihat API | StarTrek";
			$data ['pageHeader'] = "Lihat Access Point";
			
			$this->load->template ( "lihat_api", $data );
		}
	}
	
	public function ap_unverified($param = "") {
		if (! $this->load->cek_sesi ())
			exit ();
		$data ['useTables'] = true;		
		
		if ($param == "uv"){
			$this->load->model('apuv');
			$exportType = $this->input->get('type');
			
			$data['apDataAutelan'] = $this->apuv->getUVAutelan();
			$data['apDataCisco'] = $this->apuv->getUVCisco();
			$data ['pageTitle'] = "Lihat AP UV | StarTrek";
			$data ['pageHeader'] = "Lihat Access Point UV";
			
			if ($exportType == "xlsx") {
				$this->load->helper('export_xlsx_unverified');
				$serverName = $this->input->get('server');
				if ($serverName == "autelan") {
					do_export_xlsx_uv($data['apDataAutelan'], "uv", "Autelan");
				} else if ($serverName == "cisco") {
					do_export_xlsx_uv($data['apDataCisco'], "uv", "Cisco");
				} else {
					die("Unknown server name.");
					return;
				}
				
			} else {
				$this->load->template ( "datatable_unverified_ap_uv", $data );
			}
				
			
		} else if ($param == "divre0"){
			$this->load->model('apuv');
			$exportType = $this->input->get('type');
			
			$data['apDataAutelan'] = $this->apuv->getDivreAutelan();
			$data['apDataCisco'] = $this->apuv->getDivreCisco();
			$data ['pageTitle'] = "Lihat AP Divre0 | StarTrek";
			$data ['pageHeader'] = "Lihat Access Point Divre0";
			if ($exportType == "xlsx") {
				$this->load->helper('export_xlsx_unverified');
				$serverName = $this->input->get('server');
				if ($serverName == "autelan") {
					do_export_xlsx_uv($data['apDataAutelan'], "divre0", "Autelan");
				} else if ($serverName == "cisco") {
					do_export_xlsx_uv($data['apDataCisco'], "divre0", "Cisco");
				} else {
					die("Unknown server name.");
					return;
				}
			} else {
				$this->load->template ( "datatable_unverified_ap_divre0", $data );
			}
		} else {
			die("Unknown parameter!");
			return;
		}
	}
	
	/**
	 * Fungsi untuk ekspor hasil pencarian ke Ms. Excel
	 * @param string $device Device
	 * @param string $outputType Tipe output
	 */
	public function ekspor($device = "ap", $outputType = "xlsx") {
		if(!$this->load->cek_sesi()) exit;
		
		if($this->input->post('submit') != false){
			$jsonOutput	= null;
			$serverId	= $this->input->post('server_id');
			$serverAddr	= $this->input->post('server_addr');
			$searchField = $this->input->post ( 'searchBy' );
			$searchQuery = $this->input->post ( 'search' );
			
			if (!is_numeric($serverId) || empty($serverAddr)) {
				die("Invalid argument!");
				return;
			} else if (empty($searchField) || empty($searchQuery)) {
				die("Argument expected.");
				return;
			}
			
			// Check server ID
			if($serverId == 2) {
				$this->load->model("autelan");
				$jsonOutput = $this->autelan->getDataAutelan();
			} else {
				$this->load->model("api");
				$jsonOutput = $this->api->getDataAPI($device, $serverAddr);
			}
			
			if ($outputType == "xlsx") {
				$this->load->helper('export_xlsx');
				// Server ID 2 adalah autelan
				if ($serverId == 2) {
					do_autelan_export_xlsx($jsonOutput, $serverId, $serverAddr, $searchField, $searchQuery);
				} else {
					do_export_xlsx($jsonOutput, $serverId, $serverAddr, $searchField, $searchQuery);
				}
				
			} else {
				die("Invalid output type!");
			}
			
		} else {
			die("Argument expected.");
		}
	}
}