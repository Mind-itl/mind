<?php
	use PHPUnit\Framework\TestCase;

	require_once "lib/Excel_reader.php";
	require_once "lib/excel_readers/Timetable.php";

	final class TimetableReaderTest extends TestCase {
		/**
		 * @dataProvider providerNames
		 */
		public function testFormatName(string $name, string $expected): void {
			$this->assertEquals(
				Timetable_excel_reader::format_name($name),
				$expected
			);
		}

		public function providerNames(): array {
			$name = "Митясова Е.А.";
			return [
				["Митясова Е. А", $name],
				["Митясова Е А", $name],
				["Митясова Е   А", $name],
				["Митясова е а", $name]
			];
		}

		/**
		 * @dataProvider providerGroups
		 */
		public function testGroupName(string $group, string $expected): void {
			$this->assertEquals(
				Timetable_excel_reader::format_group($group),
				$expected
			);
		}

		public function providerGroups(): array {
			$group = "10-4";
			return [
				["10.4", $group],
				["10-4", $group],
				["10   4", $group],
				["10 - 4", $group]
			];
		}

		/**
		 * @depends testFormatName
		 * @dataProvider providerFiles
		 */
		public function testExcel($file_name, $need): void {
			$assoc = Timetable_excel_reader::load_assoc($file_name);
			$this->assertEquals($assoc, $need);
		}

		public function providerFiles(): array {
			$res = [
				["day"=>"Monday", "class"=>"10-4", "num"=>1, "name"=>"Информатика", "place"=>"233", "teacher"=>"Митясова Е.А."], 
				["teacher"=>"Митясова Е.А.", "day"=>"Monday", "class"=>"10-4", "num"=>2, "name"=>"Информатика", "place"=>"233"],
				["teacher"=>"Хузина Ч.В.", "day"=>"Monday", "class"=>"10-4", "num"=>3, "name"=>"Английский язык", "place"=>"310"],
				["teacher"=>"Гараева Л.А.", "day"=>"Monday", "class"=>"10-4", "num"=>3, "name"=>"Английский язык", "place"=>"309"],
				["teacher"=>"Фадеев А.В.", "day"=>"Monday", "class"=>"10-4", "num"=>4, "name"=>"Математика", "place"=>"310"],
				["teacher"=>"Макришин В.Н.", "day"=>"Monday", "class"=>"10-4", "num"=>5, "name"=>"Физ-ра", "place"=>"Спортзал"],
				["teacher"=>"Амакаев М.О.", "day"=>"Monday", "class"=>"10-4", "num"=>5, "name"=>"Физ-ра", "place"=>"Спортзал"],
				["teacher"=>"Фадеев А.В.", "day"=>"Monday", "class"=>"10-4", "num"=>6, "name"=>"Математика", "place"=>"310"]
			];
			return [
				["tests/timetable.xlsx", $res]
			];
		}
	}
?>
