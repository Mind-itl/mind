<?php

class DocumentsCest {
	public function pageWorks(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Документы");
		$I->seeInTitle("Документы\\Сведения");
	}
}
