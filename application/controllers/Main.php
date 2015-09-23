<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Ketampanan
 * Kelas yang berisi halaman utama dari web StarTrek
 */
class Main extends CI_Controller{
	
	public function index(){
		if(!$this->load->cek_sesi()) exit;
		
		$data['pageTitle'] = "Dashboard Administrator | StarTrel";
		$data['pageHeader'] = "Dashboard Administrator";
		$data['useTables'] = false;
		$this->load->template("dashboard", $data);
	}
	
	public function lihat_api($device = "ap"){
		if(!$this->load->cek_sesi()) exit;
		
		if(isset($_POST['submit'])){
			$data['pageTitle'] = "Lihat API | StarTrek";
			$data['pageHeader'] = "Lihat Access Point";
			if($this->form_validation->run() == FALSE){
				$this->load->template("lihat_api", $data);
			}else{
				$data['useTables'] = true;
				$this->load->model("api");
				$data['daftarDevice']["jatengjogja"] = $this->api->getDataAPI($device);
				$data['daftarDevice']["jogjapartnership"] = $this->api->getDataAPI($device);
					
				$this->load->template("lihat_api", $data);
			}
		}else{
			$data['pageTitle'] = "Lihat API | StarTrek";
			$data['pageHeader'] = "Lihat Access Point";
				
			$this->load->template("lihat_api", $data);
		}
	}
}