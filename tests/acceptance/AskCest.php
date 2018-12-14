<?php

class AskCest {
	public function pageWorksForStudent(AcceptanceTester $I) {
		$I->loginAsStudent();
		$I->amOnPage("/ask");
		$I->seeInTitle("Вопросы");
		$I->seeElement("input", ["value" => "Задать вопрос"]);
		$I->dontSee("Ответить");
	}

	public function pageWorksForZam(AcceptanceTester $I) {
		$I->loginAsZam();
		$I->amOnPage("/ask");
		$I->seeInTitle("Вопросы");
		$I->seeElement("input", ["value" => "Задать вопрос"]);
		$I->see("Ответить");
	}

	public function pageDoesntWorkWhenNotLogined(AcceptanceTester $I) {
		$I->amOnPage("/ask");
		$I->seeInTitle("Войти");
	}
}
