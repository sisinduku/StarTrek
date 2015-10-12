<?php
function do_export_xlsx($JSONResult, $serverId, $serverAddr, $queryField, $queryText) {
	$CI =& get_instance();
	
	// load the excel library
	$CI->load->library('excel');
	
	define('IDX_COL_HOME', 2);	// Kolom dimulai pada kolom ke 3 (index 2)
	define('IDX_ROW_START', 1); // Dimulai dari baris 1
	define('TABLE_COLS', 11);	// Tabel ada 8 kolom
	
	$jmlHasil	= intval($JSONResult['list_data']['total']);
	$jmlDown	= intval($JSONResult['list_data']['down']);
	$exportFileName = "hasil-pencarian.xlsx";
	$columnWidths = array(
			2,	// [A] Padding
			2,	// [B] Padding
			35,	// [C] Kolom AP Name
			50,	// [D] Kolom Lokasi
			11,	// [E] Kolom IP Address
			18,	// [F] Kolom MAC Address | Eth
			18, // [G] Kolom MAC Address | Radio
			18,	// [H] Kolom Controller | Name
			18,	// [I] Kolom Controller | IP
			15,	// [J] Kolom SN
			10, // [K] Kolom Type
			8, // [L] Kolom Client Count | 2,4Ghz
			8	// [M] Kolom Client Count | 5GHz
	);
	$styleHeader = array(
			'alignment' => array(
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'font'  => array(
					'bold'  => true
			)
	);
	$styleGrayBg = array(
			'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'EEEEEE')
			)
	);
	$styleBorderAll = array(
			'borders' => array(
					'allborders'	=> array(
							'style'		=> PHPExcel_Style_Border::BORDER_THIN
					)
			)
	);
	$styleAlignCenterTop = array(
			'alignment' => array(
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_TOP,
					'wrap'			=> true
			),
	);
	$styleAPDown = array(
			'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F9BBBC')
			)
	);
	
	// Generate excel....
	try {
		$objPHPExcel = new PHPExcel();
		$worksheetReport = $objPHPExcel->getActiveSheet();
		$worksheetReport->setTitle('Server '.$serverId." (".$serverAddr.")");
		
		// Set default alignment ke kiri atas...
		$objPHPExcel->getDefaultStyle()
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
			->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
		// Set up kolom -----------------------------------
		foreach ($columnWidths as $colIdx => $colWidth) {
			$worksheetReport->getColumnDimensionByColumn($colIdx)->setWidth($colWidth);
		}
		
		// Judul worksheet pada bagian atas
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, IDX_ROW_START,
				IDX_COL_HOME+TABLE_COLS-1, IDX_ROW_START+1)
				->setCellValueByColumnAndRow(IDX_COL_HOME, IDX_ROW_START, "Hasil Pencarian");
		
		$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME, IDX_ROW_START)
			->applyFromArray($styleHeader); // Set style
		$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME, IDX_ROW_START)
			->getFont()->setSize(18);
		
		$rowBaseTable	= IDX_ROW_START+4;
		
		// Baris judul
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, $rowBaseTable-1,
				IDX_COL_HOME+TABLE_COLS-1, $rowBaseTable-1)
				->setCellValueByColumnAndRow(IDX_COL_HOME, $rowBaseTable-1,
						"Search field: ".$queryField.", query: \"".$queryText.
						"\" (".$jmlHasil." result, ".$jmlDown." down)");
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, $rowBaseTable,
				IDX_COL_HOME+TABLE_COLS-1, $rowBaseTable)
				->setCellValueByColumnAndRow(IDX_COL_HOME, $rowBaseTable,
						$serverAddr.' | '.date("d m Y, H:i"));
		
		// Baris header tabel
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, $rowBaseTable+1,
				IDX_COL_HOME, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME,$rowBaseTable+1,'AP Name');
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+1, $rowBaseTable+1,
				IDX_COL_HOME+1, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+1,$rowBaseTable+1,'Lokasi');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+2, $rowBaseTable+1,
				IDX_COL_HOME+2, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+2,$rowBaseTable+1,'IP Address');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+3, $rowBaseTable+1,
				IDX_COL_HOME+4, $rowBaseTable+1)
				->setCellValueByColumnAndRow(IDX_COL_HOME+3,$rowBaseTable+1,'MAC Addr');
		$worksheetReport->setCellValueByColumnAndRow(
				IDX_COL_HOME+3,$rowBaseTable+2, 'Eth');
		$worksheetReport->setCellValueByColumnAndRow(
				IDX_COL_HOME+4,$rowBaseTable+2, 'Radio');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+5, $rowBaseTable+1,
				IDX_COL_HOME+6, $rowBaseTable+1)
				->setCellValueByColumnAndRow(IDX_COL_HOME+5,$rowBaseTable+1,'Controller');
		$worksheetReport->setCellValueByColumnAndRow(
				IDX_COL_HOME+5,$rowBaseTable+2, 'Name');
		$worksheetReport->setCellValueByColumnAndRow(
				IDX_COL_HOME+6,$rowBaseTable+2, 'IP');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+7, $rowBaseTable+1,
				IDX_COL_HOME+7, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+7,$rowBaseTable+1,'SN');
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+8, $rowBaseTable+1,
				IDX_COL_HOME+8, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+8,$rowBaseTable+1,'Type');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+9, $rowBaseTable+1,
				IDX_COL_HOME+10, $rowBaseTable+1)
				->setCellValueByColumnAndRow(IDX_COL_HOME+9,$rowBaseTable+1,'Client Count');
		$worksheetReport->setCellValueByColumnAndRow(
				IDX_COL_HOME+9,$rowBaseTable+2, '2,4GHz');
		$worksheetReport->setCellValueByColumnAndRow(
				IDX_COL_HOME+10,$rowBaseTable+2, '5GHz');
		
		// Set border header
		$worksheetReport->getStyleByColumnAndRow(
				IDX_COL_HOME,$rowBaseTable+1,
				IDX_COL_HOME+TABLE_COLS-1,$rowBaseTable+2)
				->applyFromArray($styleHeader)
				->applyFromArray($styleBorderAll)
				->applyFromArray($styleGrayBg);
		
		// Isi body tabel
		$counterItem	= 0;
		$currentRow		= $rowBaseTable + 3;
		foreach ($JSONResult['list_data']['data'] as $itemResult) {
			$counterItem++;
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME, $currentRow, $itemResult->name);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+1, $currentRow, $itemResult->location);
			$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME+1, $currentRow)
				->getAlignment()->setWrapText(true);
			
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+2, $currentRow, $itemResult->ipAddress);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+3, $currentRow, $itemResult->ethernetMac);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+4, $currentRow, $itemResult->macAddress);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+5, $currentRow, $itemResult->controllerName);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+6, $currentRow, $itemResult->controllerIpAddress);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+7, $currentRow, $itemResult->serialNumber);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+8, $currentRow, $itemResult->type);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+9, $currentRow, $itemResult->clientCount_2_4GHz);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+10, $currentRow, $itemResult->clientCount_5GHz);
			if (strtolower($itemResult->controllerName) == "down") {
				$worksheetReport->getStyleByColumnAndRow(
						IDX_COL_HOME,$currentRow,
						IDX_COL_HOME+TABLE_COLS-1,$currentRow)
						->applyFromArray($styleAPDown);
			}
			$currentRow++;
		}
		// Set border untuk seluruh cell
		$worksheetReport->getStyleByColumnAndRow(
				IDX_COL_HOME,$rowBaseTable+1,
				IDX_COL_HOME+TABLE_COLS-1,$currentRow-1)
				->applyFromArray($styleBorderAll);
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$exportFileName.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	} catch (Exception $e) {
		die('[PHPExcel error] '.$e->getMessage()."<br> Trace:<br>".$e->getTraceAsString());
	}
	
}

