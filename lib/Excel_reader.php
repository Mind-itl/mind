<?php
	abstract class Excel_reader {
		static function load(string $file_name) {
			$x = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_name);

			$x->setActiveSheetIndex(0);
			$sheet = $x->getActiveSheet();

			$get = function(int $x, int $y) use ($sheet) {
				return $sheet->getCellByColumnAndRow($x, $y);
			}

			static::handle($sheet);
		}		
		abstract static function handle(Closure $get);
	}
?>
