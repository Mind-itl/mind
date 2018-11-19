<?php
	namespace Mind\Db\Excel;

	use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

	abstract class Reader {
		private static function get_get(string $file_name): \Closure {
			$x = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_name);

			$x->setActiveSheetIndex(0);
			$sheet = $x->getActiveSheet();

			$get = function(int $x, int $y) use ($sheet): string {
				$cell = $sheet->getCellByColumnAndRow($x+1, $y+1);

				if (!$cell)
					return "";

				if ($range = $cell->getMergeRange()) {
					$range = Coordinate::splitRange($range)[0][0];
					return $sheet->getCell($range)->getValue() ?? "";
				}

				return $cell->getValue() ?? "";
			};

			return $get;
		}

		public static function load(string $file_name): void {
			static::handle(static::get_get($file_name));
		}

		public static function load_assoc(string $file_name): array {
			$assoc = static::process(static::get_get($file_name));
			return $assoc;
		} 

		abstract protected static function handle(\Closure $get);
		abstract protected static function process(\Closure $get): array;
		abstract public static function get_name(): string;
		
		public static function get_reader_name(string $name): string {
			$x = $name[0];
			$xs = substr($name, 1);

			return "Mind\\Db\Excel\\Readers\\".strtoupper($x).$xs;
		}
	}

?>
