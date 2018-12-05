<?php
	use PHPUnit\Framework\TestCase;
	use Mind\Db\Excel\Readers\Duties;

	final class DutiesTest extends TestCase {

		/**
		 * @dataProvider providerFiles
		 */
		public function testExcel($file_name, $need): void {
			$a = Duties::load_assoc($file_name);
			$this->assertEquals($a, $need);
		}

		public function providerFiles(): array {
			return [
				["tests/excel/duties.xlsx", [ [
					"day" => "Monday",
					"login" => "Семенов Р.С.",
					"block" => "4А"
				], [
					"day" => "Monday",
					"login" => "Хащиев Д.И.",
					"block" => "2А"
				], [
					"day" => "Monday",
					"login" => "Ярикжанов И.Р.",
					"block" => "3А"
				], [
					"day" => "Monday",
					"login" => "Салахова А.Р.",
					"block" => "5А"		
				]
				] ]
			];
		}
	}
?>
