<?php
	use PHPUnit\Framework\TestCase;
	use Mind\Db\Excel\Readers\Timetable;

	final class TimetableReaderTest extends TestCase {
		/**
		 * @dataProvider providerFiles
		 */
		public function testExcel($file_name, $need): void {
			$assoc = Timetable::load_assoc($file_name);
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
				["tests/excel/timetable.xlsx", $res]
			];
		}
	}
?>
