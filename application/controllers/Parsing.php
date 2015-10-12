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
		$result = $this->oracledb->parseDBAutelan ();
		echo $result;
	}
	
	public function parsingOracle(){
		$this->load->model("oracledb");
		
		$result = $this->oracledb->getAP();
		echo $result;
	}
	public function parseUVCisco() {
		$this->load->model("oracledb");
		
		$result = $this->oracledb->getAPUVCisco();
		echo $result;
	}
	
	public function parseUVAutelan() {
		$this->load->model("oracledb");
	
		$result = $this->oracledb->getAPUVAutelan();
		echo $result;
	}
	
	public function parseDivreCisco(){
		$this->load->model("oracledb");
		
		$result = $this->oracledb->getgetDivreCisco();
		echo $result;
	}
	
	public function parseDivreAutelan(){
		$this->load->model("oracledb");
	
		$result = $this->oracledb->getDivreAutelan();
		echo $result;
	}
}