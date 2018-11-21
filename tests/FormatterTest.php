<?php
	use PHPUnit\Framework\TestCase;
	use Mind\Db\Excel\Formatter;

	final class FormatterTest extends TestCase {

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
	}
?>
