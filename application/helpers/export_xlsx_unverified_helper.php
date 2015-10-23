<?php
function do_export_xlsx_uv($apData, $apType, $apTitle) {
	$CI =& get_instance();

	// load the excel library
	$CI->load->library('excel');

	define('IDX_COL_HOME', 2);	// Kolom dimulai pada kolom ke 3 (index 2)
	define('IDX_ROW_START', 1); // Dimulai dari baris 1
	define('TABLE_COLS', count($apData['list_data']['fields'])-1);	// Tabel ada n-1 kolom
	// Exclude kolom ID

	$jmlHasil	= count($apData);
	$exportFileName = "access-point-".$apType."-".$apTitle.".xlsx";
	
	// Setting lebar kolom
	$columnWidths = array();
	
	if ($apType == "uv") {
		$wrapTextColIdx = array(6,26,27);
		$columnWidths = array( // ======== Setting untuk kolom UV
			2,	// [A] Padding
			2,	// [B] Padding
			15,	// [C] Kolom Witel => Idx 0
			15,	// [D] Kolom Loc_id
			35,	// [E] Kolom AP_Name
			17,	// [F] Kolom MAC Address
			17, // [G] Kolom IP Address
			18,	// [H] Kolom SN
			50,	// [I] Kolom Location => Idx 6
			8,	// [J] Kolom Status
			12,	// [K] Kolom NMS_Source
			15,	// [L] Kolom Countr_name / P_Countr_name
			15	// [M] Kolom Jenis
		);
	} else if ($apType == "divre0") {
		$wrapTextColIdx = array(2);
		$columnWidths = array( // ======== Setting untuk kolom divre0
				2,	// [A] Padding
				2,	// [B] Padding
				20,	// [C] Kolom Loc_id => Idx 0
				42,	// [D] Kolom AP Name
				45,	// [E] Kolom Location
				19,	// [F] Kolom MAC Address
				15, // [G] Kolom IP Address
				15, // [H] Kolom Witel
				19, // [I] Kolom SN
				8,	// [J] Kolom Status
				15,	// [K] Kolom Countr_name / P_Countr_name
				13,	// [L] Kolom Nms_source
				15	// [M] Kolom type
		);
	}
	
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
		$worksheetReport->setTitle("Unverifed AP - ".$apTitle);

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
				IDX_COL_HOME+6, IDX_ROW_START+1)
				->setCellValueByColumnAndRow(IDX_COL_HOME, IDX_ROW_START,
						"Access Point ".$apType." (".$apTitle.")");

		$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME, IDX_ROW_START)
		->applyFromArray($styleHeader); // Set style
		$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME, IDX_ROW_START)
		->getFont()->setSize(18);

		$rowBaseTable	= IDX_ROW_START+3;

		// Baris judul
		$worksheetReport->mergeCellsByColumnAndRow(
				IDX_COL_HOME, $rowBaseTable,
				IDX_COL_HOME+6, $rowBaseTable)
				->setCellValueByColumnAndRow(IDX_COL_HOME, $rowBaseTable,
						$apTitle.' | '.date("d m Y, H:i"));

		// Baris header tabel
		$colIdx = 0;
		$colOffset = 0;
		foreach ($apData['list_data']['fields'] as $field)
		{
			if ($colIdx == 0) {
				$colIdx++;
				continue; // Skip kolom ID
			}
			$worksheetReport
				->setCellValueByColumnAndRow(IDX_COL_HOME+$colOffset,$rowBaseTable+1,$field);
			$colIdx++; $colOffset++;
		}

		// Set border header
		$worksheetReport->getStyleByColumnAndRow(
				IDX_COL_HOME,$rowBaseTable+1,
				IDX_COL_HOME+TABLE_COLS-1,$rowBaseTable+1)
				->applyFromArray($styleHeader)
				->applyFromArray($styleGrayBg)
				->applyFromArray($styleBorderAll);
				

		// Isi body tabel
		$counterItem	= 0;
		$currentRow		= $rowBaseTable + 2;
		foreach ($apData['list_data']['data'] as $itemResult) {
			$colIdx = 0;
			$colOffset = 0;
			foreach ($itemResult as $fieldValue)
			{
				if ($colIdx == 0) {
					$colIdx++;
					continue; // Skip kolom ID
				}
				$worksheetReport->setCellValueByColumnAndRow(
					IDX_COL_HOME+$colOffset, $currentRow, $fieldValue);
				if (in_array($colOffset, $wrapTextColIdx)) { // Khusus cel dengan wrap text
					// Location, Segmen 1, segmen 2
					$worksheetReport->getStyleByColumnAndRow(IDX_COL_HOME+$colOffset, $currentRow)
						->getAlignment()->setWrapText(true);
				}
				$colIdx++; $colOffset++;
			}
			$counterItem++;
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