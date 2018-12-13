<?php

class DocumentsCest {
	public function pageWorksForStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->click("Документы");
		$I->seeInTitle("Документы");
		$I->see("Положение о Совете лицеистов");
		$I->dontSeeElement("input", ["type"=>"submit"]);
	}

	public function pageWorksForZam(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->click("Документы");
		$I->seeInTitle("Документы");
		$I->see("Положение о Совете лицеистов");
		$I->seeElement("input", ["type"=>"submit"]);
	}
}
