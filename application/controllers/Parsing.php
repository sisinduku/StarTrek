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
		$jumlah = array();
		for($i = 0; $i < 34; $i++)
			$jumlah[$i] = 0;
		echo "<table border=1>";
		foreach ($result as $row){
			$index = 0;
			echo "<tr>";
			foreach ($row as $key => $konten){
				echo "<td>". $konten. "</td>";
				if($jumlah[$index] < strlen($konten))
					$jumlah[$index] = strlen($konten); 
				$index++;
			}
			echo "<td>". $index. "</td>";
			echo "</tr>";
		}
		
		echo "<tr>";
		foreach ($jumlah as $data)
			echo "<td>". $data. "</td>";
		echo "</tr>";
		echo "<tr>";
		for ($i =1; $i <= 34; $i++)
			echo "<td>". $i. "</td>";
		echo "</tr>";
		echo "</table>";
		print_r(array_keys($result[0]));
	}
	
	public function parseUVAutelan() {
		$this->load->model("oracledb");
	
		$result = $this->oracledb->getAPUVAutelan();
		var_dump($result);
	}
}