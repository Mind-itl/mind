<?php

class GroupCest {
	public function classrukSeeHisGroup(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Выписка по классу");
		$I->seeInTitle("Выписка по классу");
		$I->see("Баланс класса");
		$I->see(TEST_TEACHER_GROUP);
	}

	public function seeCustomGroup(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage('/group/'.TEST_GROUP);
		$I->see(TEST_GROUP);
		$I->see("Баланс класса");
	}

	public function dontSeeWrongGroup(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage('/group/not-existing-class');
		$I->seeResponseCodeIs(404);
	}
}
