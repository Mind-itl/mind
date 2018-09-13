<?php
	require_once "excel/PHPExcel.php";

	abstract class Excel_reader {
		static function load(string $file_name) {
			$x = PHPExcel_IOFactory::load($file_name);
			$x->setActiveSheetIndex(0);
			$sheet = $x->getActiveSheet();
			static::handle($sheet);
		}		
		abstract static function handle(PHPExcel_Worksheet $excel);
	}
?>