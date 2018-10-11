<?php
	abstract class Excel_reader {
		public static function load(string $file_name) {
			$x = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_name);

			$x->setActiveSheetIndex(0);
			$sheet = $x->getActiveSheet();

			$get = function(int $x, int $y) use ($sheet) {
				return $sheet->getCellByColumnAndRow($x, $y);
			};

			static::handle($sheet);
		}		
		abstract protected static function handle(Closure $get);
		abstract public static function get_name(): string;
	}

	function get_reader_name(string $name): string {
		$x = $name[0];
		$xs = substr($name, 1);

		return strtoupper($x).$xs."_excel_reader";
	}
?>
