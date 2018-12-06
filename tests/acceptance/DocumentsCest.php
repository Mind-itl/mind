<?php

require_once dirname(__DIR__, 2)."/config.php";

class DocumentsCest {
	public function _before(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Документы");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Документы\\Сведения");
	}
}
