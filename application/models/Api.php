<?php
/**
 * @author Ketampanan
 * Kelas yang berisi abstraksi dari API
 */
class Api extends CI_Model {
	private $server, $searchBy, $searchQuery;
	
	public function __construct() {
		// Call the CI_Model constructor
		parent::__construct ();
	}
	
	/**
	 * Fungsi untuk mengambil data dari API
	 * @param string $device | Kode device : AP atau alarm
	 * @return $msg <multitype:boolean number string , multitype:boolean number unknown >
	 * 			Jika sukses menghasilkan array dengan elemen type, code, msg, list_data
	 * 			$msg['list_data']['data'] berisi object hasil parse dari XML
	 */
	// Notice: Ada tambahan parameter 'server'
	public function getDataAPI($device, $server) {
		$this->server = $server; //$this->input->post('server');
		$this->searchBy = $this->input->post('searchBy');
		$this->searchQuery = $this->input->post('seacrh');
		
		$username = "username";
		$password = "********";
		
		$url = "https://{$this->server}/webacs/j_spring_security_check";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 7 ); // timeout in seconds
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_COOKIEJAR, "cookies.txt" );
		curl_setopt ( $ch, CURLOPT_COOKIEFILE, "cookies.txt" );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, "j_username=$username&j_password=$password&submit=Submit+Query" );
		$data = curl_exec ( $ch );
		$curl_errno = curl_errno ( $ch );
		$curl_error = curl_error ( $ch );
		
		if ($curl_errno > 0) {
			$msg = array (
					"type" => false,
					"code" => $curl_errno,
					"msg" => "Auth error: ".$curl_error 
			);
		} else {
			switch ($device) {
				case "ap" :
					$nexturl = "https://{$this->server}/webacs/api/v1/data/AccessPoints?.full=true&.firstResult=0&.maxResults=1000&{$this->searchBy}=contains(\"{$this->searchQuery}\")";
					//$nexturl = "http://127.0.0.1/startrek/dummy.xml";
					break;
				case "alarm" :
					//Nanti dulu
					$nexturl = "https://{$this->server}/webacs/api/v1/data/Alarms?.full=true&.firstResult=0&.maxResults=999";
					break;
			}
			
			curl_setopt ( $ch, CURLOPT_URL, $nexturl );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 15 );
			$data = curl_exec ( $ch );
			$curl_errno = curl_errno ( $ch );
			$curl_error = curl_error ( $ch );
			if ($curl_errno > 0) {
				$msg = array (
						"type" => false,
						"code" => $curl_errno,
						"msg" => "Query error: ". $curl_error 
				);
			} else {
				if (stripos ( $data, "xml" ) !== false) {
					$dataxml = simplexml_load_string ( $data );
					switch ($device) {
						case "ap" :
							$arr_dat ['title'] = $this->server;
							$arr_dat ['data'] = array ();
							$i = 0;
							$down = 0;
							$stat = true;
							foreach ( $dataxml->children () as $row ) {
								if (empty ( $row->accessPointsDTO->ethernetMac )) {
									$stat = false;
									break;
								}
								
								$row->accessPointsDTO->background = "white";
								$row->accessPointsDTO->location = str_replace ( ";", "\n", $row->accessPointsDTO->location );
								if ($dataxml->children ()) {
									if (empty ( $row->accessPointsDTO->controllerName )) {
										// Kalo down dikasi nama down sama backgroundnya merah
										$row->accessPointsDTO->controllerName = "DOWN";
										$row->accessPointsDTO->controllerIpAddress = "-";
										$row->accessPointsDTO->background = "#c62828";
										$down ++;
									}
									
									$arr_dat ['data'] [$i] = $row->accessPointsDTO;
									$i ++;
								}
							}
							
							if ($stat) {
								$arr_dat ['down'] = $down;
								$msg = array (
										"type" => true,
										"code" => 0,
										"msg" => "Success",
										"server" => $server,
										"list_data" => $arr_dat 
								);
							} else {
								$msg = array (
										"type" => false,
										"code" => 211,
										"msg" => strip_tags ( $data ) 
								);
							}
							break;
						case "alarm" :
							$arr_dat ['title'] = $this->server;
							$arr_dat ['data'] = array ();
							$stat = true;
							foreach ( $dataxml->children () as $row ) {
								if (empty ( $row->alarmsDTO->deviceName )) {
									$stat = false;
									break;
								}
								
								$arr_dat ['data'] [] = $row->alarmsDTO;
							}
							
							if ($stat) {
								$msg = array (
										"type" => true,
										"code" => 0,
										"msg" => "Success",
										"list_data" => $arr_dat 
								);
							} else {
								$msg = array (
										"type" => false,
										"code" => 211,
										"msg" => strip_tags ( $data ) 
								);
							}
							break;
					}
				} else {
					$msg = array (
							"type" => false,
							"code" => 211,
							"msg" => $nexturl 
					);
				}
			}
		}
		curl_close ( $ch );
		return $msg;
	}
}