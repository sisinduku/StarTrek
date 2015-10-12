<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 *
 * @author Ketampanan
 *         Kelas yang berisi halaman utama dari web StarTrek
 */
class Parsing extends CI_Controller {
	
	public function parseAutelan() {
		$this->load->model ( "oracledb" );
		$result = $this->oracledb->parseDB ();
		echo $result;
	}
	
	public function parseUVCisco() {
		$this->load->model("oracledb");
		
		$result = $this->oracledb->getAPUVCisco();
		var_dump($result);
	}
	
	public function parseUVAutelan() {
		$this->load->model("oracledb");
	
		$result = $this->oracledb->getAPUVAutelan();
		var_dump($result);
	}
}