<?php
	use PHPUnit\Framework\TestCase;
	use Mind\Db\Excel\Formatter;

	final class FormatterTest extends TestCase {
		/**
		 * @dataProvider providerNames
		 */
		public function testName(string $name, string $need): void {
			$this->assertEquals(
				$need,
				Formatter::name($name)
			);
		}

		public function providerNames(): array {
			$right = "Семенов";
			$variants = [
				$right,
				" семенов  ",
				" семеноВ",
				"  семёнов  ",
			];

			$ret = [];
			foreach ($variants as $v) {
				$ret[] = [$v, $right];
			}
			return $ret;
		}

		/**
		 * @dataProvider providerAbbrNames
		 */
		public function testAbbrName(string $name, string $need): void {
			$this->assertEquals(
				$need,
				Formatter::abbr_name($name)
			);
		}

		public function providerAbbrNames(): array {
			$right = "Семенов Р.С.";
			$variants = [
				$right,
				"семенов р.  с.",
				"Семёнов Р С",
				"  сЕМЕНОВ Р. С  ",
				"семенов р.с."
			];

			$ret = [];
			foreach ($variants as $v) {
				$ret[] = [$v, $right];
			}
			return $ret;
		}

		/**
		 * @dataProvider providerGroups
		 */
		public function testGroup(string $group, string $need): void {
			$this->assertEquals(
				$need,
				Formatter::group($group)
			);
		}

		public function providerGroups(): array {
			$right = "10-4";
			$variants = [
				$right,
				"10.4",
				"  10  . 4   ",
				"Класс 10 4.",
				"10 - 4",
				"10--4",
				"10 . 4",
				"10. 4",
				"10 4"
			];

			$ret = [];
			foreach ($variants as $v) {
				$ret[] = [$v, $right];
			}
			return $ret;
		}

		/**
		 * @dataProvider providerDays
		 */
		public function testDay(string $day, string $need): void {
			$this->assertEquals(
				$need,
				Formatter::day($day)
			);
		}

		public function providerDays(): array {
			$right = "Monday";
			$variants = [
				"понедельник",
				"   пОнЕдЕльник "
			];

			$ret = [];
			foreach ($variants as $v) {
				$ret[] = [$v, $right];
			}
			return $ret;
		}

		/**
		 * @dataProvider providerTimes
		 */
		public function testTime(string $time, string $need): void {
			$this->assertEquals(
				$need,
				Formatter::time($time)
			);
		}

		public function providerTimes(): array {
			$right = "10:59";
			$variants = [
				$right,
				"10.59",
				"   10   59 "
			];

			$ret = [];
			foreach ($variants as $v) {
				$ret[] = [$v, $right];
			}
			return $ret;
		}
	}
?>
