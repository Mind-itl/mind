<?php
	use PHPUnit\Framework\TestCase;
	use Mind\Server\Utils;

	final class UtilsTest extends TestCase {
		/**
		 * @dataProvider providerPoints
		 */
		public function testPoints(int $points, string $expected_noun): void {
			$this->assertEquals($expected_noun, Utils::get_points_case($points));
		}

		public function providerPoints() {
			return [
				[10, "баллов"],
				[1, "балл"],
				[2, "балла"],
				[5, "баллов"],
				[112331, "балл"],
				[-10, "баллов"],
				[234, "балла"],
				[150, "баллов"]
			];
		}
	}
?>
