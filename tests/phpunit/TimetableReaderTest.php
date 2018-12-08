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
				["day"=>"Monday", "class"=>"10-4", "num"=>1, "name"=>"Информатика", "place"=>"233", "teacher"=>"Митясова Е.А.", "time_from"=>"8:00", "time_until"=>"8:40"], 
				["teacher"=>"Митясова Е.А.", "day"=>"Monday", "class"=>"10-4", "num"=>2, "name"=>"Информатика", "place"=>"233","time_from"=>"8:50", "time_until"=>"9:30"],
				["teacher"=>"Хузина Ч.В.", "day"=>"Monday", "class"=>"10-4", "num"=>3, "name"=>"Английский язык", "place"=>"310","time_from"=>"9:40", "time_until"=>"10:20"],
				["teacher"=>"Фадеев А.В.", "day"=>"Monday", "class"=>"10-4", "num"=>4, "name"=>"Математика", "place"=>"310","time_from"=>"10:50", "time_until"=>"11:30"],
				["teacher"=>"Макришин В.Н.", "day"=>"Monday", "class"=>"10-4", "num"=>5, "name"=>"Физ-ра", "place"=>"Спортзал","time_from"=>"11:40", "time_until"=>"12:20"],
				["teacher"=>"Фадеев А.В.", "day"=>"Monday", "class"=>"10-4", "num"=>6, "name"=>"Математика", "place"=>"310","time_from"=>"12:35", "time_until"=>"13:15"]
			];
			return [
				["tests/excel/timetable.xlsx", $res]
			];
		}
	}
?>
