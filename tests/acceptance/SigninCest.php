<?php

require dirname(__DIR__, 2)."/config.php";

class SigninCest {
	public function _before(AcceptanceTester $I) {
		$I->amOnPage("/");
	}

	public function pageWorks(AcceptanceTester $I) {
		$I->seeInTitle("Войти");
	}

	public function canEnterIfRight(AcceptanceTester $I) {
		$I->fillField("login", TEST_RIGHT_LOGIN);
		$I->fillField("password", TEST_RIGHT_PASSWORD);
		$I->click("Войти");
		$I->see(TEST_RIGHT_NAME);
	}

	public function cantEnterIfWrong(AcceptanceTester $I) {
		$I->fillField("login", "notrightlogin");
		$I->fillField("password", "notrightpassword");
		$I->click("Войти");
		$I->see("Вы ввели неправильный логин или пароль");
	}

	public function cantEnterIfNotCorrect(AcceptanceTester $I) {
		$I->fillField("login", "not.correct123q23123asd   login");
		$I->fillField("password", "not.correct123q23123asd   password");
		$I->click("Войти");
		$I->see("Пароль и логин могут содержать только латинские буквы, цифры и знаки подчёркивания");
	}
}
