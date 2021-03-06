<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author Nur Hardyanto
 * Controller Ajax khusus menangani request melalui AJAX, mengembalikan JSON
 */
class Ajax extends CI_Controller{
	private $strUnAuthorized = "Akses tidak diperbolehkan.";
	
	private function _generate_json_error($message) {
		return json_encode(array(
			"status" => "error",
			"message" => "Not authenticated."
		));
	}
	
	private function _check_session() {
		if(!$this->load->cek_sesi(false)) {
			echo $this->_generate_json_error($strUnAuthorized);
			return false;
		}
		return true;
	}
	public function index(){
		echo $this->_generate_json_error("Unrecognized action.");
	}
	
	
	public function cari($device = "ap", $outputType = "json") {
		if (!$this->_check_session()) exit;
		if($this->input->post('submit') != false){
			$jsonOutput = array();
			$this->load->model("api");
			$this->load->model("autelan");
			$serverArr = $this->input->post('server');
			if (!is_array($serverArr)) {
				echo $this->_generate_json_error("Invalid argument!");
				return;
			}
			// Kita iterasi / request server satu per satu...
			foreach ($serverArr as $idxServer => $itemServer) {
				if($idxServer == 2)
					$jsonOutput['s'.$idxServer] = $this->autelan->getDataAutelan();
				else
					$jsonOutput['s'.$idxServer] = $this->api->getDataAPI($device, $itemServer);
			}
			//$jsonOutput["jatengjogja"] = $this->api->getDataAPI($device);
			//$jsonOutput["jogjapartnership"] = $this->api->getDataAPI($device);
			
			if ($outputType == "json") {
				echo json_encode(array(
					'status' => 'ok',
					'data' => $jsonOutput
				));
			} else if ($outputType == "xlsx") {
				
			} else {
				echo $this->_generate_json_error("Unknown file type.");
			}
			
		} else {
			echo $this->_generate_json_error("Argument expected.");
		}
	}
}