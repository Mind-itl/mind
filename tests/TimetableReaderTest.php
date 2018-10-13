<?php
	use PHPUnit\Framework\TestCase;

	require_once "lib/Excel_reader.php";
	require_once "lib/excel_readers/Timetable.php";

	final class TimetableReaderTest extends TestCase {
		/**
		 * @dataProvider providerFiles
		 */
		public function testExcel($file_name, $need): void {
			$assoc = Timetable_excel_reader::load_assoc($file_name);
			// var_dump($assoc);
			$this->assert($assoc, $need);
		}

		public function providerFiles(): array {
			$res = [
				["day" => "Понедельник", "class" => "10-4", "num" => 1, "name" => "Информатика", "place" => "233", "teacher" => "Митясова Е.А."], 
				["teacher" => "Митясова Е.А.", "day" => "Понедельник", "class" => "10-4", "num" => 2, "name" => "Информатика", "place" => "233"],
				["teacher" => "Хузина Ч.В.", "day" => "Понедельник", "class" => "10-4", "num" => 3, "name" => "Английский язык", "place" => "310"],
				["teacher" => "Гараева Л.А", "day" => "Понедельник", "class" => "10-4", "num" => 3, "name" => "Английский язык", "place" => "310"],
				["teacher" => "Фадеев А.В.", "day" => "Понедельник", "class" => "10-4", "num" => 4, "name" => "Математика", "place" => "310"],
				["teacher" => "Макришин В.Н.", "day" => "Понедельник", "class" => "10-4", "num" => 5, "name" => "Физ-ра", "place" => "Спортзал"],
				["teacher" => "Амакаев М.О.", "day" => "Понедельник", "class" => "10-4", "num" => 5, "name" => "Физ-ра", "place" => "Спортзал"],
				["teacher" => "Фадеев А.В.", "day" => "Понедельник", "class" => "10-4", "num" => 6, "name" => "Математика", "place" => "310"]
			];
			return [
				["tests/timetable.xlsx", $res]
			];
		}
	}
?>
