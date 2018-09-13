<?php
	$LOLOL = "";

	class Timetable extends Excel_reader {
		static function handle(PHPExcel_Worksheet $sheet) {
			$rows = $sheet->getRowIterator();

			$frst = true;
			foreach ($rows as $row) {
				if ($frst) {
					$frst = false;
					continue;
				}
				static::handleRow($row);
			}
		}

		static function handleRow(PHPExcel_Worksheet_Row $row) {
			$values = [];
			foreach ($row->getCellIterator() as $cell) {
				$vl = $cell->getCalculatedValue();
				$values[] = $vl;
			}

			if (!isset($values[0]) || $values[0] === "")
				return;

			$class   = $values[0];
			$weekday = today_en($values[1]);
			$num     = $values[2];
			$lesson  = $values[3];
			$place   = $values[4];
			
			sql_query("
				INSERT INTO lessons (
					CLASS,
					WEEKDAY,
					NUMBER,
					LESSON,
					PLACE
				) VALUES (
					'$class',
					'$weekday',
					 $num,
					'$lesson',
					'$place'
				)\n"
			);
		}
	}
		// 	$rowIterator = $sheet->getRowIterator();
		// 	foreach ($rowIterator as $row) {
		// 	    // Получили ячейки текущей строки и обойдем их в цикле
		// 	    $cellIterator = $row->getCellIterator();
			 
		// 	    echo "<tr>";			         
		// 	    foreach ($cellIterator as $cell) {
		// 	        echo "<td>" . $cell->getCalculatedValue() . "</td>";
		// 	    }
			     
		// 	    echo "</tr>";
		// 	}

		// 	echo $LOLOL;
		// 	exit();
?>