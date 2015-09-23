<?php
class Api extends CI_Model {
	
	public function __construct() {
		// Call the CI_Model constructor
		parent::__construct ();
	}
	
	public function getDataAPI($device, $ip) {
		
		$username = "myApi";
		$password = "Fire.w0rK";
		$url = "https://$ip/webacs/j_spring_security_check";
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
					"msg" => $curl_error 
			);
		} else {
			// $msg = array("type"=>true, "code"=>0, "msg"=>"success");
			switch ($device) {
				case "ap" :
					$nexturl = "https://$ip/webacs/api/v1/data/AccessPoints?.full=true&.firstResult=0&.maxResults=1000";
					break;
				case "alarm" :
					$nexturl = "https://$ip/webacs/api/v1/data/Alarms?.full=true&.firstResult=0&.maxResults=999";
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
						"msg" => $curl_error 
				);
			} else {
				if (stripos ( $data, "xml" ) !== false) {
					$dataxml = simplexml_load_string ( $data );
					switch ($device) {
						case "ap" :
							$arr_dat ['title'] = $ip;
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
										$row->accessPointsDTO->controllerName = "DOWN";
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
							$arr_dat ['title'] = $ip;
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
	
	public function getDataList($device, $ip){
		$listData = $this->getDataAPI($device, $ip);
		$result = array();
		$index = 0;
		
		if ($listData["type"]){
			foreach ($listData["list_data"]["data"] as $data){
				$result[$index++] = $data;
			}
		}
		return $result;
	}
}