<?php

class BroadcastCest {
	public function pageWorksWhenTeacher(AcceptanceTester $I) {
		$I->loginAsTeacher();
		$I->click("Оповестить учеников");
		$I->seeInTitle("Оповестить учеников");
		$I->see("Добавить учеников");
		$I->see("Введите сообщение");
	}

	public function pageDoesntWorkWhenStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/broadcast");
		$I->seeResponseCodeIs(404);
	}

	public function pageDoesntWorkWhenNotLogined(AcceptanceTester $I) {
		$I->amOnPage("/broadcast");
		$I->seeInTitle("Войти");
	}
}
