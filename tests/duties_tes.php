<?php
	use PHPUnit\Framework\TestCase;

	require_once "lib/Excel_reader.php";
	require_once "lib/excel_readers/duties.php";

	final class TimetableReaderTest extends TestCase {

		/**
		 * @dataProvider providerFiles
		 */
		public function testExcel($file_name, $need): void {
			$a = Duties_excel_reader::load_assoc($file_name);
			$this->assertEquals($a, $need);
		}

		public function providerFiles(): array {
			return [
				["tests/duties.xlsx", [ [
					"day" => "Понедельник",
					"login" => "Семенов Р.С.",
					"block" => "4А"
				], [
					"day" => "Понедельник",
					"login" => "Хащиев Д.И.",
					"block" => "2А"		
				], [
					"day" => "Понедельник",
					"login" => "Ярикжанов И.Р.",
					"block" => "3А"
				], [
					"day" => "Понедельник",
					"login" => "Салахова А.Р.",
					"block" => "5А"		
				]
				] ]
			];
		}
	}
?>