function do_autelan_export_xlsx($JSONResult, $serverId, $serverAddr, $queryField, $queryText) {
	$CI =& get_instance();

	// load the excel library
	$CI->load->library('excel');

	define('IDX_COL_HOME', 2);	// Kolom dimulai pada kolom ke 3 (index 2)
	define('IDX_ROW_START', 1); // Dimulai dari baris 1
	define('TABLE_COLS', 6);	// Tabel ada 8 kolom

	$jmlHasil	= intval($JSONResult['list_data']['total']);
	$jmlDown	= intval($JSONResult['list_data']['down']);
	$exportFileName = "hasil-pencarian.xlsx";
	$columnWidths = array(
			2,	// [A] Padding
			2,	// [B] Padding
			18,	// [C] Kolom Loc ID
			45,	// [D] Kolom AP Name
			50,	// [E] Kolom Lokasi
			15,	// [F] Kolom IP Address
			18, // [G] Kolom MAC Address
			18	// [H] Kolom Status
	);
	$styleHeader = array(
			'alignment' => array(
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'font'  => array(
					'bold'  => true
			)
	);
	$styleGrayBg = array(
			'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'EEEEEE')
			)
	);
	$styleBorderAll = array(
			'borders' => array(
					'allborders'	=> array(
							'style'		=> PHPExcel_Style_Border::BORDER_THIN
					)
			)
	);
	$styleAlignCenterTop = array(
			'alignment' => array(
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_TOP,
					'wrap'			=> true
			),
	);
	$styleAPDown = array(
			'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'F9BBBC')
			)
	);

	// Generate excel....
	try {
		$objPHPExcel = new PHPExcel();
		$worksheetReport = $objPHPExcel->getActiveSheet();
		$worksheetReport->setTitle('Server '.$serverId." (".$serverAddr.")");

		// Set default alignment ke kiri atas...
		$objPHPExcel->getDefaultStyle()
		->getAlignment()
		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
		->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

		// Set up kolom -----------------------------------
		foreach ($columnWidths as $colIdx => $colWidth) {
			$worksheetReport->getColumnDimensionByColumn($colIdx)->setWidth($colWidth);
		}

		// Judul worksheet pada bagian atas
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, IDX_ROW_START,
				IDX_COL_HOME+TABLE_COLS-1, IDX_ROW_START+1)
				->setCellValueByColumnAndRow(IDX_COL_HOME, IDX_ROW_START, "Hasil Pencarian");

		$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME, IDX_ROW_START)
		->applyFromArray($styleHeader); // Set style
		$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME, IDX_ROW_START)
		->getFont()->setSize(18);

		$rowBaseTable	= IDX_ROW_START+4;

		// Baris judul
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, $rowBaseTable-1,
				IDX_COL_HOME+TABLE_COLS-1, $rowBaseTable-1)
				->setCellValueByColumnAndRow(IDX_COL_HOME, $rowBaseTable-1,
						"Search field: ".$queryField.", query: \"".$queryText.
						"\" (".$jmlHasil." result, ".$jmlDown." down)");

		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, $rowBaseTable,
				IDX_COL_HOME+TABLE_COLS-1, $rowBaseTable)
				->setCellValueByColumnAndRow(IDX_COL_HOME, $rowBaseTable,
						$serverAddr.' | '.date("d m Y, H:i"));

		// Baris header tabel
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, $rowBaseTable+1,
				IDX_COL_HOME, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME,$rowBaseTable+1,'Loc ID');
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+1, $rowBaseTable+1,
				IDX_COL_HOME+1, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+1,$rowBaseTable+1,'AP Name');

		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+2, $rowBaseTable+1,
				IDX_COL_HOME+2, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+2,$rowBaseTable+1,'Lokasi');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+3, $rowBaseTable+1,
				IDX_COL_HOME+3, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+3,$rowBaseTable+1,'IP Address');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+4, $rowBaseTable+1,
				IDX_COL_HOME+4, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+4,$rowBaseTable+1,'MAC Address');
		
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME+5, $rowBaseTable+1,
				IDX_COL_HOME+5, $rowBaseTable+2)
				->setCellValueByColumnAndRow(IDX_COL_HOME+5,$rowBaseTable+1,'Status');

		// Set border header
		$worksheetReport->getStyleByColumnAndRow(
				IDX_COL_HOME,$rowBaseTable+1,
				IDX_COL_HOME+TABLE_COLS-1,$rowBaseTable+2)
				->applyFromArray($styleHeader)
				->applyFromArray($styleBorderAll)
				->applyFromArray($styleGrayBg);

		// Isi body tabel
		$counterItem	= 0;
		$currentRow		= $rowBaseTable + 3;
		foreach ($JSONResult['list_data']['data'] as $itemResult) {
			$counterItem++;
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME, $currentRow, $itemResult->loc_id);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+1, $currentRow, $itemResult->ap_name);
				
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+2, $currentRow, $itemResult->location);
			$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME+2, $currentRow)
			->getAlignment()->setWrapText(true);
			
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+3, $currentRow, $itemResult->ap_ip_address);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+4, $currentRow, $itemResult->mac_address);
			$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+5, $currentRow, $itemResult->status);
			
			if (strtolower($itemResult->status) == "down") {
				$worksheetReport->getStyleByColumnAndRow(
						IDX_COL_HOME,$currentRow,
						IDX_COL_HOME+TABLE_COLS-1,$currentRow)
						->applyFromArray($styleAPDown);
			}
			$currentRow++;
		}
		// Set border untuk seluruh cell
		$worksheetReport->getStyleByColumnAndRow(
				IDX_COL_HOME,$rowBaseTable+1,
				IDX_COL_HOME+TABLE_COLS-1,$currentRow-1)
				->applyFromArray($styleBorderAll);

		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$exportFileName.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	} catch (Exception $e) {
		die('[PHPExcel error] '.$e->getMessage()."<br> Trace:<br>".$e->getTraceAsString());
	}

}