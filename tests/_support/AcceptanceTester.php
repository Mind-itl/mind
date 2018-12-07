<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/

require_once dirname(__DIR__, 2)."/config.php";

class AcceptanceTester extends \Codeception\Actor {
	use _generated\AcceptanceTesterActions;

	public function loginAsStudent() {
		$this->amOnPage("/");
		$this->fillField("login", TEST_STUDENT_LOGIN);
		$this->fillField("password", TEST_STUDENT_PASSWORD);
		$this->click("Войти");
	}

	public function loginAsTeacher() {
		$this->amOnPage("/");
		$this->fillField("login", TEST_TEACHER_LOGIN);
		$this->fillField("password", TEST_TEACHER_PASSWORD);
		$this->click("Войти");
	}

	public function loginAsZam() {
		$this->amOnPage("/");
		$this->fillField("login", TEST_ZAM_LOGIN);
		$this->fillField("password", TEST_ZAM_PASSWORD);
		$this->click("Войти");
	}
}
